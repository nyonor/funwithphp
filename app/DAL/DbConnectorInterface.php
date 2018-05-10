<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/10/18
 * Time: 7:57 PM
 */

namespace App\DAL;


interface DbConnectorInterface
{
    public function getConnection(string $db_type);
}