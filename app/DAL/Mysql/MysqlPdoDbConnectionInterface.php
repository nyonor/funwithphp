<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/24/18
 * Time: 7:15 PM
 */

namespace App\DAL\Mysql;


use App\DAL\DbConnectionInterface;
use PDO;

interface MysqlPdoDbConnectionInterface extends DbConnectionInterface
{

    public function __construct(array $connection_settings);
}