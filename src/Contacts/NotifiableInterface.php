<?php

    namespace Wpzag\LaravelNotifications\Contacts;

    use Illuminate\Database\Eloquent\Relations\MorphMany;

    interface NotifiableInterface
    {
        public function notifications(): MorphMany;
    }
