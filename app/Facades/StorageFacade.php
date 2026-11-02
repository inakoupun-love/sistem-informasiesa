<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string|null url($path)
 * @method static string|null store($file, $directory = '')
 * @method static bool delete($path)
 * @method static bool exists($path)
 * @method static string|null path($path)
 *
 * @see \App\Helpers\StorageHelper
 */
class StorageFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'storage-helper';
    }
}
