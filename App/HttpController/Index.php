<?php
/**
 * Created by ccong.
 * User: jisuanji
 * Date: 2018/6/14
 * Time: 10:39
 */
namespace App\HttpController;

use EasySwoole\Config;
use EasySwoole\Core\Http\AbstractInterface\Controller;
use EasySwoole\Core\Http\Request;
use EasySwoole\Core\Http\Response;
use think\Template;
use APP\Model\Member;
use App\ViewController;
use think\Db;
use App\Utility;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

class Index extends ViewController{
    /**
     * 首页
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    function index()
    {
        $page = $this->request()->getQueryParam("page") ? $this->request()->getQueryParam("page") :1;
//        try {
            $res = Db::table('blog_blogs')
//                ->field('id,title,content,view,type')
                ->alias('a')
                ->join('types b ','b.id= a.type_id')
//                ->field('name')
                ->page($page, 10)->select();

        $couts = round(count($res));
//        print_r($res);
        $this->assign("list", json_encode($res));
        $this->assign("page", $page);
        $this->assign("couts", $couts);
        $this->fetch('index');      # 对应模板: Views/index.html
    }

    /**
     *
     *
     *
     * 
     * 关于我
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    function about()
    {
        $this->fetch('about');      # 对应模板: Views/index.html
    }

    /**
     * 留言板
     */
    function gbook()
    {
        $this->fetch('gbook');      # 对应模板: Views/index.html
    }
    /**
     * 内容页
     */
    function info()
    {
        $id = $this->request()->getQueryParam("id");
//        $last = Db::query("select * from db_blog_blogs where id = (select max(id) from db_blog_blogs where id < {$id});");
//        $next = Db::query("select * from db_blog_blogs where id = (select min(id) from db_blog_blogs where id > {$id});");
        $last = Db::query("select * from blog_blogs where id < {$id} and is_del=0 order by id DESC limit 0,1");
        $next = Db::query("select * from blog_blogs where id > {$id} and is_del=0 order by id limit 0,1");
//        print_r($next);
        $res = Db::table('blog_blogs')
            ->alias('a')
            ->join('types b ','b.id= a.type_id')
            ->where("a.id", $id)->find();
//            print_r($res);
        $this->assign("last", $last);
        $this->assign("next", $next);
        $this->assign("res", $res);
        $this->fetch('info');      # 对应模板: Views/index.html
    }
    /**
     * 学无止境
     */
    function lists()
    {
        $page = $this->request()->getQueryParam("page") ? $this->request()->getQueryParam("page") :1;
//        try {
        $res = Db::table('blog_blogs')
//                ->field('id,title,content,view,type')
            ->alias('a')
            ->join('types b ','b.id= a.type_id')
//                ->field('name')
            ->page($page, 10)->select();

        $couts = ceil(count($res)/10);
//        print_r($res);
        $this->assign("list", json_encode($res));
        $this->assign("page", $page);
        $this->assign("couts", $couts);
        $this->fetch('list');      # 对应模板: Views/index.html
    }
    /**
     * 模板页
     */
    function share()
    {
        $this->fetch('share');      # 对应模板: Views/index.html
    }
    function login()
    {

        $this->response()->withHeader("Access-Control-Allow-Origin", "*");
//        header("Access-Control-Allow-Origin: *");
        $method = $this->request()->getMethod();
        if ($method == "POST"){
            echo date("Y-m-d H:i:s")." access".PHP_EOL;
            $data = $this->request()->getRequestParam();
            if (!isset($data['username']) || !isset($data['password']))
            {
                $json = json_encode( array(
                    "status"=>0,
                    "msg"=>"请输入完整"
                ));
                $this->response()->write($json);
                $this->response()->end();
            }else{
                if ($data['username'] == "zhangbo" && $data['password'] == "123")
                {
                    $json = json_encode( array(
                        "status"=>1,
                        "msg"=>"登录成功"
                    ));
                    $this->response()->write($json);
                    $this->response()->end();
                }else{
                    $json = json_encode( array(
                        "status"=>0,
                        "msg"=>"用户名或密码错误"
                    ));
                    $this->response()->write($json);
                    $this->response()->end();
                }
            }
        }else{
            $json = json_encode( array(
                "status"=>-1,
                "msg"=>"请使用post方式提交"
            ));
            $this->response()->write($json);
            $this->response()->end();
        }
        $this->response()->end();
    }



    function test(){
        $this->fetch('test');      # 对应模板: Views/index.html
    }
    function upload(){

        $this->response()->withHeader("Access-Control-Allow-Origin", "*");
        //上传配置
        $config = array(
            "savePath" => "upload/" ,             //存储文件夹
            "maxSize" => 1000 ,                   //允许的文件最大尺寸，单位KB
            "allowFiles" => array( ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp" )  //允许的文件格式
        );
        //上传文件目录
        $Path = "upload/";
        $a = $this->request()->getSwooleRequest()->files;
//        $this->response()->end();
        print_r($a);
        //背景保存在临时目录中
        $config[ "savePath" ] = $Path;
        $up = new Utility\Uploader( "upfile" , $config ,false ,$a, $this->response());
        echo json_encode($up->getFileInfo());
    }
}