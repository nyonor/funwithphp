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
    protected $queryParameters = [];

    /** @var \PDOStatement $pdoStatement */
    protected $pdoStatement;
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
        return $this;
    }

    /**
     * @param null $sql
     * @param array|null $options
     * @return $this
     * @throws Exception
     */
    public function prepareQuery($sql = null, array $options = null)
    {
        if (empty($this->sql) && empty($sql)) {
            throw new Exception('Set query first!');
        }

        if (!empty($sql)) {
            $this->sql = $sql;
        }

        $this->pdoStatement = $this->connection->prepare($this->sql, $options ?? []);

        return $this;
    }

    /**
     * @deprecated
     * @param $class_to_map
     * @return array
     * @throws DbConnectionException
     */
    public function getAsArrayOf($class_to_map)
    {
        $result = [];

        $query_result = $this->query();
        if (is_bool($query_result) && $query_result === false) {
            return $result;
        }

        $result = $this->pdoStatement->fetchAll(PDO::FETCH_CLASS, $class_to_map);
        $this->reset();
        return $result;
    }

    /**
     * @deprecated
     * @param $class_to_map
     * @return mixed
     * @throws DbConnectionException
     */
    public function getOneAs($class_to_map)
    {
        $query_result = $this->query();

        if (is_bool($query_result) && $query_result === false) {
            $this->reset();
            return null;
        }

        $result = $this->pdoStatement->fetchObject($class_to_map);
        $this->reset();
        return $result;
    }

    /**
     * @return array|null
     * @throws DbConnectionException
     */
    public function getOneAsAssoc()
    {
        $query_result = $this->query();

        if (is_bool($query_result) && $query_result === false) {
            $this->reset();
            return null;
        }

        $result = $this->pdoStatement->fetch(PDO::FETCH_ASSOC);
        $this->reset();
        return $result;
    }

    /**
     * @return array
     */
    public function getAsAssocArray()
    {
        // TODO: Implement getAsAssocArray() method.
    }

    /**
     * @param string $table_name
     * @return mixed
     * @throws Exception
     */
    public function insert(string $table_name)
    {
        //формируем строку для перечисления полей
        $keys = array_keys($this->queryParameters);
        $fields_array = [];
        foreach ($keys as $index => $value) {
            array_push($fields_array, trim($value, ':'));
        }
        $fields = implode(', ', $fields_array);

        //формирование строки для перечисления значений
        $values_array = array_values($this->queryParameters ?? []);
        $values = [];
        foreach ($values_array as $value) {
            array_push($values, "'".$value."'");
        }
        $values = implode(', ', $values);

        //если строки для запросов не сформированы - бросаем исключения
//        if (empty($fields)) {
//            throw new DbConnectionException('Fields are empty! Cannot fabricate the query!');
//        }
//
//        if (empty($values)) {
//            throw new DbConnectionException('Values are empty! Cannot fabricate the query!');
//        }

        //формируем запрос и выполняем команду
        //$sql = 'INSERT INTO ' . $table_name . ' (' . $fields . ') VALUE (' . $values . ')';
        $sql = 'INSERT INTO ' . $table_name;

        if (!empty($fields)) {
            $sql .= ' (' . $fields . ')';
        } else {
            $sql .= '()';
        }

        if (!empty($values)) {
            $sql .= ' VALUES (' . $values . ')';
        } else {
            $sql .= ' VALUES()';
        }

        $this->setQuery($sql);
        $rows_affected = $this->query();

        $last_inserted_id = $this->connection->lastInsertId();

        //очищаем запросы и параметры
        $this->reset();

        return $last_inserted_id;
    }

    /**
     * Выполняет запрос и
     * возвращает кол-во затронутых строк в бд ИЛИ булево значение
     *
     * @see http://php.net/manual/en/pdo.exec.php | http://php.net/manual/en/pdostatement.execute.php
     * @return bool|int
     * @throws DbConnectionException
     */
    protected function query() {
        /**
         * @var $query_subject PDO
         */
        $query_subject = $this->connection;

        //если было подготовлено выражение
        if ($this->pdoStatement != false && $this->pdoStatement != null) {
            $result = $this->pdoStatement->execute($this->queryParameters);
            return $result;
        }

        $result = $query_subject->exec($this->sql);

        //если были ошибки
        if (!empty($this->connection->errorInfo()) && $this->connection->errorInfo()[0] !== '00000') {
            throw new DbConnectionException($this->connection->errorInfo()[2], $this->connection->errorInfo()[1]);
        }

        return $result;
    }

    protected function reset()
    {
        $this->sql = null;
        $this->queryParameters = [];
        $this->pdoStatement = null;
    }
}