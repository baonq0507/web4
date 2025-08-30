<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\ConfigPayment;
use App\Models\ConfigSystem;
use Pusher\Pusher;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('created_at', 'desc')
        ->with(['user' => function($query){
            $query->with('banks');
        }, 'bank'])
        ->paginate(20);
        $users = User::orderBy('created_at', 'desc')->where('status', 'active')->get();
        $banks = ConfigPayment::orderBy('created_at', 'desc')->where('status', 'show')->get();
        $config_fee_withdraw = ConfigSystem::where('key', 'fee_withdraw')->first();
        return view('cpanel.transactions.index', compact('transactions', 'users', 'banks', 'config_fee_withdraw'));
    }

    public function show(Request $request, $id)
    {
        $transaction = Transaction::with([
            'user' => function($query){
                $query->with('banks', 'usdt');
            }
        ])->find($id);
        if(!$transaction){
            return response()->json(['message' => __('messages.not_found')], 404);
        }
        return response()->json($transaction);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        if(!$transaction){
            return response()->json(['message' => __('messages.not_found')], 404);
        }
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:success,failed,canceled,pending',
        ], [
            'status.required' => __('index.status_required'),
            'status.in' => __('index.status_in'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $transaction->update([
            'status' => $request->status,
        ]);
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ]);

        if ($request->status == 'success') {
            $user = User::find($transaction->user_id);
            if (!$user) return; // Tránh lỗi nếu user không tồn tại

            if ($transaction->type == 'deposit') {
                $user->balance += $transaction->amount;
                $user->save();
        
                if ($user->referral_parent_id) {
                    // Kiểm tra nếu đây là lần nạp đầu tiên
                    $firstDeposit = !$user->transactions()
                        ->where('type', 'deposit')
                        ->where('status', 'success')
                        ->where('id', '!=', $transaction->id)
                        ->exists();
        
                    if ($firstDeposit) {
                        $referralParent = User::find($user->referral_parent_id);
                        if ($referralParent) {
                            $bonus_f1 = ConfigSystem::where('key', 'bonus_f1')->value('value') ?? 10;
                            $referralParent->increment('balance', $bonus_f1);
                        }
                    }
                }
        
                $pusher->trigger('transaction-channel.' . $transaction->user_id, 'deposit_success', [
                    'amount' => $transaction->amount
                ]);
            } elseif ($transaction->type == 'withdraw') {
                $pusher->trigger('transaction-channel.' . $transaction->user_id, 'withdraw_success', [
                    'amount' => $transaction->amount
                ]);
            }
        } else if($request->status == 'failed'){
            if($transaction->type == 'withdraw'){
                $user = User::find($transaction->user_id);
                $user->increment('balance', $transaction->amount);
            }
        }

        return response()->json(['message' => __('index.success')]);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return response()->json($transaction);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_id_to' => 'nullable',
            'type' => 'required|in:deposit,withdraw,transfer,bet,win,fee,other,deduct,add',
            'amount' => 'required|numeric|min:0',
            'bank_id' => 'nullable',
            'status' => 'required|in:success,failed,canceled,pending',
            'note' => 'nullable',
        ], [
            'user_id.required' => __('index.user_id_required'),
            'type.required' => __('index.type_required'),
            'amount.required' => __('index.amount_required'),
            'bank_id.required' => __('index.bank_id_required'),
            'amount.numeric' => __('index.amount_numeric'),
            'amount.min' => __('index.amount_min'),
            'bank_id.numeric' => __('index.bank_id_numeric'),
            'status.required' => __('index.status_required'),
            'status.in' => __('index.status_in'),
            'note.nullable' => __('index.note_nullable'),
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user = User::findOrFail($request->user_id);
        $data = $request->all();
    
        $data['before_balance'] = $user->balance;
    
        if($request->type == 'deposit' || $request->type == 'add'){
            $data['after_balance'] = $user->balance + $request->amount;
        }else if($request->type == 'withdraw' || $request->type == 'deduct'){
            $data['after_balance'] = $user->balance - $request->amount;
        }

        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ]);

        if($request->status == 'success'){
            $user->balance = $data['after_balance'];
            $user->save();

            if($request->type == 'deposit'){
                $pusher->trigger('transaction-channel.' . $user->id, 'deposit_success', [
                    'amount' => $request->amount
                ]);
            }else if($request->type == 'withdraw'){
                $pusher->trigger('transaction-channel.' . $user->id, 'withdraw_success', [
                    'amount' => $request->amount
                ]);
            }
        }

        Transaction::create($data);
        return response()->json(['message' => __('index.success')]);
    }

    public function withdraw(Request $request)
    {
        $users = User::orderBy('created_at', 'desc')->where('status', 'active')->get();
        $banks = ConfigPayment::orderBy('created_at', 'desc')->where('status', 'show')->get();
        $config_fee_withdraw = ConfigSystem::where('key', 'fee_withdraw')->first();
        $transactions = Transaction::where('type', 'withdraw')
        ->with(['user' => function($query){
            $query->with('banks');
        }, 'bank'])
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        return view('cpanel.transactions.withdraw', compact('transactions', 'users', 'banks', 'config_fee_withdraw'));
    }

    public function deposit(Request $request)
    {
        $users = User::orderBy('created_at', 'desc')->where('status', 'active')->get();
        $banks = ConfigPayment::orderBy('created_at', 'desc')->where('status', 'show')->get();
        $transactions = Transaction::where('type', 'deposit')
        ->with(['user', 'bank'])
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        return view('cpanel.transactions.deposit', compact('transactions', 'users', 'banks'));
    }
    
}
