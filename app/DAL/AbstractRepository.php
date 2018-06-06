<?php
/**
 * Абстрактный класс, реализует базовый общий функционал
 * репозиториев. см. RepositoryInterface
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/14/18
 * Time: 11:27 AM
 */

namespace App\DAL;


use App\DAL\Mysql\MysqlPdoDbConnection;
use App\Ioc\Ioc;

abstract class AbstractRepository
{
    /**
     * Базовый функционал работы с СУБД
     *
     * @var $dbConnection DbConnectionInterface
     */
    public $dbConnection;

    /**
     * Класс-фабрика для простого и быстрого создания DbConnectionInterface
     *
     * @var $dbConnector DbConnectorInterface
     */
    protected $dbConnector;

    /**
     * см. RepositoryInterface
     * AbstractRepository constructor.
     * @param DbConnectionInterface|null $db_connection
     */
    public function __construct(DbConnectionInterface $db_connection = null)
    {
        if (!empty($db_connection))
        {
            $this->dbConnection = $db_connection;
        } else {
            $this->dbConnector = Ioc::factory(DbConnectorInterface::class);
            $this->dbConnection = $this->dbConnector->getConnection(MysqlPdoDbConnection::CONNECTION_NAME);
        }
    }
}