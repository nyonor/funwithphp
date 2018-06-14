<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/10/18
 * Time: 7:58 PM
 */

namespace App\DAL;


use Exception;
use PDO;

interface DbConnectionInterface
{

    /**
     * @param $sql
     * @return $this
     */
    public function setQuery($sql);

    /**
     * @param string $table_name
     * @return mixed
     */
    public function insert(string $table_name);

    /**
     * @return $this
     */
    public function beginTransaction();

    /**
     * @return $this
     */
    public function commitTransaction();

    /**
     * @return $this
     */
    public function rollbackTransaction();

    /**
     * @param array $parameters_for_query_assoc_array
     * @return $this
     */
    public function setParameters(array $parameters_for_query_assoc_array);

    /**
     * @param null $sql
     * @param array|null $options
     * @return $this
     */
    public function prepareQuery($sql = null, array $options = null);

    /**
     * @param $class_to_map
     * @return array
     */
    public function getAsArrayOf($class_to_map);

    /**
     * @deprecated
     * @param $class_to_map
     * @return mixed
     */
    public function getOneAs($class_to_map);

    /**
     * @return array
     */
    public function getOneAsAssoc();

    /**
     * @return array
     */
    public function getAsAssocArray();

    /**
     * Имя соединения
     * @return string
     */
    public static function getConnectionName();
}