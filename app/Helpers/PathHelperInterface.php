<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/18/18
 * Time: 12:32 PM
 */

namespace App\Helpers;


interface PathHelperInterface
{
    public function getAsset(string $asset_name);
}