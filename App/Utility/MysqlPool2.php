<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/3/10
 * Time: 下午5:56
 */

namespace App\Utility;


use EasySwoole\Config;
use EasySwoole\Core\Component\Pool\AbstractInterface\Pool;
use EasySwoole\Core\Component\Trigger;
use EasySwoole\Core\Swoole\Coroutine\Client\Mysql;


class MysqlPool2 extends Pool
{

    function getObj($timeOut = 0.1):?Mysql
    {
        return parent::getObj($timeOut); // TODO: Change the autogenerated stub
    }

    protected function createObject()
    {
        // TODO: Implement createObject() method.
        try{
            $conf = Config::getInstance()->getConf('MYSQL');
            $db = new Mysql([
                'host' => $conf['HOST'],
                'username' => $conf['USER'],
                'password' => $conf['PASSWORD'],
                'db' => $conf['DB_NAME']
            ]);
            if (isset($conf['names'])) {
                $db->rawQuery('SET NAMES ' . $conf['names']);
            }
            return $db;
        }catch (\Throwable $throwable){
            Trigger::throwable($throwable);
            return null;
        }
    }
}
