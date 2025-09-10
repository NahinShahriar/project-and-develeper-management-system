<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use App\Notifications\DeadlineAlert;

class SendDeadlineAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:deadlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send alerts to users for tasks nearing deadlines';

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
        $tomorrow = Carbon::now()->addDay()->toDateString();

        $tasks = Task::whereDate('due_date', $tomorrow)
                     ->where('status', '!=', 'done') 
                     ->get();

        foreach ($tasks as $task) {
            $user = $task->assignedUser;
            if ($user) {
                $user->notify(new DeadlineAlert($task));
            }
        }

        $this->info('Deadline alerts sent!');
    }
}
