<?php
/**
 * Created by PhpStorm.
 * User: chongyan
 * Date: 2018/7/2
 * Time: 20:45
 */

namespace App\HttpController\admin;

//use EasySwoole\Config;
//use EasySwoole\Core\Http\AbstractInterface\Controller;
//use EasySwoole\Core\Http\Request;
//use EasySwoole\Core\Http\Response;
//use think\Template;
use APP\Model\Member;
use App\ViewController;
use EasySwoole\Core\Http\Session\Session;
use think\Db;
class Login extends ViewController{
    public function index()
    {
        $this->fetch('admin/index');      # 对应模板: Views/index.html
    }
    public function login()
    {
        $method = $this->request()->getMethod();
        $parms = $this->request()->getRequestParam();
        if ($method == "POST")
        {
            if ($parms['name'] == 'ycadmin' && $parms['password'] == '12361')
            {
                $session = new Session($this->request(), $this->response());
                $session->sessionStart();
                $session->set("login", 1);
                $this->response()->write(json_encode(['result' => 'true']));
            }else{
                $this->response()->write(json_encode(['result' => 'false']));
            }
            $this->response()->end();
        }else{
            $this->fetch('admin/login');      # 对应模板: Views/index.html
        }
    }


    public function isLogin()
    {
        $sesiion = new Session($this->request(), $this->response());
        $sesiion->sessionStart();
        $isLgin = $sesiion->get("login");
        echo $isLgin;
        $this->response()->end();
    }
}