<?php
	
	namespace Wpzag\LaravelNotifications\Tests\TestModels;
	
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Wpzag\LaravelNotifications\Traits\Notifiable;
	
	class User extends Authenticatable
	{
		use Notifiable;
		use HasFactory;
		
		protected $guarded = [];
	}
