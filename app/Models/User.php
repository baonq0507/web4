<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use  HasFactory, Notifiable, HasRoles, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'status',
        'phone',
        'email',
        'email_verified_at',
        'email_verification_code',
        'address',
        'avatar',
        'balance',
        'balance_demo',
        'referral',
        'referral_parent_id',
        'level',
        'vip_level_id',
        'wallet_address',
        'balance_usdt',
        'region',
        'ratio',
        'ip_address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function referralParent()
    {
        return $this->belongsTo(User::class, 'referral_parent_id');
    }

    public function getStatusNameAttribute()
    {
        return match ($this->status) {
            'active' => __('index.active'),
            'inactive' => __('index.inactive'),
            'band' => __('index.band'),
            default => __('index.inactive'),
        };
    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($user) {
            $user->referral = Str::random(6);
            $user->save();
        });
    }

    public function getReferralLinkAttribute()
    {
        return route('register', ['ref' => $this->referral]);
    }

    // những người có referral_parent_id = id
    public function referrals()
    {
        return $this->hasMany(User::class, 'referral_parent_id');
    }

    public function banks()
    {
        return $this->hasMany(UserBank::class);
    }

    public function usdt()
    {
        return $this->hasMany(UserUsdt::class);
    }

    public function kycs()
    {
        return $this->hasMany(UserKyc::class);
    }

    public function user_kycs()
    {
        return $this->hasMany(UserKyc::class);
    }

    //verify user kyc
    public function verifyUserKyc()
    {
        return $this->hasMany(UserKyc::class)->where('status', 'approved')->first();
    }

    public function getIdentityFrontLinkAttribute()
    {
        if ($this->identity_front) {
            return asset('images/users/' . $this->identity_front);
        }
        return null;
    }

    public function getIdentityBackLinkAttribute()
    {
        if ($this->identity_back) {
            return asset('images/users/' . $this->identity_back);
        }
        return null;
    }

    public function getIdentitySelfieLinkAttribute()
    {
        if ($this->identity_selfie) {
            return asset('images/users/' . $this->identity_selfie);
        }
        return null;
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getTotalDepositAttribute()
    {
        return $this->transactions()->where('type', 'deposit')->sum('amount');
    }


    public function getTotalWithdrawAttribute()
    {
        return $this->transactions()->where('type', 'withdraw')->sum('amount');
    }

    public function getTotalDepositUsdtAttribute()
    {
        return $this->user_usdt()->sum('amount');
    }

    public function user_trade()
    {
        return $this->hasMany(UserTrade::class);
    }

    public function getTotalTradeAttribute()
    {
        return $this->user_trade()->sum('amount');
    }

    public function getTotalWithdrawReferralAttribute()
    {
        $total_withdraw = 0;
        foreach ($this->referrals as $referral) {
            $total_withdraw += $referral->transactions()->where('type', 'withdraw')->sum('amount');
        }
        return $total_withdraw;
    }

    public function getTotalDepositReferralAttribute()
    {
        $total_deposit = 0;
        foreach ($this->referrals as $referral) {
            $total_deposit += $referral->transactions()->where('type', 'deposit')->sum('amount');
        }
        return $total_deposit;
    }

    public function getTotalTradeWinAttribute()
    {
        return $this->user_trade()->where('result', 'win')->sum('amount');
    }

    public function getTotalTradeLoseAttribute()
    {
        return $this->user_trade()->where('result', 'lose')->sum('amount');
    }


    public function invitedUsers()
    {
        return $this->hasMany(User::class, 'referral_parent_id');
    }

    public function getAvatarAttribute()
    {
        if (!$this->attributes['avatar']) {
            return asset('assets/images/user.png');
        }
        return $this->attributes['avatar'];
    }

    public function invests()
    {
        return $this->hasMany(Investment::class);
    }

    public function kyquies()
    {
        return $this->hasMany(KyQuyUser::class);
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    // Lấy wallet cho một symbol cụ thể
    public function getWallet($symbolId)
    {
        return $this->wallets()->where('symbol_id', $symbolId)->first();
    }

    // Lấy tổng tài sản (USDT + tất cả coin)
    public function getTotalAssetsAttribute()
    {
        $totalAssets = $this->balance; // USDT balance
        
        foreach ($this->wallets as $wallet) {
            // Cần implement logic lấy giá hiện tại
            $currentPrice = 0; // Placeholder
            $totalAssets += $wallet->balance * $currentPrice;
        }
        
        return $totalAssets;
    }

    /**
     * Relationship với VIP Level
     */
    public function vipLevel()
    {
        return $this->belongsTo(VipLevel::class);
    }

    /**
     * Lấy VIP level hiện tại hoặc mặc định
     */
    public function getCurrentVipLevel()
    {
        if ($this->vipLevel) {
            return $this->vipLevel;
        }
        
        // Nếu chưa có VIP level, tự động cập nhật dựa trên tổng nạp tiền
        return $this->updateVipLevel();
    }

    /**
     * Cập nhật VIP level dựa trên tổng số tiền nạp
     */
    public function updateVipLevel()
    {
        $totalDeposit = $this->getTotalDepositAttribute();
        $newVipLevel = VipLevel::getVipLevelByDeposit($totalDeposit);
        
        if ($newVipLevel && (!$this->vipLevel || $this->vipLevel->level < $newVipLevel->level)) {
            $this->vip_level_id = $newVipLevel->id;
            $this->save();
        }
        
        return $this->vipLevel ?? VipLevel::where('level', 0)->first();
    }

    /**
     * Kiểm tra xem có thể nâng cấp VIP không
     */
    public function canUpgradeVip()
    {
        $currentLevel = $this->getCurrentVipLevel();
        if (!$currentLevel || $currentLevel->isMaxLevel()) {
            return false;
        }
        
        $nextLevel = $currentLevel->getNextLevel();
        if (!$nextLevel) {
            return false;
        }
        
        return $this->getTotalDepositAttribute() >= $nextLevel->required_deposit;
    }

    /**
     * Lấy tiền cần nạp thêm để lên VIP tiếp theo
     */
    public function getAmountNeededForNextVip()
    {
        $currentLevel = $this->getCurrentVipLevel();
        if (!$currentLevel || $currentLevel->isMaxLevel()) {
            return 0;
        }
        
        $nextLevel = $currentLevel->getNextLevel();
        if (!$nextLevel) {
            return 0;
        }
        
        $needed = $nextLevel->required_deposit - $this->getTotalDepositAttribute();
        return max(0, $needed);
    }
}
