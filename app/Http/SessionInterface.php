<?php
/**
 * Синглтон, позволяющий работать с сессией
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 6/6/18
 * Time: 11:54 AM
 */

namespace App\Http;


use App\Helpers\KeyValueStorageInterface;

interface SessionInterface extends KeyValueStorageInterface
{
    public function regenerateSession() : void;
}