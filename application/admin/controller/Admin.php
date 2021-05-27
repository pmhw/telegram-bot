<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
/**
 * telegram机器人后台管理 作者qq 32579135
**/
class Admin extends Base
{
    
    //后台首页
    public function admin(){
        $data['message_count']=Db::table('tg_message')->where('chat_id>0')->count();//私聊消息合计
        $data['message_count1']=Db::table('tg_message')->where('chat_id<0')->count();//群消息合计
        $data['api_count']=Db::table('api')->count();//群消息合计
        
        //返回服务器信息
        $info = array(
        'czxt'=>PHP_OS,//操作系统
        'yxhj'=>$_SERVER["SERVER_SOFTWARE"],//运行环境
        'phpyxfs'=>php_sapi_name(),//PHP运行方式
        'scfj'=>ini_get('upload_max_filesize'),//上传附件限制
        'jxsj'=>ini_get('max_execution_time').'秒',//执行时间限制
        'fwq_time'=>date("Y年n月j日 H:i:s"),//服务器时间
        'bj_time'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),//北京时间
        'ip'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',//服务器ip 域名
        'sykj'=>round((disk_free_space(".")/(1024*1024)),2).'M',//剩余空间
        'register_globals'=>get_cfg_var("register_globals")=="1" ? "ON" : "OFF",
        'magic_quotes_gpc'=>(1===get_magic_quotes_gpc())?'YES':'NO',
        'magic_quotes_runtime'=>(1===get_magic_quotes_runtime())?'YES':'NO',
        );
        
        
        //获取机器人信息
        $admin=Db::table('admin')->where(array('id'=>1))->find();
        $token=$admin['token'];
        $url = "https://api.telegram.org/bot".$token."/getMe";
    
        $headerArray =array("Content-type:application/json;charset='utf-8'","Accept:application/json");
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        //curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        $update=json_decode($output,true);
        //dump($update);
        $data['first_name']=$update['result']['first_name'];//机器人组名
        $data['username']=$update['result']['username'];//机器人姓名
        $data['can_join_groups']=$update['result']['can_join_groups'];//可以加入组织？turn，false
        $data['can_read_all_group_messages']=$update['result']['can_read_all_group_messages'];//可以读取所有群组消息吗
        $data['supports_inline_queries']=$update['result']['supports_inline_queries'];//支持内联查询
        
        
        //获取WebhookInfo信息
        $url1 =  "https://api.telegram.org/bot".$token."/getWebhookInfo?url=/".$_SERVER['SERVER_NAME']."/admin/Api/index";
        
        $aurl = curl_init();
        curl_setopt($aurl, CURLOPT_URL, $url1);
        curl_setopt($aurl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($aurl, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($aurl, CURLOPT_POST, 1);
        //curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($aurl,CURLOPT_HTTPHEADER,$headerArray);
        curl_setopt($aurl, CURLOPT_RETURNTRANSFER, 1);
        $WebhookInfo = curl_exec($aurl);
        curl_close($aurl);
        $Webhook=json_decode($WebhookInfo,true);
        //解析
        $data['ok']=$Webhook['ok'];//Webhook回复
        $data['pending_update_count']=$Webhook['result']['pending_update_count'];//等待更新数
        $data['last_error_date']=$Webhook['result']['last_error_date'];//最后报错时间
        $data['last_error_message']=$Webhook['result']['last_error_message'];//最后报错信息
        $data['max_connections']=$Webhook['result']['max_connections'];//最大连接数
        
        $this->assign('info',$info);
        
        $this->assign('data',$data);
        return $this->fetch();
    }
    
    //机器人消息界面
    public function message(){
        $data['title1']='消息中心';
        $data['tg_message']=Db::table('tg_message')->order('id desc')->paginate(10);
        //dump($data['tg_message']);
        
        $this->assign('data',$data);
        return $this->fetch();
    }
    
    //机器人设置界面
    public function setting_bot(){
        $data['title1']='机器人设置';
        $request = Request::instance();
        $data['url']=$request->domain();
        $data['admin']=Db::table('admin')->where(array('id'=>$this->_admin['id']))->find();
        $this->assign('data',$data);
        return $this->fetch();
    }
    
    //回复信息列表
    public function huifu(){
        $data['title1']='回复列表';
        
        $paixu=input('get.paixu');
        
        //智能回复列表
        $data['api']=Db::table('api')
        ->alias('a')
        ->join('api_gid b','a.gid=b.gid','LEFT')
        ->field('a.gid as agid,a.*,b.*')
        ->order($paixu)
        ->select();
        
        
        $this->assign('data',$data);
        return $this->fetch();
    }
    
    
    //自定义回复-智能回复
    public function huifu_zn(){
        $data['title1']='智能回复';
        //获取参数标签
        $data['api_gid']=Db::table('api_gid')->select();
        
        $this->assign('data',$data);
        return $this->fetch();
    }
    
    //自定义回复-标签回复
    public function huifu_bq(){
        $data['title1']='标签回复';
        
        //获取参数标签
        $data['api_gid']=Db::table('api_gid')->select();
        $this->assign('data',$data);
        return $this->fetch();
    }
    
    //添加商品
    public function shangpin(){
        $data['title1']='添加商品';
        
        $data['shangpin_gid']=Db::table('shangpin_gid')->select();
        
        $data['shangpin']=Db::table('shangpin')->select();
        
        $this->assign('data',$data);
        return $this->fetch();
    }
    
    
    //添加商品分组
    public function shangpin_gid(){
        $data['title1']='商品分组';
        
        $data['url']=$_SERVER['SERVER_NAME'];//获取网站域名
        $data['shangpin_gid']=Db::table('shangpin_gid')->select();
        $this->assign('data',$data);
        return $this->fetch();
    }
    
    
    
    /**
     * 请求
    */
    
    
    //保存密钥
    public function add_token(){
        $data['token']=input('post.token');
        if(!$data['token']){
            exit(json_encode(array('code'=>1,'msg'=>'token为空')));
        }
        
        $res=Db::table('admin')->where(array('id'=>$this->_admin['id']))->update($data);
        if(!$res){
           exit(json_encode(array('code'=>1,'msg'=>'保存失败')));
        }
        exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
    }
    
    
    //保存回复信息
    public function add_api(){
        $data['gid']=input('post.gid');
        $data['keywords']=input('post.keywords');
        $data['text']=trim(input('post.text'));
        
        $data['add_time']=time();
        
        if(!$data['gid']){
            exit(json_encode(array('code'=>1,'msg'=>'gid为空')));
        }
        
        if(!$data['keywords']){
            exit(json_encode(array('code'=>1,'msg'=>'keywords为空')));
        }
        
        if(!$data['text']){
            exit(json_encode(array('code'=>1,'msg'=>'text为空')));
        }
        
        $api=Db::table('api')->where(array('keywords'=>$data['keywords']))->find();
        if($api){
            exit(json_encode(array('code'=>1,'msg'=>'您已设置过此关键词，无需重复设置！')));
        }
        
        $res = Db::table('api')->insert($data);
        if(!$res){
           exit(json_encode(array('code'=>1,'msg'=>'保存失败'))); 
        }
        exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
    }
    
    //删除回复信息请求
    
    public function delete_api(){
        $id=input('get.id');
        $res = Db::table('api')->where(array('id'=>$id))->delete();
        if(!$res){
           exit(json_encode(array('code'=>1,'msg'=>'删除失败'))); 
        }
        exit(json_encode(array('code'=>0,'msg'=>'删除成功')));
    }
    
    //保存商品分组
    public function add_shangpingid(){
        $data['name']=input('post.name');
        if($data['name']==''){
            exit(json_encode(array('code'=>1,'msg'=>'name为空')));
        }
        
        $data['add_time']=time();
        
        $insert=Db::table('shangpin_gid')->insert($data);
        if(!$insert){
            exit(json_encode(array('code'=>1,'msg'=>'保存失败')));
        }
        exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
    }
    
    //删除商品分组
    public function delete_shangpingid(){
        $gid=input('get.gid');
        $res = Db::table('shangpin_gid')->where(array('gid'=>$gid))->delete();
        if(!$res){
           exit(json_encode(array('code'=>1,'msg'=>'删除失败'))); 
        }
        exit(json_encode(array('code'=>0,'msg'=>'删除成功')));
    }
    
    //商品封面图
    public function update_img(){
        $file = request()->file('file');
        if($file==null){
          exit(json_encode(array('code'=>1,'msg'=>'未选择文件'))); 
        }
        $info = $file->move(ROOT_PATH . 'public' . DS . 'fengmian_img');
        $ext = ($info->getExtension());
        if(!in_array($ext,array('jpg','png','gif','jpeg'))){
            exit(json_encode(array('code'=>1,'msg'=>'文件格式错误')));
        } 
        $img = '/fengmian_img/'.$info->getSaveName(); //获取文件路径
        exit(json_encode(array('code'=>0,'msg'=>$img)));  
    }
    
    //商品图片保存
    public function update_shangpinimg(){
        $file = request()->file('file');
        if($file==null){
          exit(json_encode(array('code'=>1,'msg'=>'未选择文件'))); 
        }
        $info = $file->move(ROOT_PATH . 'public' . DS . 'shangpin_img');
        $ext = ($info->getExtension());
        if(!in_array($ext,array('jpg','png','gif','jpeg'))){
            exit(json_encode(array('code'=>1,'msg'=>'文件格式错误')));
        } 
        $img = '/user_img/'.$info->getSaveName(); //获取文件路径
        exit(json_encode(array('code'=>0,'msg'=>$img)));
    }
    
    
    //保存商品信息接口
    public function add_shangpin(){
        $data['title']=input('post.title');
        $data['gid']=input('post.gid');
        $data['content']=input('post.content');
        $data['fengmian_img']=input('post.img');
        $data['add_time']=time();
       // if(!$data['title'] || !$data['gid'] || !$data['content'] || !$data['fengmian_img'] || !$data['add_time']){
        //    exit(json_encode(array('code'=>1,'msg'=>'参数错误')));
        //}
        
        
        $insert=Db::table('shangpin')->insert($data);
        if(!$insert){
            exit(json_encode(array('code'=>1,'msg'=>'保存失败')));
        }
        exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
        
    }
    
    //删除商品信息
    public function delete_shangpin(){
        $gid=input('get.id');
        $res = Db::table('shangpin')->where(array('id'=>$id))->delete();
        if(!$res){
           exit(json_encode(array('code'=>1,'msg'=>'删除失败'))); 
        }
        exit(json_encode(array('code'=>0,'msg'=>'删除成功')));        
    }
}
