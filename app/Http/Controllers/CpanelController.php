<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;
use App\Models\Transaction;
use App\Models\UserTrade;
class CpanelController extends Controller
{
    public function dashboard(Request $request)
    {
        $range = $request->range;
        $count_user = User::count();
        $count_trade = UserTrade::count();
        $count_trade_win = UserTrade::where('result', 'win')->count();
        $count_trade_lose = UserTrade::where('result', 'lose')->count();
        $count_trade_lose = UserTrade::where('result', 'lose')->count();

        $count_transaction_deposit = Transaction::where('type', 'deposit')->sum('amount');
        $count_transaction_withdraw = Transaction::where('type', 'withdraw')->sum('amount');
        $total_transaction = $count_transaction_deposit - $count_transaction_withdraw;

        //ấy ra 10 user có nạp tiền nhiều nhất
        $top_user_deposit = Transaction::where('type', 'deposit')
        ->selectRaw('user_id, SUM(amount) as total_deposit')
        ->groupBy('user_id')
        ->with(['user'])
        ->orderBy('total_deposit', 'desc')->limit(10)->get();
        switch ($range) {
            case 'last30day':
                $range = 'last 30 days';
                $count_user = User::count();
                $count_trade = UserTrade::where('created_at', '>=', now()->subDays(30))->count();
                $count_trade_win = UserTrade::where('result', 'win')->where('created_at', '>=', now()->subDays(30))->count();
                $count_trade_lose = UserTrade::where('result', 'lose')->where('created_at', '>=', now()->subDays(30))->count();
                $count_transaction_deposit = Transaction::where('type', 'deposit')->where('created_at', '>=', now()->subDays(30))->sum('amount');
                $count_transaction_withdraw = Transaction::where('type', 'withdraw')->where('created_at', '>=', now()->subDays(30))->sum('amount');
                $total_transaction = $count_transaction_deposit - $count_transaction_withdraw;
                break;
            case 'thisweek':
                $range = 'this week';
                $count_user = User::count();
                $count_trade = UserTrade::where('created_at', '>=', now()->startOfWeek())->where('created_at', '<=', now()->endOfWeek())->count();
                $count_trade_win = UserTrade::where('result', 'win')->where('created_at', '>=', now()->startOfWeek())->where('created_at', '<=', now()->endOfWeek())->count();
                $count_trade_lose = UserTrade::where('result', 'lose')->where('created_at', '>=', now()->startOfWeek())->where('created_at', '<=', now()->endOfWeek())->count();
                $count_transaction_deposit = Transaction::where('type', 'deposit')->where('created_at', '>=', now()->startOfWeek())->where('created_at', '<=', now()->endOfWeek())->sum('amount');
                $count_transaction_withdraw = Transaction::where('type', 'withdraw')->where('created_at', '>=', now()->startOfWeek())->where('created_at', '<=', now()->endOfWeek())->sum('amount');
                $total_transaction = $count_transaction_deposit - $count_transaction_withdraw;
                break;
            case 'lastweek':
                $range = 'last week';
                $count_user = User::count();
                $count_trade = UserTrade::where('created_at', '>=', now()->subWeek())->count();
                $count_trade_win = UserTrade::where('result', 'win')->where('created_at', '>=', now()->subWeek())->count();
                $count_trade_lose = UserTrade::where('result', 'lose')->where('created_at', '>=', now()->subWeek())->count();
                $count_transaction_deposit = Transaction::where('type', 'deposit')->where('created_at', '>=', now()->subWeek())->sum('amount');
                $count_transaction_withdraw = Transaction::where('type', 'withdraw')->where('created_at', '>=', now()->subWeek())->sum('amount');
                $total_transaction = $count_transaction_deposit - $count_transaction_withdraw;
                break;
            case 'thismonth':
                $range = 'this month';
                $count_user = User::count();
                $count_trade = UserTrade::where('created_at', '>=', now()->startOfMonth())->where('created_at', '<=', now()->endOfMonth())->count();
                $count_trade_win = UserTrade::where('result', 'win')->where('created_at', '>=', now()->startOfMonth())->where('created_at', '<=', now()->endOfMonth())->count();
                $count_trade_lose = UserTrade::where('result', 'lose')->where('created_at', '>=', now()->startOfMonth())->where('created_at', '<=', now()->endOfMonth())->count();
                $count_transaction_deposit = Transaction::where('type', 'deposit')->where('created_at', '>=', now()->startOfMonth())->where('created_at', '<=', now()->endOfMonth())->sum('amount');
                $count_transaction_withdraw = Transaction::where('type', 'withdraw')->where('created_at', '>=', now()->startOfMonth())->where('created_at', '<=', now()->endOfMonth())->sum('amount');
                $total_transaction = $count_transaction_deposit - $count_transaction_withdraw;
                break;
            case 'lastmonth':
                $range = 'last month';
                $count_user = User::count();
                $count_trade = UserTrade::where('created_at', '>=', now()->subMonth())->count();
                $count_trade_win = UserTrade::where('result', 'win')->where('created_at', '>=', now()->subMonth())->count();
                $count_trade_lose = UserTrade::where('result', 'lose')->where('created_at', '>=', now()->subMonth())->count();
                $count_transaction_deposit = Transaction::where('type', 'deposit')->where('created_at', '>=', now()->subMonth())->sum('amount');
                $count_transaction_withdraw = Transaction::where('type', 'withdraw')->where('created_at', '>=', now()->subMonth())->sum('amount');
                break;
            case 'today':
                $range = 'today';
                $count_user = User::count();
                $count_trade = UserTrade::where('created_at', '>=', now()->today())->count();
                $count_trade_win = UserTrade::where('result', 'win')->where('created_at', '>=', now()->today())->count();
                $count_trade_lose = UserTrade::where('result', 'lose')->where('created_at', '>=', now()->today())->count();
                $count_transaction_deposit = Transaction::where('type', 'deposit')->where('created_at', '>=', now()->today())->sum('amount');
                $count_transaction_withdraw = Transaction::where('type', 'withdraw')->where('created_at', '>=', now()->today())->sum('amount');
                $total_transaction = $count_transaction_deposit - $count_transaction_withdraw;
                break;
            default:
                $range = 'last 30 days';
                break;
        }

        return view('cpanel.dashboard', compact('count_user', 'count_trade', 'count_trade_win', 'count_trade_lose', 'count_transaction_deposit', 'top_user_deposit', 'count_transaction_withdraw', 'total_transaction'));
    }

    public function changeLanguage(Request $request, $lang)
    {
        session(['language-admin' => $lang]);
        return redirect()->back();
    }

    public function profile(Request $request)
    {
        return view('cpanel.profile');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6',
            'new_password_confirmation' => 'required|string|min:6|same:new_password',
        ], [
            'current_password.required' => __('index.current_password_required'),
            'current_password.string' => __('index.current_password_string'),
            'new_password.required' => __('index.new_password_required'),
            'new_password.string' => __('index.new_password_string'),
            'new_password.min' => __('index.new_password_min', ['min' => 6]),
            'new_password_confirmation.required' => __('index.new_password_confirmation_required'),
            'new_password_confirmation.string' => __('index.new_password_confirmation_string'),
            'new_password_confirmation.min' => __('index.new_password_confirmation_min', ['min' => 6]),
            'new_password_confirmation.same' => __('index.new_password_confirmation_same'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => __('index.current_password_incorrect'),
            ], 401);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => __('index.password_updated'),
        ], 200);
    }

    public function login(Request $request)
    {
        return view('cpanel.auth.login');
    }

    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ],[
            'username.required' => __('index.username_required'),
            'username.string' => __('index.username_string'),
            'password.required' => __('index.password_required'),
            'password.string' => __('index.password_string'),
            'password.min' => __('index.password_min' , ['min' => 6]),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => __('index.username_not_found'),
            ], 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => __('index.password_incorrect'),
            ], 401);
        }

        Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => __('index.login_success'),
        ], 200);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function updatePasswordWithdraw(Request $request, $user)
    {
        $validator = Validator::make($request->all(), [
            'password_withdraw' => 'required|string|min:6',
            'password_withdraw_confirmation' => 'required|string|min:6|same:password_withdraw',
        ], [
            'password_withdraw.required' => __('index.password_withdraw_required'),
            'password_withdraw.string' => __('index.password_withdraw_string'),
            'password_withdraw.min' => __('index.password_withdraw_min', ['min' => 6]),
            'password_withdraw_confirmation.required' => __('index.password_withdraw_confirmation_required'),
            'password_withdraw_confirmation.string' => __('index.password_withdraw_confirmation_string'),
            'password_withdraw_confirmation.min' => __('index.password_withdraw_confirmation_min', ['min' => 6]),
            'password_withdraw_confirmation.same' => __('index.password_withdraw_confirmation_same'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = User::find($user);
        $user->password_withdraw = Hash::make($request->password_withdraw);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => __('index.password_updated'),
        ], 200);
    }
}
