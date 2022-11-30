<?php

declare(strict_types=1);

namespace Rschoonheim\LaravelApiIntegration\Tests\Suites\Feature\Commands\Http;

use Illuminate\Support\Facades\Storage;
use Rschoonheim\LaravelApiIntegration\Tests\Suites\TestCase;

class MakeHttpIntegrationTest extends TestCase
{
    /** @test */
    public function it_creates_an_http_integration(): void
    {
        Storage::fake('api-integration');

        $this->artisan('integration:http:create')
            ->expectsQuestion('What is the name of your integration?', 'Test')
            ->expectsQuestion('What is the base URL for your integration?', 'https://example.com')
            ->expectsOutput('Creating a new HTTP integration.')
            ->expectsOutputToContain('[OK] Http integration created successfully.')
            ->assertExitCode(0);
    }
}
