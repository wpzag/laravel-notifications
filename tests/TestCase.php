<?php

    namespace Wpzag\LaravelNotifications\Tests;

    use Illuminate\Database\Eloquent\Factories\Factory;

    use Illuminate\Database\Schema\Blueprint;

    use Illuminate\Foundation\Application;

    use Illuminate\Foundation\Testing\DatabaseMigrations;

    use Illuminate\Http\Request;

    use Illuminate\Support\Facades\Route;

    use Orchestra\Testbench\TestCase as Orchestra;

    use Wpzag\LaravelNotifications\LaravelNotifications;

    use Wpzag\LaravelNotifications\LaravelNotificationsServiceProvider;

    class TestCase extends Orchestra
    {
        use DatabaseMigrations;

        protected function setUp(): void
        {
            parent::setUp();
            $this->setUpDatabase($this->app);
            Factory::guessFactoryNamesUsing(
                fn (string $modelName) => 'Wpzag\\LaravelNotifications\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
            );
            $this->setUpRoutes();
        }

        private function setUpRoutes()
        {
            Route::get('/notifications', function (Request $request) {
                return LaravelNotifications::getPaginatedNotifications();
            });
        }

        protected function getPackageProviders($app)
        {
            return [
                LaravelNotificationsServiceProvider::class,
            ];
        }

        protected function setUpDatabase(Application $app)
        {
            $getSchemaBuilder = $app[ 'db' ]->connection()->getSchemaBuilder();
            $getSchemaBuilder->create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
            $getSchemaBuilder->create('notifications', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('type');
                $table->morphs('notifiable');
                $table->text('data');
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
            });
        }

        public function getEnvironmentSetUp($app)
        {
            config()->set('database.default', 'testing');

            /*
            $migration = include __DIR__.'/../database/migrations/create_laravel-notifications_table.php.stub';
            $migration->up();
            */
        }
    }
