<?php
return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    
        //Index
    'index'=>'index/Index/index',//
    
    'admin'=>'admin/Admin/admin',
    'message'=>'admin/Admin/message',
    'setting_bot'=>'admin/Admin/setting_bot',//机器人api配置
    'huifu'=>'admin/Admin/huifu',
    'huifu_zn'=>'admin/Admin/huifu_zn',
    'huifu_bq'=>'admin/Admin/huifu_bq',
    'login'=>'admin/login/login',
    'api'=>'admin/Api/index',//telegram回调接口
    'api1'=>'admin/Api/ceshi',//api测试
    'shangpin'=>'admin/admin/shangpin',
    'shangpin_gid'=>'admin/Admin/shangpin_gid',
    
    'add_token'=>'admin/Admin/add_token',//保存密钥
    'add_api'=>'admin/Admin/add_api',//保存api
    'delete_api'=>'admin/Admin/delete_api',//删除api
    'dulogin'=>'admin/Login/dulogin',
    'add_shangpingid'=>'admin/Admin/add_shangpingid',//保存商品分类
    'delete_shangpingid'=>'admin/Admin/delete_shangpingid',//删除商品分类
    'add_shangpin'=>'admin/Admin/add_shangpin',//保存商品信息
    'update_img'=>'admin/Admin/update_img',//图片封面
    'update_shangpinimg'=>'admin/Admin/update_shangpinimg',//商品图片存
    
    
    'index'=>'admin/Index/index',

];
