<?php

declare(strict_types=1);

namespace Rschoonheim\LaravelApiIntegration\Tests\Suites\Feature\Services;

use Illuminate\Support\Facades\Storage;
use Rschoonheim\LaravelApiIntegration\Exceptions\ApiDirectoryAlreadyExistsException;
use Rschoonheim\LaravelApiIntegration\Services\Directories;
use Rschoonheim\LaravelApiIntegration\Tests\Suites\TestCase;

class DirectoriesTest extends TestCase
{
    /** @test */
    public function facade_returns_instance_of_service(): void
    {
        $this->assertInstanceOf(
            Directories::class,
            \Rschoonheim\LaravelApiIntegration\Facades\Directories::getFacadeRoot()
        );
    }

    /** @test */
    public function create_api_directory_creates_the_directory_if_it_doesnt_exist(): void
    {
        $directoryName = 'Test';
        Storage::fake('api-integration');

        $service = resolve(Directories::class);
        $service->createApiDirectory($directoryName);

        $this->assertTrue(
            Storage::disk('api-integration')->exists($directoryName)
        );
    }

    /** @test */
    public function create_api_directory_throws_api_directory_already_exists_exception_if_directory_exists(): void
    {
        $directoryName = 'Test';
        Storage::fake('api-integration');
        Storage::disk('api-integration')->makeDirectory($directoryName);

        $service = resolve(Directories::class);

        $this->expectException(ApiDirectoryAlreadyExistsException::class);
        $service->createApiDirectory($directoryName);
    }

    /** @test */
    public function remove_api_directory_removes_the_directory_if_it_exists(): void
    {
        $directoryName = 'Test';
        Storage::fake('api-integration');
        Storage::disk('api-integration')->makeDirectory($directoryName);

        $service = resolve(Directories::class);
        $service->removeApiDirectory($directoryName);

        $this->assertFalse(
            Storage::disk('api-integration')->exists($directoryName)
        );
    }

    /** @test */
    public function remove_api_directory_does_nothing_when_directory_does_not_exists(): void
    {
        $directoryName = 'Test';
        Storage::fake('api-integration');

        $service = resolve(Directories::class);
        $service->removeApiDirectory($directoryName);

        $this->assertFalse(
            Storage::disk('api-integration')->exists($directoryName)
        );
    }
}