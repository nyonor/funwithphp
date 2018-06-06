<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/18/18
 * Time: 12:32 PM
 */

namespace App\Helpers;


interface PathInterface
{
    public function getAssetDir(string $asset_name);
    public function getAssetFile(string $asset_name, string $file_name);
}