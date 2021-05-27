<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use \think\Session;
//作者qq 32579135
class Login extends Controller
{
    public function login(){
        if(session('admin')){
            header('Location: /setting_bot');
			exit;
        }
       return $this->fetch();
    }
    
    
    //请求
    
    public function dulogin(){
        if(session('admin')){
            header('Location: /setting_bot');
			exit;
        }
        
        
        $name=trim(input('post.name'));
        $password=trim(input('post.password'));
        $vfe=trim(input('post.vfe'));
        
        if(!$name){
            exit(json_encode(array('code'=>1,'msg'=>'用户名为空')));
        }
        if(!$password){
            exit(json_encode(array('code'=>1,'msg'=>'密码为空')));
        }
        //判断验证码是否正确
        if(!captcha_check($vfe)){
            exit(json_encode(array('code'=>1,'msg'=>'验证码错误')));
        }
        
        $admin=Db::table('admin')->where(array('name'=>$name))->find();
        
        if(!$admin){
            exit(json_encode(array('code'=>1,'msg'=>'用户名或密码错误')));
        }
        
        if($admin['password'] != md5($password)){
            exit(json_encode(array('code'=>1,'msg'=>'用户名或密码错误')));
        }
        
        session('admin',$admin);
        exit(json_encode(array('code'=>0,'msg'=>'登录成功')));
        
       
    }
    
    //退出登录
    public function outlogin(){
        session('admin', null);
        return'退出成功';
    }
}