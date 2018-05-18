<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/10/18
 * Time: 6:44 PM
 */

namespace App\DAL;


use App\Config\Config;
use App\DAL\Mysql\MysqlDbConnectionInterface;
use App\Ioc\Ioc;

class AbstractDbConnector implements DbConnectorInterface
{
    /**
     * @param string $db_type
     * @return DbConnectionInterface|null
     */
    public function getConnection(string $db_type)
    {
        switch ($db_type) {
            case('MYSQL'):
                $mysql_connection = Ioc::factoryWithArgs (
                    MysqlDbConnectionInterface::class,
                    Config::getDbConnectionSettings($db_type)['pdo']
                );
                return $mysql_connection;
                break;
        }
        return null;
    }
}