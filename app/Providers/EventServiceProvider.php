<?php

namespace App\Providers;

use App\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {

            $application = Application::whereNull('is_approve')->get();
            $userLevel = Auth::user()->approvalLevel();
            $count = 0;
            foreach($application as $app){
                $currentLevel = $app->currentApproveLevel();
                if(($userLevel == $currentLevel+1 && $currentLevel == 0 && Auth::user()->profile->department->id == $app->user->profile->department->id) || $userLevel == 99){
                    $count++;
                }
                elseif(($userLevel == $currentLevel+1 && $currentLevel > 0) || $userLevel == 99){
                    $count++;
                }
            }

            $event->menu->addAfter('application_list', [
                'text' => 'Memerlukan Tindakan',
                'route'  => 'approval.action',
                'icon' => 'fas fa-fw fa-tasks',
                'can'  => ['read-approval'],
                // 'active' => ['approval*',],
                'label' => $count,
                'label_color' => 'info'
            ]);
        });
    }
}
