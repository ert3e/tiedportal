<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\TimelineEventLoggedEvent' => [
            'App\Listeners\TimelineEventLoggedEventListener',
        ],
        'App\Events\AssigneeAddedEvent' => [
            'App\Listeners\AssigneeAddedEventListener',
        ],
        'App\Events\AssigneeRemovedEvent' => [
            'App\Listeners\AssigneeRemovedEventListener',
        ],
        'App\Events\NoteAddedEvent' => [
            'App\Listeners\NoteAddedEventListener',
        ],
        'App\Events\TicketAddedEvent' => [
            'App\Listeners\TicketAddedEventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
