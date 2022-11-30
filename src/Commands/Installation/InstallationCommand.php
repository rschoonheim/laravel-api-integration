<?php

declare(strict_types=1);

namespace Rschoonheim\LaravelApiIntegration\Commands\Installation;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class InstallationCommand extends Command
{
    protected $signature = 'integration:install';

    protected $description = 'Prepare your Laravel application for API integration';

    public function handle(): int
    {
        $this->output->title('Preparing your Laravel application for API integration.');

        $storage = Storage::build([
            'driver' => 'local',
            'root' => base_path('app'),
        ]);

        $storage->makeDirectory('Integrations');
        $this->output->comment('Created directory: app/Integrations');

        $this->output->success('Your Laravel application is now ready for API integration.');

        return self::SUCCESS;
    }
}
