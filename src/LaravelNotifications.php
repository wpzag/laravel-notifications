<?php

    namespace Wpzag\LaravelNotifications;

    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

    use Wpzag\LaravelNotifications\Contacts\NotifiableInterface;

    use Wpzag\LaravelNotifications\Helpers\NotificationRelationsLoader;

    use Wpzag\LaravelNotifications\Resources\NotificationResource;

    class LaravelNotifications
    {
        public static function getPaginatedNotifications( $user = null, ?int $perPage = 10): AnonymousResourceCollection
        {
            $user ??= auth()->user();
            $perPage ??= 10;
            $notifications = $user->notifications()->paginate($perPage);
            NotificationRelationsLoader::loadRelations($notifications);

            return NotificationResource::collection($notifications);
        }
    }
