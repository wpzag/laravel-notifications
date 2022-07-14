<?php

    namespace Wpzag\LaravelNotifications\Models;

    use Illuminate\Notifications\DatabaseNotification as Notification;

    use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

    class DatabaseNotification extends Notification
    {
        use HasJsonRelationships;

        protected $casts = [
            'data' => 'json',
        ];
    }
