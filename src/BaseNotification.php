<?php
	
	namespace Wpzag\LaravelNotifications;
	
	use Illuminate\Bus\Queueable;
	use Illuminate\Contracts\Queue\ShouldQueue;
	use Illuminate\Notifications\Messages\BroadcastMessage;
	use Illuminate\Notifications\Notification;
	use Illuminate\Support\Arr;
	
	abstract class BaseNotification extends Notification implements ShouldQueue
	{
		use Queueable;
		
		public string $key;
		public array $relations = [];
		public array $data = [];
		public string $title = '';
		public string $message = '';
		public string $link = '';
		public array $translationParams = [];
		
		public function __construct($key, $relations, $data)
		{
			$this->key = $key;
			$this->relations = $relations;
			$this->data = $data;
			$this->afterCommit = true;
			$this->buildTranslationParams();
			$this->buildTranslationMessage();
			$this->buildTranslationTitleMessage();
			$this->buildNotificationLink();
		}
		
		public static function create(string $key, array $relations = [], array $data = []) : self
		{
			return new static($key, $relations, $data);
		}
		
		public function toBroadcast($notifiable) : BroadcastMessage
		{
			return new BroadcastMessage([
				'message' => $this->title,
			]);
		}
		
		public function via($notifiable) : array
		{
			return ['broadcast', 'database'];
		}
		
		public function toArray($notifiable) : array
		{
			return [
				'relations' => $this->formRelationsIdArray(),
				'key' => $this->key,
				...$this->data,
			];
		}
		
		private function formRelationsIdArray() : array
		{
			return collect($this->relations)
				->mapWithKeys(
					fn ($item, $key) => [get_class($this->relations[ $key ]) => [str($key)->append('_id')->value() => $item->id]]
				)->toArray();
		}
		
		public function getTranslationParams() : array
		{
			return [];
		}
		
		abstract public function getNotificationLink() : string;
		
		private function buildTranslationParams() : void
		{
			$this->translationParams = collect($this->getTranslationParams())
				->mapWithKeys(
					fn ($value, $key) => [$key => str($value)->contains('.') ? Arr::get($this->relations, $value) : $value]
				)->toArray();
		}
		
		private function buildTranslationMessage() : void
		{
			$this->message = str()->markdown(__("notifications::notifications." . $this->key, $this->translationParams));
		}
		
		private function buildTranslationTitleMessage() : void
		{
			$this->title = str()->markdown(__("notifications::notifications.titles." . $this->key, $this->translationParams));
		}
		
		private function buildNotificationLink() : void
		{
			$this->link = $this->getNotificationLink();
		}
	}
