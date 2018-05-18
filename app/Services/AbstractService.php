<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/14/18
 * Time: 11:06 AM
 */

namespace App\Services;


use App\DAL\RepositoryFactoryInterface;
use App\DAL\RepositoryInterface;

class AbstractService implements ServiceInterface
{
    /**
     * @var $repositoryFactory RepositoryFactoryInterface
     */
    protected $repositoryFactory;

    /**
     * AbstractService constructor.
     * @param RepositoryFactoryInterface $repository_factory
     */
    public function __construct(RepositoryFactoryInterface $repository_factory)
    {
        $this->repositoryFactory = $repository_factory;
    }


    /**
     * @param string $repository_name
     * @param string $connection_name
     * @return RepositoryInterface
     */
    public function getRepository(string $repository_name, string $connection_name): RepositoryInterface
    {
        return $this->repositoryFactory->create($repository_name, $connection_name);
    }
}