<?php
	
	namespace Wpzag\LaravelNotifications\Tests\TestNotifications;
	
	use Wpzag\LaravelNotifications\BaseNotification;
	
	class TestNotification extends BaseNotification
	{
		public function getTranslationParams() : array
		{
			return [
				'user' => 'user.name'
			];
		}
		
		public function getNotificationLink() : string
		{
			return 'users/' . $this->relations[ 'user' ][ 'id' ];
		}
	}
