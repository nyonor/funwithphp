<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/10/18
 * Time: 7:58 PM
 */

namespace App\DAL;


interface DbConnectionInterface
{
    public function queryList($sql, $args);
}