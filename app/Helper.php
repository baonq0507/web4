<?php

namespace App;

use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function getPermission($role)
    {
        return $role->permissions;
    }

    public static function convertNamePermission($permission)
    {
       return match ($permission) {
            'view_dashboard' => __('index.view_dashboard'),
            'view_symbols' => __('index.view_symbols'),
            'create_symbol' => __('index.create_symbol'),
            'edit_symbol' => __('index.edit_symbol'),
            'delete_symbol' => __('index.delete_symbol'),
            'view_users' => __('index.view_users'),
            'edit_user' => __('index.edit_user'),
            'delete_user' => __('index.delete_user'),
            'grant_role' => __('index.grant_role'),
            'view_transactions' => __('index.view_transactions'),
            'edit_transaction' => __('index.edit_transaction'),
            'delete_transaction' => __('index.delete_transaction'),
            'view_withdrawals' => __('index.view_withdrawals'),
            'edit_withdrawal' => __('index.edit_withdrawal'),
            'view_deposits' => __('index.view_deposits'),
            'edit_deposit' => __('index.edit_deposit'),
            'delete_deposit' => __('index.delete_deposit'),
            'is_cpanel' => __('index.is_cpanel'),
            'view_config_system' => __('index.view_config_system'),
            'edit_config_system' => __('index.edit_config_system'),
            'delete_config_system' => __('index.delete_config_system'),
            'view_banks' => __('index.view_banks'),
            'add_bank' => __('index.add_bank'),
            'edit_bank' => __('index.edit_bank'),
            'delete_bank' => __('index.delete_bank'),
            'employee' => __('index.employee'),
            'view_orders' => __('index.view_orders'),
            'edit_order' => __('index.edit_order'),
            'delete_order' => __('index.delete_order'),
            'view_session' => __('index.view_session'),
            'edit_session' => __('index.edit_session'),
            'delete_session' => __('index.delete_session'),
            default => $permission,
        };
    }

    public static function covertNameRole($role)
    {
        return match ($role) {
            'admin' => __('index.admin'),
            'user' => __('index.user'),
            'user_demo' => __('index.user_demo'),
            'employee' => __('index.employee'),
            default => $role,
        };
    }

    public static function getRoleName($role)
    {
        return match ($role) {
            'admin' => __('index.admin'),
            'user' => __('index.user'),
            'user_demo' => __('index.user_demo'),
            'employee' => __('index.employee'),
            default => $role,
        };
    }

    public static function getTransactionType($type)
    {
        return match ($type) {
            'deposit' => __('index.deposit'),
            'withdraw' => __('index.withdraw'),
            'transfer' => __('index.transfer'),
            'bet' => __('index.bet'),
            'win' => __('index.win'),
            'fee' => __('index.fee'),
            'other' => __('index.other'),
            default => $type,
        };
    }

    public static function getTransactionStatus($status)
    {
        return match ($status) {
            'success' => __('index.success'),
            'failed' => __('index.failed'),
            'canceled' => __('index.canceled'),
            'pending' => __('index.pending'),
            default => $status,
        };
    }

    public static function getBankStatus($status)
    {
        return match ($status) {
            'show' => __('index.show'),
            'hide' => __('index.hide'),
        };
    }
}