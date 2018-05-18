<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/10/18
 * Time: 8:10 PM
 */

namespace App\DAL\Mysql;


use App\DAL\AbstractDbConnection;

class MysqlDbConnection extends AbstractDbConnection implements MysqlDbConnectionInterface
{
    const CONNECTION_NAME = 'MYSQL';

    public function __construct(array $connection_settings)
    {
        parent::__construct($connection_settings, self::CONNECTION_NAME);
    }
}