<?php
	
	namespace Wpzag\LaravelNotifications\Resources;
	
	use Illuminate\Http\Resources\Json\JsonResource;
	use Wpzag\LaravelNotifications\BaseNotification;
	
	class NotificationResource extends JsonResource
	{
		private BaseNotification $notification;
		
		public function toArray($request) : array
		{
			$this->getMessage();
			
			return [
				'title' => $this->notification->title,
				'message' => $this->notification->message,
				'link' => $this->notification->link,
				'created_at' => $this->created_at,
				'read_at' => $this->read_at,
			];
		}
		
		private function getMessage() : void
		{
			$this->notification = new $this->type(
				key: $this->data[ 'key' ],
				relations: $this->resource->getRelations(),
				data: $this->data
			);
		}
	}
