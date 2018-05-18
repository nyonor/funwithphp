<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/14/18
 * Time: 6:43 PM
 */

namespace App\DAL;


interface RepositoryFactoryInterface
{
    public function create(string $repository_name, string $connection_name) : RepositoryInterface;
}