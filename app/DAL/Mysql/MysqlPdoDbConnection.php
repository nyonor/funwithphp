<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/10/18
 * Time: 8:10 PM
 */

namespace App\DAL\Mysql;


use Exception;
use PDO;

class MysqlPdoDbConnection implements MysqlPdoDbConnectionInterface
{
    const CONNECTION_NAME = 'MYSQL';

    protected $connectionSettings;
    protected $connection;

    protected $sql;
    protected $queryParameters;
    protected $preparedStatement;
    protected $lastExecuteResult;

    public function __construct(array $connection_settings)
    {
        $this->connectionSettings = $connection_settings;

        $username = $this->connectionSettings['username'];
        $password = $this->connectionSettings['password'];
//      $host = $this->connectionSettings['host'];
//      $db = $this->connectionSettings['db'];
        $this->connection = new PDO($this->connectionSettings['dsn'], $username, $password);
    }

    /**
     * @param $sql
     * @return $this
     */
    public function setQuery($sql)
    {
        $this->sql = $sql;
        return $this;
    }

    public function beginTransaction()
    {
        $this->connection->beginTransaction();
        return $this;
    }

    public function commitTransaction()
    {
        $this->connection->commit();
        return $this;
    }

    public function rollbackTransaction()
    {
        $this->connection->rollBack();
        return $this;
    }

    public function setParameters(array $parameters_for_query_assoc_array)
    {
        $this->queryParameters = $parameters_for_query_assoc_array;
//
//        foreach ($parameters_for_query_assoc_array as $k => $v) {
//            if (stripos($k, ':') == false) {
//
//            }
//        }

        return $this;
    }

    public function prepareQueryAndExecute(array $options = null)
    {
        if (empty($this->sql)) {
            throw new Exception('Set query first!');
        }

        $this->lastExecuteResult = $this->connection
                                            ->prepare($this->sql, $options)
                                            ->execute($this->queryParameters);
        return $this;
    }

    public function getAsArrayOf($class_to_map)
    {
        $query_subject = $this->getQuerySubject();
        $result = $query_subject->fetchAll(PDO::FETCH_CLASS, $class_to_map);
        return $result;
    }

    public function getOneAs($class_to_map)
    {
        $query_subject = $this->getQuerySubject();
        $result = $query_subject->fetchObject($class_to_map);
        return $result;
    }

    /**
     * @return \PDOStatement
     */
    protected function getQuerySubject()
    {
        //если было подготовлено выражение
        /**
         * @var $query_subject \PDOStatement
         */
        $query_subject = $this->connection;
        if ($this->preparedStatement != false && $this->preparedStatement != null) {
            $query_subject = $this->preparedStatement;
        }

        return $query_subject;
    }
}