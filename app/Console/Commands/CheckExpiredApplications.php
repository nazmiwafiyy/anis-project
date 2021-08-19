<?php

namespace App\Console\Commands;

use App\Application;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

class CheckExpiredApplications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check applications timeout and mark as rejected if no further action within 10 days.';

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
        $rejected = 0;
        $application = $application = Application::whereNull('is_approve')->get();
        foreach($application as $app){
            $lastApproval = $app->approvals()->latest()->first();
            if(!$lastApproval){
                $dateApp = $app->created_at;
            }else{
                $dateApp = $lastApproval->created_at;
            }
            $dateLatest = Carbon::createFromFormat('d-m-Y g:i A', $dateApp,'Asia/Kuala_Lumpur')->startOfDay();
            $dateNow = Carbon::now()->setTimezone('Asia/Kuala_Lumpur')->startOfDay();
            $diffDays = $dateLatest->diffInDays($dateNow);
            
            if($diffDays > 10){
                $app->is_approve = 'N';
                $app->reject_reason = 'Permohonan ditolak secara automatik oleh sistem.';

                if($app->save()){
                    $rejected++;
                }
            }
        }
        
        $this->info($rejected . ' Applications rejected. Check completed!');
    }
}
