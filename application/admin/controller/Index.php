<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
/**
 * telegram机器人后台管理 作者qq 32579135
**/
class Index extends Controller
{
    public function index($gid){
        
        $data['shangpin']=Db::table('shangpin')->where(array('gid'=>$gid))->select();
        
        $data['shangpin_gid']=Db::table('shangpin_gid')->where(array('gid'=>$gid))->find();
        
        //获取Telegram用户名
        $data['admin']=Db::table('admin')->where(array('id'=>1))->find();

        
        $this->assign('data',$data);
        return $this->fetch();
    }
}