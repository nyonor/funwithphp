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
use App\Ioc\Ioc;

class AbstractServiceWithRepository implements ServiceWithRepositoryInterface
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
}