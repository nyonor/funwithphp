<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/13/18
 * Time: 5:06 PM
 */

namespace App\DAL;


use App\Config\Config;
use App\DAL\Mysql\MysqlPdoDbConnectionInterface;
use App\Ioc\Ioc;

class DbConnector implements DbConnectorInterface
{
    /**
     * @param string $db_type
     * @return DbConnectionInterface|null
     */
    public function getConnection(string $db_type)
    {
        switch ($db_type) {
            case('MYSQL_PDO'):
                $mysql_connection = Ioc::factoryWithArgs(MysqlPdoDbConnectionInterface::class,
                    Config::getDbConnectionSettings($db_type)['pdo']);
                return $mysql_connection;
                break;
        }
        return null;
    }
}