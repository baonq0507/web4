<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')
            ->with('roles')
            ->get();
        $role = auth()->user()->roles->first()->name;
        if($role != 'admin') {
            $users = User::orderBy('id', 'desc')
                ->with('roles')
                ->where('referral_parent_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->where('id', '!=', 1)
                ->get();
        } else {
            $users = User::orderBy('id', 'desc')->where('id', '!=', 1)->get();
        }
        return view('cpanel.user.index', compact('users', 'role'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:8',
        ], [
            'email.unique' => __('index.email_already_exists'),
            'username.unique' => __('index.username_already_exists'),
            'password.min' => __('index.password_min'),
            'name.required' => __('index.name_required'),
            'email.required' => __('index.email_required'),
            'username.required' => __('index.username_required'),
            'password.required' => __('index.password_required'),
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => __('index.created_successfully')], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
        ], [
            'username.unique' => __('index.username_already_exists'),
            'name.required' => __('index.name_required'),
            'username.required' => __('index.username_required'),
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::find($id);

        if($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        $user->update($request->all());
        return response()->json(['message' => __('index.updated_successfully')], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        // xóa các thứ liên quan đến user
        $user->referrals()->update(['referral_parent_id' => null]);
        $user->transactions()->delete();
        $user->user_trade()->delete();
        $user->banks()->delete();
        $user->usdt()->delete();
        $user->invests()->delete();
        $user->user_kycs()->delete();
        $user->delete();
        return response()->json(['message' => __('index.delete_user')], 200);
    }

    public function show($id)
    {
        $user = User::with(['referrals', 'roles', 'vipLevel', 'transactions' => function($query) {
            $query->orderBy('created_at', 'desc');
            $query->limit(10);
        }, 'user_trade' => function($query) {
            $query->orderBy('created_at', 'desc');
            $query->limit(10);
        }, 'banks', 'usdt'])->find($id);
        $roles = Role::all();
        $vipLevels = \App\Models\VipLevel::orderBy('level', 'asc')->get();

        return view('cpanel.user.show', compact('user', 'roles', 'vipLevels'));
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ], [
            'password.min' => __('index.password_min'),
            'password.required' => __('index.password_required'),
            'password_confirmation.required' => __('index.password_confirmation_required'),
            'password_confirmation.same' => __('index.password_confirmation_same'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(['message' => __('index.password_changed_successfully')], 200);
    }

    public function logoutUser($id)
    {
        $user = User::find($id);

        $push = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ]);
        $push->trigger('logout-channel.' . $user->id, 'logout', ['message' => __('index.logout_successfully')]);
        DB::table('sessions')->where('user_id', $user->id)->delete();

        return response()->json(['message' => __('index.logout_successfully')], 200);
    }

    public function blockTrade($id)
    {
        $user = User::find($id);
        $user->block_trade = true;
        $user->save();
        return response()->json(['message' => __('index.block_trade_successfully')], 200);
    }

    public function blockWithdraw($id)
    {
        $user = User::find($id);
        $user->block_withdraw = true;
        $user->save();
        return response()->json(['message' => __('index.block_withdraw_successfully')], 200);
    }

    public function unblockTrade($id)
    {
        $user = User::find($id);
        $user->block_trade = false;
        $user->save();
        return response()->json(['message' => __('index.unblock_trade_successfully')], 200);
    }

    public function unblockWithdraw($id)
    {
        $user = User::find($id);
        $user->block_withdraw = false;
        $user->save();
        return response()->json(['message' => __('index.unblock_withdraw_successfully')], 200);
    }

    public function updateBalance(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'balance' => 'required|numeric|min:0',
        ], [
            'balance.required' => __('index.balance_required'),
            'balance.numeric' => __('index.balance_must_be_numeric'),
            'balance.min' => __('index.balance_must_be_positive'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user = User::find($id);
        $user->balance = $request->balance;
        $user->save();

        return response()->json(['message' => __('index.balance_updated_successfully')], 200);
    }

    public function updateRatio(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ratio' => 'required|numeric|min:0|max:100',
        ], [
            'ratio.required' => __('index.ratio_required'),
            'ratio.numeric' => __('index.ratio_must_be_numeric'),
            'ratio.min' => __('index.ratio_must_be_positive'),
            'ratio.max' => __('index.ratio_must_be_less_than_100'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user = User::find($id);
        $user->ratio = $request->ratio;
        $user->save();

        return response()->json(['message' => __('index.ratio_updated_successfully')], 200);
    }

    public function employee()
    {
        $users = User::whereHas('roles', function($query) {
            $query->where('name', 'employee');
            $query->orWhere('name','Nhân viên');
            $query->orWhere('name','NHÂN VIÊN');
        })->get();
        return view('cpanel.user.employee', compact('users'));
    }
}
