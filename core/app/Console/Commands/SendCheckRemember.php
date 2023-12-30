<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Check;
use Illuminate\Console\Command;
use App\Notifications\AdminCheckRememberNotification;

class SendCheckRemember extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:check-remember {days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders to admins before the due date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $days = $this->argument('days');
        $dueDate = Carbon::now()->addDays($days)->toDateString();

        // Query checks with the same due date as calculated
        // Get Unpaid checks
        $checks = Check::where('status', 3)
            ->where('due_date', '=', $dueDate)
            ->get();

        // Send reminders to admins for each check
        if ($checks->isNotEmpty()) {
            $admin = Admin::first();
            foreach ($checks as $check) {
                $admin->notify(new AdminCheckRememberNotification($check, $days));
            }
        }
    }
}
