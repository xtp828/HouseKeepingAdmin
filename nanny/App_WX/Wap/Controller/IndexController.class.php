<?php
namespace Wap\Controller;
use Think\Controller;
class IndexController extends Controller
{
    public function index()
    {

        echo $ip;
        $this->display('index/index');
    }

    /**
     * 获取服务器端IP地址
     * @return string
     */
    public static function get_server_ip()
    {
        if (isset($_SERVER)) {
            if ($_SERVER['SERVER_ADDR']) {
                $server_ip = $_SERVER['SERVER_ADDR'];
            } else {
                $server_ip = $_SERVER['LOCAL_ADDR'];
            }
        } else {
            $server_ip = getenv('SERVER_ADDR');
        }
        return $server_ip;
    }



    public function up_pic(){
        $base64_string = $_POST['base64_string'];
        $savename = uniqid().'.jpeg';//localResizeIMG压缩后的图片都是jpeg格式
        //生成缩略图
        $savepath = 'Uploads/aunt_img/'.$savename;
        $image = self::base64_to_img( $base64_string, $savepath );
        if($image){
            $img = new \Think\Image();
            $img->open($savepath);
            $thumb_path = 'Uploads/aunt_img/mini/'.$savename;
            $img->thumb(200,200)->save($thumb_path);
           echo '{"status":1,"content":"上传成功","img":"'.$savename.'","url":"'.'http://'.self::get_server_ip().'/nanny/'.$image.'"}';
        }else{
            echo '{"status":0,"content":"上传失败"}';
        }

    }

    public static function base64_to_img( $base64_string, $output_file ) {
        $ifp = fopen( $output_file, "w" );
        fwrite( $ifp, base64_decode( $base64_string) );
        fclose( $ifp );
        return( $output_file );
    }

    public function submit_user(){
        $name = $_POST['name'];
        $phone = $_POST['phone'];

        if(empty($name) || empty($phone)  || empty($_POST['pic'])){
            echo '{"status":0,"content":"姓名和手机号不能为空"}';
            exit;
        }

        $id = M('client')->where(array('phone' => $phone))->getField('id');
        if($id){
            echo '{"status":0,"content":"此阿姨手机号存在，不能重复提交"}';
            exit;
        }

        $_POST['jobnumber'] = M('client')->getField('MAX(`jobnumber`) as jobnumber');
        $_POST['jobnumber'] = $_POST['jobnumber']+1;
        $_POST['createtime'] = date('Y-m-d H:i:s');
        M('client')->add($_POST);
        echo '{"status":1,"content":"添加成功"}';
    }
}