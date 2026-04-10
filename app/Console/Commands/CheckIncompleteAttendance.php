<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attendance;
use Carbon\Carbon;

class CheckIncompleteAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:check-incomplete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for open attendances that are older than 24 hours and mark them as incomplete.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cutoff = Carbon::now()->subHours(24);

        $affectedRows = Attendance::whereNull('clock_out')
            ->where(function($query) use ($cutoff) {
                // If the attendance date is older than 24 hours ago, or if it was exactly 24 hours ago and clock_in was earlier.
                $query->where('attendance_date', '<', $cutoff->format('Y-m-d'))
                      ->orWhere(function($subQuery) use ($cutoff) {
                          $subQuery->where('attendance_date', '=', $cutoff->format('Y-m-d'))
                                   ->where('clock_in', '<=', $cutoff->format('H:i:s'));
                      });
            })
            ->update([
                'status' => 'incomplete'
            ]);

        $this->info("Updated {$affectedRows} incomplete attendances.");
    }
}
