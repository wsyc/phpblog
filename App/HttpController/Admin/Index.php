<?php
/**
 * Created by ccong.
 * User: jisuanji
 * Date: 2018/6/14
 * Time: 10:39
 */
namespace App\HttpController\admin;

use think\Db;
class Index extends Auth {
    /**
     * 首页
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $page = $this->request()->getQueryParam("page") ? $this->request()->getQueryParam("page") :1;
        $res = Db::table('blog_blogs')->page($page,10)->select();
        $couts = round(count($res));
//        print_r(json_encode($res));
        $this->assign("list", json_encode($res));
        $this->assign("page", $page);
        $this->assign("couts", $couts);
        $this->fetch('admin/index/index');      # 对应模板: Views/index.html
    }
    public function add()
    {
        $post = $this->request()->getRequestParam();
        if ($this->request()->getMethod() == "POST")
        {
            $data = [
                'title' => $post['title'],
                'content' => $post['content'],
//                'sort_id' => $post['sort_id'],
                'user_view' => $post['user_view'],
//                'tag' => $post['tag'],
                'is_del' => $post['is_del'],
//                'is_top' => $post['is_top'],
                'type_id' => $post['type_id'],
                'pic' => $post['pic']
            ];
            Db::table('blog_blogs')->insert($data);
        }else{
            $this->fetch('admin/index/add');      # 对应模板: Views/index.html
        }
    }
    /**
     * 首页
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        if ($this->request()->getMethod() == "POST")
        {
            $post = $this->request()->getRequestParam();
                Db::table('blog_blogs')
                    ->where('id', $post['id'])
                    ->update($post);

        }else{
            $id = $this->request()->getQueryParam("id");

            $where =['id'=>$id];
            $res = Db::table('blog_blogs')->where($where)->find();
            $this->assign("res", $res);
            print_r($res);
            $this->fetch('admin/index/edit');      # 对应模板: Views/index.html
        }
    }
    public function del()
    {
        $this->fetch('admin/index/index');      # 对应模板: Views/index.html
    }
    public function test()
    {
        $this->fetch('admin/index/test');      # 对应模板: Views/index.html
    }
}