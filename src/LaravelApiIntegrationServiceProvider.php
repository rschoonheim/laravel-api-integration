<?php

declare(strict_types=1);

namespace Rschoonheim\LaravelApiIntegration;

use Illuminate\Support\Facades\Config;
use Rschoonheim\LaravelApiIntegration\Commands\Http\MakeHttpIntegration;
use Rschoonheim\LaravelApiIntegration\Commands\Installation\InstallationCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelApiIntegrationServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-api-integration-boilerplate');
        $package->hasCommands([
            InstallationCommand::class,
            MakeHttpIntegration::class,
        ]);
    }

    public function boot()
    {
        parent::boot();

        Config::set('filesystems.disks.api-integration', [
            'driver' => 'local',
            'root' => base_path('app/Integration'),
        ]);
    }
}
