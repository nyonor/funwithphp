<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/15/18
 * Time: 11:08 AM
 */

namespace App\DAL;


use App\DAL\Mysql\MysqlDbConnection;
use App\DAL\Mysql\MysqlDbConnectionInterface;
use App\Ioc\Ioc;

class RepositoryFactory implements RepositoryFactoryInterface
{
    public function __construct()
    {

    }

    public function create(string $repository_name, string $connection_name): RepositoryInterface
    {
        switch ($connection_name) {
            case (MysqlDbConnection::CONNECTION_NAME):
                return Ioc::factoryWithVariadic(MysqlDbConnectionInterface::class, $repository_name,
                    $connection_name);
                break;
        }
    }
}