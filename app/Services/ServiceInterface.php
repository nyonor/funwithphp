<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/14/18
 * Time: 11:07 AM
 */

namespace App\Services;


use App\DAL\RepositoryInterface;

interface ServiceInterface
{
    /**
     * @param string $repository_name
     * @param string $connection_name
     * @return RepositoryInterface
     */
    public function getRepository(string $repository_name, string $connection_name) : RepositoryInterface;
}