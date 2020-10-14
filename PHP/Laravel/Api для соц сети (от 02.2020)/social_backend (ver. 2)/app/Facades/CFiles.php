<?php

namespace App\Facades;
/**
 * Class Files
 * @package App\Facades
 * @method getArFile() static
 * @method getById($id) static
 * @method getByName(string $name) static
 * @method makeFileArray(object $obFile) static
 * @method upload(array $arFile) static
 */
class CFiles extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'c-files';
    }
}
