<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/10/18
 * Time: 8:32 PM
 */

namespace App\DAL\Mysql;

use App\Config\Config;
use PHPUnit\Framework\TestCase;

class MysqlDbConnectionTest extends TestCase
{

    public function testQueryList()
    {
        $mysql_con = new MysqlDbConnection(Config::getDbConnectionSettings('MYSQL')['pdo']);
        $this->assertNotNull($mysql_con);
    }
}
