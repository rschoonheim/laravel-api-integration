<?php

declare(strict_types=1);

namespace Rschoonheim\LaravelApiIntegration\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @internal This facade is not part of the public API.
 */
class Directories extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Rschoonheim\LaravelApiIntegration\Services\Directories::class;
    }
}