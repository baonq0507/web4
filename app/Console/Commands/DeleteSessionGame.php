<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
class DeleteSessionGame extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-session-game';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->user_trade()->where('created_at', '<', now()->subDays(3))->delete();
        }
        $this->info('Xóa tất cả lịch sử game của người dùng chỉ giữ lại 3 ngày gần nhất thành công');
    }
}
