<?php

    namespace Wpzag\LaravelNotifications\Traits;

    use Illuminate\Database\Eloquent\Relations\MorphMany;

    use Wpzag\LaravelNotifications\Models\DatabaseNotification;

    trait Notifiable
    {
        use    \Illuminate\Notifications\Notifiable;

        public function notifications(): MorphMany
        {
            return $this->morphMany(DatabaseNotification::class, 'notifiable')
                ->latest();
        }
    }
