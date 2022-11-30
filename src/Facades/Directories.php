<?php

declare(strict_types=1);

namespace Rschoonheim\LaravelApiIntegration\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void createApiDirectory(string $name): void
 * @method static void removeApiDirectory(string $name): void
 *
 * @internal This facade is not part of the public API.
 */
class Directories extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Rschoonheim\LaravelApiIntegration\Services\Directories::class;
    }
}
