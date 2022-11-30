<?php

declare(strict_types=1);

namespace Rschoonheim\LaravelApiIntegration\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Rschoonheim\LaravelApiIntegration\Exceptions\ApiDirectoryAlreadyExistsException;

/**
 * @internal This class is not part of the public API.
 */
class Directories
{
    private Filesystem $filesystem;

    public function __construct()
    {
        $this->filesystem = Storage::disk('api-integration');
    }

    /** @throws ApiDirectoryAlreadyExistsException */
    public function createApiDirectory(string $name): void
    {
        if ($this->filesystem->exists($name)) {
            throw new ApiDirectoryAlreadyExistsException();
        }
        $this->filesystem->makeDirectory($name);
    }

    public function removeApiDirectory(string $name): void
    {
        if ($this->filesystem->exists($name)) {
            $this->filesystem->deleteDirectory($name);
        }
    }

}