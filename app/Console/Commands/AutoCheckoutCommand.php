<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attendance;
use Carbon\Carbon;

class AutoCheckoutCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:auto-checkout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otomatis menandai karyawan yang lupa check-out hari ini menjadi Tidak Checkout';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $affectedRows = Attendance::where('attendance_date', $today)
            ->whereNotNull('check_in_time')
            ->whereNull('check_out_time')
            ->update([
                'status' => 'Tidak Checkout'
            ]);

        $this->info("Auto-Checkout berhasil dieksekusi. Terdapat $affectedRows karyawan yang statusnya diubah menjadi 'Tidak Checkout'.");
    }
}
