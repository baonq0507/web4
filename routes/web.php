<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CpanelController;
use App\Http\Controllers\Cpanel\GrantRoleController;
use App\Http\Controllers\Cpanel\SymbolController;
use App\Http\Controllers\Cpanel\UserController;
use App\Http\Controllers\Cpanel\TransactionController;
use App\Http\Controllers\Cpanel\ConfigPaymentController;
use App\Http\Controllers\Cpanel\KycController;
use App\Http\Controllers\Cpanel\OrderController;
use App\Http\Controllers\Cpanel\SystemConfigurationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Cpanel\ProjectController;
use App\Http\Controllers\Cpanel\PostController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Cpanel\InvestmentController;
use App\Http\Controllers\BitgetEarningController;
use App\Http\Controllers\CopyTradingController;
use App\Http\Controllers\Cpanel\TimeSessionController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\User\AboutMeController;
use App\Http\Controllers\Cpanel\KyQuyController;
use App\Http\Controllers\SpotTradingController;
Route::middleware('language')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/login', [HomeController::class, 'index'])->name('login');
    Route::get('/ky-quy', [HomeController::class, 'kyQuy'])->name('ky-quy');

    Route::get('/bitget-earning', [BitgetEarningController::class, 'index'])->name('bitget.earning');
    Route::get('/copy-trading/overview', [CopyTradingController::class, 'overview'])->name('overview');
    Route::get('/register', [UserController::class, 'register'])->name('register');
    Route::post('/register', [HomeController::class, 'registerPost'])->name('registerPost');
    Route::post('/send-verification-code', [App\Http\Controllers\EmailVerificationController::class, 'sendVerificationCode'])->name('send.verification.code');
    Route::post('/verify-email-code', [App\Http\Controllers\EmailVerificationController::class, 'verifyCode'])->name('verify.email.code');
    Route::post('/login', [HomeController::class, 'loginPost'])->name('loginPost');
    Route::get('/about-me', [AboutMeController::class, 'index'])->name('about.me');
Route::get('/msb', [AboutMeController::class, 'msb'])->name('msb');
Route::get('/load-more-symbols', [App\Http\Controllers\SymbolController::class, 'loadMore'])->name('load.more.symbols');
    Route::middleware('customeAuth')->group(function () {
        Route::get('/trade', [HomeController::class, 'trade'])->name('trade');
        Route::post('/upload', [HomeController::class, 'upload'])->name('upload');
        Route::get('/kyc', [HomeController::class, 'kyc'])->name('kyc');
        Route::post('/update-kyc', [HomeController::class, 'updateKyc'])->name('update-kyc');
        Route::post('/update-bank', [HomeController::class, 'updateBank'])->name('update-bank');
        Route::post('/update-usdt', [HomeController::class, 'updateUsdt'])->name('update-usdt');
        Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
        Route::post('/change-password2', [HomeController::class, 'changePassword2'])->name('change-password2');
        Route::post('/upload-avatar', [HomeController::class, 'uploadAvatar'])->name('upload-avatar');
        Route::post('/deposit-post', [HomeController::class, 'depositPost'])->name('depositPost');
        Route::get('/deposit', [HomeController::class, 'deposit'])->name('deposit');
        Route::post('/withdraw-post', [HomeController::class, 'withdrawPost'])->name('withdrawPost');
        Route::get('/withdraw', [HomeController::class, 'withdraw'])->name('withdraw');
        Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
        Route::post('/trading-place', [HomeController::class, 'tradingPlace'])->name('tradingPlace');
        Route::get('/banklist', [HomeController::class, 'banklist'])->name('banklist');
        Route::post('/add-bank', [HomeController::class, 'addBank'])->name('addBank');
        Route::delete('/delete-bank', [HomeController::class, 'deleteBank'])->name('deleteBank');
        Route::post('/invest', [HomeController::class, 'invest'])->name('invest');
        Route::get('/referred-users', [HomeController::class, 'referredUsers'])->name('referred-users');
        Route::get('/load-more-referred-users', [HomeController::class, 'loadMoreReferredUsers'])->name('load-more-referred-users');
        Route::post('/open-ky-quy', [HomeController::class, 'openKyQuy'])->name('open-ky-quy');
        Route::get('/password-withdraw', [HomeController::class, 'passwordWithdraw'])->name('password-withdraw');
        Route::post('/change-password-withdraw', [HomeController::class, 'changePasswordWithdraw'])->name('password-withdraw.update');
        Route::post('/final-settlement', [HomeController::class, 'finalSettlement'])->name('final-settlement');
    });
    Route::get('/trading', [HomeController::class, 'trading'])->name('trading');
    Route::get('/projects', [HomeController::class, 'projects'])->name('projects');
    Route::get('/market', [HomeController::class, 'market'])->name('market');
    Route::get('/load-more-trades', [HomeController::class, 'loadMoreTrades'])->name('loadMoreTrades');
            Route::get('/load-more-deposit-history', [HomeController::class, 'loadMoreDepositHistory'])->name('loadMoreDepositHistory');
        Route::get('/load-more-withdraw-history', [HomeController::class, 'loadMoreWithdrawHistory'])->name('loadMoreWithdrawHistory');
        
        // Spot Trading Routes
        Route::get('/spot-trading', [SpotTradingController::class, 'index'])->name('spot-trading');
        Route::post('/spot-trading/place-order', [SpotTradingController::class, 'placeOrder'])->name('spot-trading.place-order');
        Route::post('/spot-trading/cancel-order/{id}', [SpotTradingController::class, 'cancelOrder'])->name('spot-trading.cancel-order');
    });
Route::middleware('languageAdmin')->group(function () {
    Route::group(['prefix' => 'admin', 'as' => 'cpanel.'], function () {
        Route::get('/login', [CpanelController::class, 'login'])->name('login');
        Route::post('/post-login', [CpanelController::class, 'postLogin'])->name('postLogin');
        
        Route::middleware(['admin', 'can:is_cpanel'])->group(function () {
            Route::get('/', [CpanelController::class, 'dashboard'])->name('index');
            Route::get('/change-language/{lang}', [CpanelController::class, 'changeLanguage'])->name('change-language');
            Route::get('/dashboard', [CpanelController::class, 'dashboard'])->name('dashboard');
            Route::get('/profile', [CpanelController::class, 'profile'])->name('profile');
            Route::post('/password/update', [CpanelController::class, 'updatePassword'])->name('password.update');
            Route::middleware('can:grant_role')->group(function () {
                Route::get('/grant-role', [GrantRoleController::class, 'grantRole'])->name('grant-role');
                Route::post('/grant-role/store', [GrantRoleController::class, 'postGrantRole'])->name('grant-role.store');
                Route::delete('/grant-role/destroy/{role}', [GrantRoleController::class, 'destroyGrantRole'])->name('grant-role.destroy');
                Route::get('/grant-role/show/{role}', [GrantRoleController::class, 'showGrantRole'])->name('grant-role.show');
                Route::put('/grant-role/update/{role}', [GrantRoleController::class, 'updateGrantRole'])->name('grant-role.update');
                Route::put('/grant-role/assign/{role}', [GrantRoleController::class, 'assignPermission'])->name('grant-role.assign');
            });

            Route::middleware('can:view_symbols')->group(function () {
                Route::get('/symbols', [SymbolController::class, 'symbols'])->name('symbols');
                Route::post('/symbols/store', [SymbolController::class, 'storeSymbol'])->name('symbols.store')->middleware('can:create_symbol');
                Route::get('/symbols/show/{symbol}', [SymbolController::class, 'showSymbol'])->name('symbols.show')->middleware('can:edit_symbol');
                Route::put('/symbols/update/{symbol}', [SymbolController::class, 'updateSymbol'])->name('symbols.update')->middleware('can:edit_symbol');
                Route::delete('/symbols/destroy/{symbol}', [SymbolController::class, 'destroySymbol'])->name('symbols.destroy')->middleware('can:delete_symbol');
            });

            Route::middleware('can:view_users')->group(function () {
                Route::get('/user', [UserController::class, 'index'])->name('user');
                Route::post('/user/store', [UserController::class, 'store'])->name('user.store')->middleware('can:create_user');
                Route::get('/user/show/{user}', [UserController::class, 'show'])->name('user.show')->middleware('can:edit_user');
                Route::put('/user/update/{user}', [UserController::class, 'update'])->name('user.update')->middleware('can:edit_user');
                Route::delete('/user/destroy/{user}', [UserController::class, 'destroy'])->name('user.destroy')->middleware('can:delete_user');
                Route::put('/user/change-password/{user}', [UserController::class, 'changePassword'])->name('user.change-password')->middleware('can:edit_user');
                Route::post('/user/logout/{user}', [UserController::class, 'logoutUser'])->name('user.logout')->middleware('can:edit_user');
                Route::post('/user/block-trade/{user}', [UserController::class, 'blockTrade'])->name('user.block-trade')->middleware('can:edit_user');
                Route::post('/user/block-withdraw/{user}', [UserController::class, 'blockWithdraw'])->name('user.block-withdraw')->middleware('can:edit_user');
                Route::post('/user/unblock-trade/{user}', [UserController::class, 'unblockTrade'])->name('user.unblock-trade')->middleware('can:edit_user');
                Route::post('/user/unblock-withdraw/{user}', [UserController::class, 'unblockWithdraw'])->name('user.unblock-withdraw')->middleware('can:edit_user');
                Route::put('/user/update-balance/{user}', [UserController::class, 'updateBalance'])->name('user.update-balance')->middleware('can:edit_user');
                Route::put('/user/update-ratio/{user}', [UserController::class, 'updateRatio'])->name('user.update-ratio')->middleware('can:edit_user');
                Route::get('/employee', [UserController::class, 'employee'])->name('employee');
                Route::put('/user/password/update-withdraw/{user}', [CpanelController::class, 'updatePasswordWithdraw'])->name('user.password.update-withdraw')->middleware('can:edit_user');
            });

            Route::middleware('can:view_transactions')->group(function () {
                Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
                Route::get('/transactions/show/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
                Route::put('/transactions/update/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
                Route::delete('/transactions/destroy/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
                Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
                Route::get('/transactions/withdraw', [TransactionController::class, 'withdraw'])->name('transactions.withdraw')->middleware('can:view_withdrawals');
                Route::get('/transactions/deposit', [TransactionController::class, 'deposit'])->name('transactions.deposit')->middleware('can:view_deposits');
            });

            Route::middleware('can:view_banks')->group(function () {
                Route::get('/banks', [ConfigPaymentController::class, 'index'])->name('banks');
                Route::post('/banks/store', [ConfigPaymentController::class, 'store'])->name('banks.store');
                Route::get('/banks/show/{bank}', [ConfigPaymentController::class, 'show'])->name('banks.show');
                Route::put('/banks/update/{bank}', [ConfigPaymentController::class, 'update'])->name('banks.update');
                Route::delete('/banks/destroy/{bank}', [ConfigPaymentController::class, 'destroy'])->name('banks.destroy');
            });

            Route::middleware('can:view_users')->group(function () {
                Route::get('/kycs', [KycController::class, 'index'])->name('kycs');
                Route::post('/kycs/store', [KycController::class, 'store'])->name('kycs.store');
                Route::put('/kycs/update/{kyc}', [KycController::class, 'update'])->name('kycs.update');
                Route::delete('/kycs/destroy/{kyc}', [KycController::class, 'destroy'])->name('kycs.destroy');
            });

            Route::middleware('can:view_orders')->group(function () {
                Route::get('/orders', [OrderController::class, 'index'])->name('orders');
            });

            Route::middleware('can:view_config_system')->group(function () {
                Route::get('/system-configuration', [SystemConfigurationController::class, 'index'])->name('system-configuration');
                Route::post('/system-configuration/save', [SystemConfigurationController::class, 'save'])->name('system-configuration.save');
            });

            // Route::middleware('can:view_projects')->group(function () {
                Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
                Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
                Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store');
                Route::get('/projects/edit/{project}', [ProjectController::class, 'edit'])->name('projects.edit');
                Route::put('/projects/update/{project}', [ProjectController::class, 'update'])->name('projects.update');
                Route::resource('posts', PostController::class);
                Route::post('/posts/send-notification/{post}', [PostController::class, 'sendNotification'])->name('posts.send-notification');
            // });

            // Route::middleware('can:view_investments')->group(function () {
                Route::get('/investments', [InvestmentController::class, 'index'])->name('investments.index');
                Route::get('/investments/{investment}', [InvestmentController::class, 'show'])->name('investments.show');
                Route::put('/investments/{investment}', [InvestmentController::class, 'update'])->name('investments.update');
                Route::delete('/investments/{investment}', [InvestmentController::class, 'destroy'])->name('investments.destroy');
            // });

            // Time Session Routes
            // Route::middleware('can:view_time_sessions')->group(function () {
                Route::get('/time-sessions', [TimeSessionController::class, 'index'])->name('time-sessions.index');
                Route::get('/time-sessions/create', [TimeSessionController::class, 'create'])->name('time-sessions.create');
                Route::post('/time-sessions', [TimeSessionController::class, 'store'])->name('time-sessions.store');
                Route::get('/time-sessions/{timeSession}/edit', [TimeSessionController::class, 'edit'])->name('time-sessions.edit');
                Route::put('/time-sessions/{timeSession}', [TimeSessionController::class, 'update'])->name('time-sessions.update');
                Route::delete('/time-sessions/{timeSession}', [TimeSessionController::class, 'destroy'])->name('time-sessions.destroy');
            // });
            Route::put('/orders/edit-result/{id}', [OrderController::class, 'editResult'])->name('orders.edit-result');
            Route::get('/ky-quies', [KyQuyController::class, 'index'])->name('ky-quies.index');
            Route::get('/ky-quies/create', [KyQuyController::class, 'create'])->name('ky-quies.create');
            Route::post('/ky-quies/store', [KyQuyController::class, 'store'])->name('ky-quies.store');
            Route::get('/ky-quies/edit/{id}', [KyQuyController::class, 'edit'])->name('ky-quies.edit');
            Route::put('/ky-quies/update/{id}', [KyQuyController::class, 'update'])->name('ky-quies.update');
            Route::delete('/ky-quies/destroy/{id}', [KyQuyController::class, 'destroy'])->name('ky-quies.destroy');
            Route::get('/ky-quy-users', [KyQuyController::class, 'kyQuyUsers'])->name('ky-quy-users.index');
            Route::get('/ky-quy-users/edit/{id}', [KyQuyController::class, 'kyQuyUserEdit'])->name('ky-quy-users.edit');
            Route::put('/ky-quy-users/update/{id}', [KyQuyController::class, 'kyQuyUserUpdate'])->name('ky-quy-users.update');
            Route::delete('/ky-quy-users/destroy/{id}', [KyQuyController::class, 'kyQuyUserDestroy'])->name('ky-quy-users.destroy');
            Route::post('/ky-quy-users/approve/{id}', [KyQuyController::class, 'kyQuyUserApprove'])->name('ky-quy-users.approve');
            Route::post('/ky-quy-users/reject/{id}', [KyQuyController::class, 'kyQuyUserReject'])->name('ky-quy-users.reject');
            Route::post('/ky-quy-users/stop/{id}', [KyQuyController::class, 'kyQuyUserStop'])->name('ky-quy-users.stop');
            Route::post('/ky-quy-users/finish/{id}', [KyQuyController::class, 'kyQuyUserFinish'])->name('ky-quy-users.finish');
        });
    });
});

Route::post('/logout', [CpanelController::class, 'logout'])->name('logout');
Route::get('/change-language/{lang}', [HomeController::class, 'changeLanguage'])->name('change-language');
// Cpanel Post Management Routes
Route::prefix('cpanel')->name('cpanel.')->group(function () {
});

Route::middleware(['auth', 'language'])->group(function () {
    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::get('/notifications/load-more', [NotificationController::class, 'loadMoreNotifications'])->name('notifications.load-more');
    Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
    Route::get('/wallet', [HomeController::class, 'wallet'])->name('wallet');
});

Route::get('/captcha', function () {
    return response()->json(['captcha' => captcha_src()]);
})->name('captcha');
