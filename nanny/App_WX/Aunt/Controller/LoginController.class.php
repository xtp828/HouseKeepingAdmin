<?php
/**
 * 登录窗口类
 * User: Administrator
 * Date: 2017/1/23
 * Time: 18:06
 */
namespace Aunt\Controller;
use Aunt\Controller\CommonService;
class LoginController extends CommonService
{
    /**
     * @Function:登录页面
     * @Author:xtp
     * @Date:2017-01-23 18:28
     */
    public function enter(){
        $this->display();
    }

    /**
     * @Function:提交登录
     * @Author:xtp
     * @Date:2017-01-23 18:30
     */
    public function submit_login(){
        $user_name  = str_replace(' ','',I('post.user_name',''));
        $pwd        = str_replace(' ','',I('post.pwd',''));

        if(empty($user_name)){
            $this->ajaxReturn(array('status' => 0,'msg' => '用户名不能为空'));
        }
        if(empty($pwd)){
            $this->ajaxReturn(array('status' => 0,'msg' => '密码不能为空'));
        }

        $user = M('user');
        $user = $user->where(array('name' => $user_name))->find();
        if (empty($user['id'])) {
            $this->ajaxReturn(array('status' => 0,'msg' => '不存在此账户'));
        }

        if ($user['passwd'] !== md5($pwd)) {
            $this->ajaxReturn(array('status' => 0,'msg' => '密码或者账户错误'));
        } else {
            session('aunt',null); // 删除name
            session('aunt', $user);
        }
        $this->ajaxReturn(array('status' => 1,'msg' => '登录成功'));
    }

    /**
     * @Function:输出验证码
     * @Author:xtp
     * @Date:2017-01-23 18:31
     */
    public function verify() {
        $config = array(
            'fontSize' => 20, // 验证码字体大小
            'length' => 4, // 验证码位数
            'useNoise' => false, // 关闭验证码杂点
            'imageW'=>150,
            'imageH'=>50,
        );
        $verify = new \Think\Verify($config);
        $verify ->entry('login');
    }

    /**
     * @Function:检测验证码
     * @Author:xtp
     * @Date:2017-01-23 18:31
     */
    function check_verify($code, $id = '') {
        $verify = new \Think\Verify();
        return $verify -> check($code, $id);
    }

    /**
     * @Function:退出
     * @Author:xtp
     * @Date:2017-01-23 18:28
     */
    public function lay_out(){
        unset($_SESSION);
        session_destroy();
        echo "<script>window.parent.location.href='".U('login/enter')."'</script>";
    }
}