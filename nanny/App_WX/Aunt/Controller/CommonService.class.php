<?php
/**
 *
 * 继承控制层基础类
 *@author:xtp author
 *@date:2016-06-25
 **/

namespace Aunt\Controller;
use Common\Controller\BaseController;
use Think\Auth;
class CommonService extends BaseController
{ 
	/*
	 * 控制层初始化
	 * */
    public function _initialize()
    {
        $contr_name = strtolower(trim(CONTROLLER_NAME));//获取当前控制器类
        self::is_login($contr_name);
    }

    //判断是否登录系统
    public static function is_login($contr_name){
        if($contr_name != 'login'){
            $user_id = session('aunt.id');
            if(empty($user_id)){
                if(I('post.sub_type')){
                    exit(json_encode(array('status' => 2, 'msg' => '登录超时，请重新登录')));
                }else{
                    echo "<script>window.parent.location.href='".U('login/enter')."'</script>";
                }
            }
        }
    }
}