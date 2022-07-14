<?php

    namespace Wpzag\LaravelNotifications;

    use Spatie\LaravelPackageTools\Package;

    use Spatie\LaravelPackageTools\PackageServiceProvider;

    class LaravelNotificationsServiceProvider extends PackageServiceProvider
    {
        public function configurePackage(Package $package): void
        {
            $package
                ->name('laravel-notifications')
                ->hasTranslations();
        }
    }
