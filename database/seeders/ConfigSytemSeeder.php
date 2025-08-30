<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConfigSystem;
class ConfigSytemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $config = [
            [
                'key' => 'app_name',
                'value' => 'App Name',
            ],
            [
                'key' => 'app_description',
                'value' => 'App Description',
            ],
            [
                'key' => 'app_logo',
                'value' => 'default.png',
            ],
            [
                'key' => 'app_logo2',
                'value' => 'default.png',
            ],
            [
                'key' => 'app_thumbnail',
                'value' => 'default.png',
            ],
            [
                'key' => 'app_favicon',
                'value' => 'default.png',
            ],
            [
                'key' => 'min_deposit',
                'value' => 35,
            ],
            [
                'key' => 'min_withdraw',
                'value' => 35,
            ],
            [
                'key' => 'on_security_deposit',
                'value' => 'off',
            ],
            [
                'key' => 'live_chat_id',
                'value' => 'on',
            ],
            [
                'key' => 'telegram_bot_token_trade',
                'value' => '7696490332:AAHnsbdkwbCWX0tOZZuPSuGYHiQHIpiDuok',
            ],
            [
                'key' => 'telegram_bot_token_account',
                'value' => '7696490332:AAHnsbdkwbCWX0tOZZuPSuGYHiQHIpiDuok',
            ],
            [
                'key' => 'telegram_bot_chatid_trade',
                'value' => '-1002566208566',
            ],
            [
                'key' => 'telegram_bot_chatid_account',
                'value' => '-1002566208566',
            ],
            [
                'key' => 'system_email',
                'value' => 'admin@gmail.com',
            ],
            [
                'key' => 'system_email_password',
                'value' => 'admin',
            ],
            [
                'key' => 'convert_usdt',
                'value' => '25000',
            ],
            [
                'key' => 'on_required_ref',
                'value' => 'on',
            ],
            [
                'key' => 'fee_withdraw',
                'value' => 3,
            ],
            [
                'key' => 'bonus_f1',
                'value' => 10,
            ],
            [
                'key' => 'bonus_f2',
                'value' => 5,
            ],
            [
                'key' => 'bonus_f3',
                'value' => 2,
            ],
            [
                'key' => 'chart_background',
                'value' => '',
            ],
            [
                'key' => 'on_change_chart',
                'value' => 'off',
            ],
            [
                'key' => 'image_notification',
                'value' => '',
            ],
        ];
        foreach ($config as $item) {
            ConfigSystem::create($item);
        }
    }
}
