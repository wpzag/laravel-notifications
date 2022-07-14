<?php

    namespace Wpzag\LaravelNotifications\Helpers;

    use Illuminate\Notifications\DatabaseNotificationCollection;

    use Illuminate\Pagination\LengthAwarePaginator;

    use Illuminate\Support\Collection;

    use Wpzag\LaravelNotifications\Models\DatabaseNotification;

    class NotificationRelationsLoader
    {
        public function __construct(
            public DatabaseNotificationCollection|LengthAwarePaginator $notifications,
            public array                                               $relations = [],
            public array                                               $relationsNames = []
        ) {
        }

        public static function loadRelations(DatabaseNotificationCollection|LengthAwarePaginator $notifications): LengthAwarePaginator|Collection
        {
            return (new self($notifications))->handle();
        }

        public function handle(): LengthAwarePaginator|DatabaseNotificationCollection
        {
            $this->getRelations();
            $this->buildDynamicRelationships();

            $this->notifications->load($this->relationsNames);

            return $this->notifications;
        }

        private function getRelations(): void
        {
            $notificationsCollection = $this->notifications instanceof LengthAwarePaginator
                ? $this->notifications->getCollection()
                : $this->notifications;
            $notificationsCollection->each(function ($array) {
                foreach ($array->data[ 'relations' ] as $model => $value) {
                    $this->relations[ $model ] = $value;
                }
            });
        }

        private function buildDynamicRelationships(): void
        {
            foreach ($this->relations as $model => $value) {
                $relationKey = array_key_first($value);
                $relation = str($relationKey)->remove('_id')->value();
                $this->relationsNames[] = $relation;

                $this->makeDynamicRelationship(
                    model: $model,
                    relation: $relation,
                    relationKey: $relationKey
                );
            }
        }

        public function makeDynamicRelationship($model, $relation, $relationKey): void
        {
            DatabaseNotification::resolveRelationUsing(
                $relation,
                fn ($notificationModel) => $notificationModel->belongsTo($model, "data->relations->$model->{$relationKey}")
            );
        }
    }
