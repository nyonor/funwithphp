<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/10/18
 * Time: 8:32 PM
 */

namespace App\DAL\Mysql;

use App\Config\Config;
use App\DAL\DbConnector;
use PHPUnit\Framework\TestCase;

class MysqlDbConnectionTest extends TestCase
{

    public function testQueryList()
    {
        $connector = new DbConnector();
        $mysql_con = $connector->getConnection('MYSQL_PDO');
        $this->assertNotNull($mysql_con);
    }
}
