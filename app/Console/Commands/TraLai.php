<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\KyQuyUser;

class TraLai extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tra-lai';

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
        $kyQuyUsers = KyQuyUser::where('status', 'approve')->where('end_date', '<', now())->get();
        if ($kyQuyUsers->count() > 0) {
            foreach ($kyQuyUsers as $kyQuyUser) {
                $kyQuyUser->user->balance += $kyQuyUser->balance + $kyQuyUser->profit;
                $kyQuyUser->user->save();
                $kyQuyUser->status = 'finish';
                $kyQuyUser->finish_date = now();
                $kyQuyUser->save();
                $this->info('Trả lãi tiền cho người dùng ' . $kyQuyUser->user->name . ' thành công' . ' - ' . $kyQuyUser->balance + $kyQuyUser->profit);
            }
        } else {
            $this->info('Không có người dùng nào để trả lãi');
        }
    }
}
