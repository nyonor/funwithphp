<?php
/**
 * Интерфейс для реализации базового функционала
 * репозиториев.
 * Репозитории позволяют манипулировать данными в бд на основе
 * требований бизнес модели приложения.
 * С репозиториями взаимодействуют сервисы приложения.
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/14/18
 * Time: 11:27 AM
 */

namespace App\DAL;


interface RepositoryInterface
{
    /**
     * При создании репозитория передается DbConnectionInterface,
     * которые позвляет работать с конкретными СУБД (выполнять запросы, и тд.)
     *
     * RepositoryInterface constructor.
     * @param DbConnectionInterface $connection
     */
    public function __construct(DbConnectionInterface $connection);
}