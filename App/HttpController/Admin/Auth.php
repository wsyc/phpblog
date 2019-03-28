<?php
/**
 * Created by PhpStorm.
 * User: chongyan
 * Date: 2018/7/2
 * Time: 20:40
 */

namespace App\HttpController\admin;


use App\ViewController;
use EasySwoole\Core\Http\Session\Session;
class Auth extends ViewController{

    protected $session = null;
    protected function onRequest($action): ?bool
    {
        $session = new Session($this->request(), $this->response());
        $session->sessionStart();
        parent::onRequest($action);
        $isLogin = $session->get("login");
        if ($isLogin)
        {
            return true;
        }else{
            $this->response()->redirect("/admin/login/login");
            return false;
        }
    }

//    abstract function index();

    public function index()
    {
        // TODO: Implement index() method.
    }
}