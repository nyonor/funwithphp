<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/18/18
 * Time: 12:16 PM
 */

namespace App\Helpers;
use App\Config\Config;


/**
 * @property array assets
 */
class Path
{
    public function getAsset($asset_name)
    {
        return Config::$assets[$asset_name];
    }
}