<?php
	
	
	use Wpzag\LaravelNotifications\Tests\TestModels\User;
	use Wpzag\LaravelNotifications\Tests\TestNotifications\TestNotification;
	use function Pest\Laravel\actingAs;
	use function Pest\Laravel\getJson;
	
	
	beforeEach(function() {
		User::factory(4)->create();
	});
	
	
	it('can test', function() {
		actingAs(User::first());
		User::first()->notify(
			TestNotification::create(
				key: 'user_updated',
				relations: ['user' => User::first()],
				data: ['random' => 'data']
			)
		);
		
		$res = getJson('/notifications')->json();
		dd($res);
		expect(true)->toBeTrue();
	});
