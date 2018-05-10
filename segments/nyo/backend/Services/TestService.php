<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/10/18
 * Time: 6:38 PM
 */

namespace Segments\Nyo\Backend\Services;


use App\Ioc\Ioc;

class TestService
{
    public function someMethod()
    {
        $db = Ioc::factory(MysqlDb::class);
        $db->query('select * from some_table')->fetchAll();
    }
}