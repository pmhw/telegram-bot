<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
/**
 * telegram机器人api 作者qq 32579135
**/
class Api extends Controller
{
    
    public function index(){
        //设置连接根
        
        $admin=Db::table('admin')->where(array('id'=>1))->find();
        $token=$admin['token'];
        $url = "https://api.telegram.org/bot".$token."/";
        
        //获取反射信息
        $update = json_decode(file_get_contents('php://input'), true);
        $chat_id = $update['message']['chat']['id'];
        $name = $update['message']['from']['first_name'];
        $text=$update['message']['text'];//获取用户消息
        
        $data['text']=$text;
        $data['name']=$name;
        $data['chat_id']=$chat_id;
        $data['time']=time();
        
        $tg_message=Db::table('tg_message')->insert($data);
        
        if(is_numeric($data['text'])==true){
        //查Q绑
         $qq_bang = Db::connect([
            // 数据库类型
            'type'        => 'mysql',
            // 数据库连接DSN配置
            'dsn'         => '',
            // 服务器地址
            'hostname'    => '127.0.0.1',
            // 数据库名
            'database'    => 'qbang',
            // 数据库用户名
            'username'    => 'qbang',
            // 数据库密码
            'password'    => '25DtWExEBdbpHF5R',
            // 数据库连接端口
            'hostport'    => '',
            // 数据库连接参数
            'params'      => [],
            // 数据库编码默认采用utf8
            'charset'     => 'utf8',
            // 数据库表前缀
            'prefix'      => 'think_',
        ])
        ->table('8eqq')
        ->where(array('username'=>$data['text']))
        ->find();
        
            if($qq_bang){
                file_get_contents($url . "sendmessage?text=绑定手机号：". $qq_bang['mobile'] ."&chat_id=" . $chat_id);
                exit;
            }else{
                file_get_contents($url . "sendmessage?text=该QQ未泄露" ."&chat_id=" . $chat_id);
                exit;
            }
        }
        
        //获取数据库关键词
        $api=Db::table('api')
        ->alias('a')
        ->join('api_gid b','a.gid=b.gid','LEFT')
        ->where(array('keywords'=>$data['text']))
        ->field('a.gid as agid,a.*,b.*')
        ->find();
        
        if($api){
        file_get_contents($url . $api['api'] . $api['text'] ."&chat_id=" . $chat_id);
        exit;
        }
        
        // if($data['text']=='/look'){
        // file_get_contents($url . "sendmessage?text=您可以私聊或回复我发送以下文字：胸大、甜美、大长腿、清纯、骚情" ."&chat_id=" . $chat_id);
        // exit;
        // }
        
        // if($data['text']=='/look@Azhe_php_bot'){
        // file_get_contents($url . "sendmessage?text=您可以私聊或回复我发送以下文字：胸大、甜美、大长腿、清纯、骚情" ."&chat_id=" . $chat_id);
        // exit;
        // }
        // if($data['text']=='胸大'){
        // file_get_contents($url . "sendPhoto?photo=https://images.pexels.com/photos/6113297/pexels-photo-6113297.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500" ."&chat_id=" . $chat_id);
        // file_get_contents($url . "sendmessage?text=链接正在搭建中！！" ."&chat_id=" . $chat_id);
        // exit;
        // }
        
        // if($data['text']=='甜美'){
        // file_get_contents($url . "sendPhoto?photo=https://images.pexels.com/photos/6113297/pexels-photo-6113297.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500" ."&chat_id=" . $chat_id);
        // file_get_contents($url . "sendmessage?text=链接正在搭建中！！" ."&chat_id=" . $chat_id);
        // exit;
        // }
        
        // if($data['text']=='大长腿'){
        // file_get_contents($url . "sendPhoto?photo=https://images.pexels.com/photos/6113297/pexels-photo-6113297.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500" ."&chat_id=" . $chat_id);
        // file_get_contents($url . "sendmessage?text=链接正在搭建中！！" ."&chat_id=" . $chat_id);
        // exit;
        // }
        
        
        // if($data['text']=='清纯'){
        // file_get_contents($url . "sendPhoto?photo=https://images.pexels.com/photos/6113297/pexels-photo-6113297.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500" ."&chat_id=" . $chat_id);
        // file_get_contents($url . "sendmessage?text=链接正在搭建中！！" ."&chat_id=" . $chat_id);
        // exit;
        // }
        
        // if($data['text']=='骚情'){
        // file_get_contents($url . "sendPhoto?photo=https://images.pexels.com/photos/6113297/pexels-photo-6113297.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500" ."&chat_id=" . $chat_id);
        // file_get_contents($url . "sendmessage?text=链接正在搭建中！！" ."&chat_id=" . $chat_id);
        // exit;
        // }
        
        // if($data['text']=='视频'){
        // file_get_contents($url . "sendAudio?audio=https://www.runoob.com/try/demo_source/movie.mp4" ."&chat_id=" . $chat_id);
        // exit;
        // }
        
        // if($data['text']=='标签'){
        // file_get_contents($url . "sendmessage?text=标签正在建设中！！" ."&chat_id=" . $chat_id);  
        // exit;
        // }
        
        // //发送给用户
        // file_get_contents($url . "sendmessage?text=你好，我是由红牛开发的一款演示机器人。具体操作：http://azhe.live" ."&chat_id=" . $chat_id);
    }
    
    public function ceshi(){
        
        $data['text']=input('get.text');
                //获取数据库关键词
        $api=Db::table('api')
        ->alias('a')
        ->join('api_gid b','a.gid=b.gid','LEFT')
        ->where(array('keywords'=>$data['text']))
        ->field('a.gid as agid,a.*,b.*')
        ->find();
        dump($api);
    }
}