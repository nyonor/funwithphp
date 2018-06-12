<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/10/18
 * Time: 8:10 PM
 */

namespace App\DAL\Mysql;


use App\DAL\DbConnectionException;
use Exception;
use PDO;

class MysqlPdoDbConnection implements MysqlPdoDbConnectionInterface
{
    const CONNECTION_NAME = 'MYSQL_PDO';

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

    public static function getConnectionName()
    {
        return self::CONNECTION_NAME;
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

    /**
     * @param array|null $options
     * @return $this
     * @throws Exception
     */
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
     * @param string $table_name
     * @return mixed
     * @throws Exception
     */
    public function insert(string $table_name)
    {
        //формируем строку для перечисления полей
        $fields = array_keys($this->queryParameters);
        array_walk($fields, function($value, $index, $fields) {
            $fields[$index] = "'".trim($value, ':')."''";
        });
        $fields = implode(',', $fields);

        //формирование строки для перечисления значений
        $values = implode(',', array_values($this->queryParameters));

        //если строки для запросов не сформированы - бросаем исключения
        if (empty($fields)) {
            throw new DbConnectionException('Fields are empty! Cannot fabricate the query!');
        }

        if (empty($values)) {
            throw new DbConnectionException('Values are empty! Cannot fabricate the query!');
        }

        //формируем запрос и выполняем команду
        $this->setQuery('INSERT INTO ' . $table_name . ' (' . $fields . ') VALUE (' . $values . ')');
        $this->prepareQueryAndExecute();

        //очищаем запросы и параметры
        $this->reset();

        return $this->connection->lastInsertId();
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

    protected function reset()
    {
        unset($this->sql, $this->queryParameters);
    }
}