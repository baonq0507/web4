<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = [
            [
                'name' => 'admin',
            ],
            [
                'name' => 'user',
            ],
            [
                'name' => 'user_demo',
            ],
            [
                'name' => 'employee',
            ],
        ];
        foreach ($role as $item) {
            Role::create($item);
        }
        $permission = [
            [
                'name' => 'view_dashboard',
            ],
            [
                'name' => 'view_symbols',
            ],
            [
                'name' => 'create_symbol',
            ],
            [
                'name' => 'edit_symbol',
            ],
            [
                'name' => 'delete_symbol',
            ],
            [
                'name' => 'view_users',
            ],
            [
                'name' => 'edit_user',
            ],
            [
                'name' => 'delete_user',
            ],
            [
                'name' => 'grant_role',
            ],
            [
                'name' => 'view_transactions',
            ],
            [
                'name' => 'edit_transaction',
            ],
            [
                'name' => 'delete_transaction',
            ],

            [
                'name' => 'view_withdrawals',
            ],
            [
                'name' => 'edit_withdrawal',
            ],

            [
                'name' => 'view_deposits',
            ],
            [
                'name' => 'edit_deposit',
            ],
            [
                'name' => 'delete_deposit',
            ],
            [
                'name' => 'is_cpanel',
            ],
            [
                'name' => 'view_banks',
            ],
            [
                'name' => 'edit_bank',
            ],
            [
                'name' => 'delete_bank',
            ],
            [
                'name' => 'view_config_system',
            ],
            [
                'name' => 'edit_config_system',
            ],
            [
                'name' => 'view_orders',
            ],
            [
                'name' => 'edit_order',
            ],
            [
                'name' => 'delete_order',
            ],
            [
                'name' => 'view_sessions',
            ],
            [
                'name' => 'edit_session',
            ],
            [
                'name' => 'delete_session',
            ],
        ];
        foreach ($permission as $item) {
            Permission::create($item);
        }
        $role = Role::where('name', 'admin')->first();
        $role->givePermissionTo($permission);
        $user = User::where('username', 'admin')->first();
        $user->assignRole('admin');
    }
}
