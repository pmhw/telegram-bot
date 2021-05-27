<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
/**
 * telegram机器人后台控制页权限验证
**/
class Base extends Controller
{
    public function __construct(){
        parent::__construct();
        $this->_admin = session('admin');
        // 未登录的用户不允许访问
		if(!$this->_admin){
			header('Location: /login');
			exit;
		}
		
		$admin=Db::table('admin')->where(array('name'=>$this->_admin['name']))->find();
		$this->assign('admin',$admin);
    }
        
}