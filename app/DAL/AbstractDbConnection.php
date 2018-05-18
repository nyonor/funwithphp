<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/10/18
 * Time: 7:57 PM
 */

namespace App\DAL;


use PDO;

class AbstractDbConnection implements DbConnectionInterface
{
    protected $connectionSettings;
    protected $pdoConnection;
    protected $connectionName;

    protected function __construct(array $connection_settings, string $connection_name)
    {
        $this->connectionName = $connection_name;
        $this->connectionSettings = $connection_settings;

        $username = $this->connectionSettings['username'];
        $password = $this->connectionSettings['password'];
//      $host = $this->connectionSettings['host'];
//      $db = $this->connectionSettings['db'];
        $this->pdoConnection = new PDO($this->connectionSettings['dsn'], $username, $password);
    }

    public function queryList($sql, $args)
    {
        $stmt = $this->pdoConnection->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}