<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/1/9
 * Time: 下午1:04
 */

namespace EasySwoole;

use \EasySwoole\Core\AbstractInterface\EventInterface;
use \EasySwoole\Core\Swoole\ServerManager;
use \EasySwoole\Core\Swoole\EventRegister;
use \EasySwoole\Core\Http\Request;
use \EasySwoole\Core\Http\Response;
use EasySwoole\Core\Component\Pool\PoolManager;
use App\Utility\MysqlPool2;
use think\Db;
Class EasySwooleEvent implements EventInterface {

    public static function frameInitialize(): void
    {
        // TODO: Implement frameInitialize() method.
        date_default_timezone_set('Asia/Shanghai');
        // 获得数据库配置
        $dbConf = Config::getInstance()->getConf('database');
        // 全局初始化
        Db::setConfig($dbConf);
    }

    public static function mainServerCreate(ServerManager $server,EventRegister $register): void
    {
        // 数据库协程连接池
        // @see https://www.easyswoole.com/Manual/2.x/Cn/_book/CoroutinePool/mysql_pool.html?h=pool
        // ------------------------------------------------------------------------------------------
//        if (version_compare(phpversion('swoole'), '2.1.0', '>=')) {

//            PoolManager::getInstance()->registerPool(MysqlPool2::class, 1, 2);
//        }
        // TODO: Implement mainServerCreate() method.
    }

    public static function onRequest(Request $request,Response $response): void
    {
        // TODO: Implement onRequest() method.
    }

    public static function afterAction(Request $request,Response $response): void
    {
        // TODO: Implement afterAction() method.
    }
}