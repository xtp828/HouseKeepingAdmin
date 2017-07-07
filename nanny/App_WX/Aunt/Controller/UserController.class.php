<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/23
 * Time: 20:56
 */

namespace Aunt\Controller;
use Aunt\Controller\CommonService;
class UserController extends CommonService
{
    /**
     * @Function:阿姨列表
     * @Author:xtp
     * @Date:2017-01-23 20:57
     */
    public function aunt_list(){
        $search_info = str_replace(' ','',I('get.search_info'));
        $search_type = I('get.search_type');
        $p = I('get.p', 0);
        if($search_info && $search_type){
            if(in_array($search_type,array('age','phone','jobnumber'))){
                $where[$search_type] = $search_info;
            }else{
                $where[$search_type] = array('like',"%{$search_info}%");
            }
        }
        if(I('get.createtime')){
            $where['createtime'] = array('EGT',date('Y-m-d'));
        }
        $where['status'] = 1;
        $this->assign('content',M('client')->page($p . ',10')->where($where)->order('createtime desc')->select());
        $count = M('client')->where($where)->count();
        $p = new \Think\Page($count, 10);
        $this->assign('page', $p->shows());// 赋值分页输出
        $this->assign('count', $count);// 赋值分页输出
        $this->assign('search_type',getOption(C('AUNT_TYPE'),'--请选择搜索条件--',$search_type));
        $this->display();
    }

    /**
     * @Function:用户编辑页面
     * @Author:xtp
     * @Date:2017-01-24 09:18
     */
    public function user_edit(){
        $id = I('get.id',0);
        $info = array();
        if(!empty($id)){
            $info = M('client')->where(array('id' => $id))->find();
        }else{
            $job_number = M('client')->getField('MAX(`jobnumber`) as jobnumber');
            $info['jobnumber'] = $job_number + 1;
        }
        $info['wtype'] = $info['wtype'] ? : '全职育婴师、保姆';
        $info['room'] = $info['room'] ? : '住家';
        $info['certification'] = $info['certification'] ? : '育婴师证、催乳师证';
        $info['language'] = $info['language'] ? : '普通话、上海话';
        $info['taste'] = $info['taste'] ? : '上海菜、广东菜、浙江菜';
        $info['workspace'] = $info['workspace'] ? : '不限';
        $info['workstate'] = $info['workstate'] ? : '待岗';
        $info['workability'] = $info['workability'] ? : '上海菜/煲汤/面食/对烧饭/烫衣服/有信心；';
        $info['evaluation'] = $info['evaluation'] ? : '阿姨责任心强，有耐心，信心，得到客户的好评';

        $info['edu'] = getOption(C('EDU'),'--请选择--',$info['edu']);
        $info['animal'] = getOption(C('ANIMAL'),'--请选择--',$info['animal']);
        $info['workstate'] = getOption(C('WORK_STAUS'),'--请选择--',$info['workstate']);
        $info['room'] = getOption(C('ROOM'),'--请选择--',$info['room']);
        $info['worktime'] = getOption(C('WORK_TIME'),'--请选择--',$info['worktime']);
        $info['shome'] = getOption(C('SERVER_HOME'),'--请选择--',$info['shome']);
        $this->assign('info',$info);
        $this->display();
    }

    /**
     * @Function: 查看用户信息
     * @Author:xtp
     * @Date:2017-01-27 17:08
     */
    public function chk_user(){
        $id = I('get.id',0);
        if(!empty($id)){
            $info = M('client')->where(array('id' => $id))->find();
            $info['workhistory'] = str_replace('；','<br/>',$info['workhistory']);
        }else{
            exit('传入的数据错误');
        }
        $this->assign('info',$info);
        $this->display();
    }

    /**
     * @Function:用户编辑增加和编辑提交
     * @Author:xtp
     * @Date:2017-01-24 09:19
     */
    public function user_edit_submit(){
        if(!IS_POST){
            $this->ajaxReturn(array('status' => 0, 'msg' => '上传错误'));
        }
        $input = I('post.');
        if(!is_array($input) || count($input)<=0){
            $this->ajaxReturn(array('status' => 0, 'msg' => '上传不能为空'));
        }
        if(!$input['pic']){
            $this->ajaxReturn(array('status' => 0, 'msg' => '人头像还未上传'));
        }

        foreach (C('AUNT_TYPE') as $key => $value){
            if(!$input[$key]){
                $this->ajaxReturn(array('status' => 0, 'msg' => $value.'不能为空'));
            }
        }

        $nows = date('Y-m-d H:i:s');
        if($input['cid']){
            $input['updatetime'] = $nows;
            $result = M('client')->where(array('id' => $input['cid']))->save($input);
        }else{
            $input['createtime'] = $nows;
            $result = M('client')->Add($input);
        }

        unset($nows,$input);
        if($result){
            $this->ajaxReturn(array('status' => 1, 'msg' => '编辑信息成功'));
        }else{
            $this->ajaxReturn(array('status' => 0, 'msg' => '编辑信息失败'));
        }

    }

    /**
     * @Function:上传图像
     * @Author:xtp
     * @Date:2017-01-24 10:03
     */
    public function upload_pic(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->key   =     'img' ;// 设置附件上传大小
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->saveName = array('uniqid','');
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload_path = './Uploads/';
        $upload->rootPath  =     $upload_path; // 设置附件上传根目录
        $upload->autoSub = true;
        $upload->subName = 'aunt_img';
        // 上传文件
        $info   =   $upload->upload();

        if(!$info) {// 上传错误提示错误信息
            $this->ajaxReturn(array('status' => 0,'msg' =>'上传失败'));
        }
        //生成缩略图
        $source_img = $upload_path.'aunt_img/'.$info['img']['savename'];
        $thumb_path = $upload_path.'aunt_img/mini/'.$info['img']['savename'];
        $image = new \Think\Image();
        $image->open($source_img);
        $image->thumb(200,200)->save($thumb_path);
        $this->ajaxReturn(array('status' => 1,'msg' =>'上传成功','thumb' => ltrim($thumb_path,'.'),'img' => $info['img']['savename']));
    }

    /**
     * @Function:阿姨信息导出
     * @Author:xtp
     * @Date:2017-01-26 11:04
     */
    public function aunt_info_export(){
        $search_info = str_replace(' ','',I('get.search_info'));
        $search_type = I('get.search_type');

        if($search_info && $search_type){
            if(in_array($search_type,array('age','phone','jobnumber'))){
                $where[$search_type] = $search_info;
            }else{
                $where[$search_type] = array('like',"%{$search_info}%");
            }
        }
        if(I('get.createtime')){
            $where['createtime'] = array('EGT',date('Y-m-d'));
        }
        $where['status'] = 1;
        $result = M('client')->where($where)->order('createtime desc')->select();

        $title = 'yz_aunt_'.date('ymd');
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename={$title}.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $str1 = '';
        $str1 = '<html xmlns:o="urn:schemas-microsoft-com:office:office"
		   xmlns:x="urn:schemas-microsoft-com:office:excel"
		   xmlns="http://www.w3.org/TR/REC-html40">
		<head>
		   <meta http-equiv="expires" content="Mon, 06 Jan 1999 00:00:01 GMT">
		   <meta http-equiv=Content-Type content="text/html; charset=GBK">
		   <!--[if gte mso 9]><xml>
		   <x:ExcelWorkbook>
		   <x:ExcelWorksheets>
			 <x:ExcelWorksheet>
			 <x:Name></x:Name>
			 <x:WorksheetOptions>
			   <x:DisplayGridlines/>
			 </x:WorksheetOptions>
			 </x:ExcelWorksheet>
		   </x:ExcelWorksheets>
		   </x:ExcelWorkbook>
		   </xml><![endif]-->
		</head>';
        echo iconv('UTF-8', 'GBK', $str1);

        $style  = "style='text-align:center;background:#6FB3E0;'";
        $header = "<tr><td colspan=18 style='color:red;font-size:20px;text-align:center;'>".C('TITLE')."-阿姨信息</td></tr>
					<tr>
					<td {$style}>姓名</td>
					<td {$style}>工号</td>
					<td {$style}>手机号</td>
					<td {$style}>籍贯</td>
					<td {$style}>年龄</td>
					<td {$style}>工作区域</td>
					<td {$style}>工作类型</td>
					<td {$style}>学历</td>
					<td {$style}>入住时间</td>
					<td {$style}>食宿</td>
					<td {$style}>出生年月</td>
					<td {$style}>工作年限</td>
					<td {$style}>资质证书</td>
					<td {$style}>服务过家庭</td>
					<td {$style}>工作状态</td>
					<td {$style}>工作经历</td>
					<td {$style}>工作技能</td>
					<td {$style}>自我评价</td>
					</tr>";
        $str = '';
        foreach ($result as $v) {
            $str .= "<tr>
                    <td>".iconv('UTF-8', 'GBK', $v['name'])."</td>
                    <td>".iconv('UTF-8', 'GBK', $v['jobnumber'])."</td>
                    <td>".iconv('UTF-8', 'GBK', $v['phone'])."</td>
                    <td>".iconv('UTF-8', 'GBK', $v['city'])."</td>
                    <td>".iconv('UTF-8', 'GBK', $v['age'])."</td>
                    <td>".iconv('UTF-8', 'GBK', $v['workspace'])."</td>
                    <td>".iconv('UTF-8', 'GBK', $v['wtype'])."</td>
                    <td>".iconv('UTF-8', 'GBK', $v['edu'])."</td>
                    <td>".iconv('UTF-8', 'GBK', $v['creattime'])."</td>
                    <td>".iconv('UTF-8', 'GBK', $v['room'])."</td>
                    <td>".iconv('UTF-8', 'GBK', $v['birth'])."</td>
                    <td>".iconv('UTF-8', 'GBK', $v['worktime'])."</td>
                    <td>".iconv('UTF-8', 'GBK', $v['certification'])."</td>
                    <td>".iconv('UTF-8', 'GBK', $v['shome'] . '个')." </td>
                    <td>".iconv('UTF-8', 'GBK', $v['workstate'])."</td>
                    <td>".iconv('UTF-8', 'GBK', $v['workhistory'])."</td>
                    <td>".iconv('UTF-8', 'GBK', $v['workability'])."</td>
                    <td>".iconv('UTF-8', 'GBK', $v['evaluation'])."</td>
                    </tr>";
        }
        $content = iconv('UTF-8', 'GBK', $header) .  $str; // $header.$str;
        echo '<table>' . $content . '</table>';
    }

    /**
     * @Function: 生成二维码
     * @Author:xtp
     * @Date: 2017-01-28 10:37
     */
    public function build_qrcode(){
        exec('ipconfig',$output);
		//print_r($output);
        $ip = substr($output[8],strpos($output[8],'192'),100);
        getReceiptQrCode('http://'.$ip.'/nanny/index.php/wap');
        $this->assign('code',date('Ymd') . '.png');
        $this->display('User/qrcode');
    }
	
	//重新生成二维码
	public function again_qrcode(){
		exec('ipconfig',$output);
        $ip = substr($output[8],strpos($output[8],'192'),100);
		getReceiptQrCode('http://'.$ip.'/nanny/index.php/wap',1);
        $this->ajaxReturn(array('status' => 1,'msg' =>'重新生成成功'));
	}

    public function get_rotate(){
        self::rotate($_POST['pic'],90);
        $this->ajaxReturn(array('status' => 1,'msg' =>'翻转成功'));
    }

    /**
     * @Function:翻转图片
     * @Author:xtp
     * @Date:2017-01-28 19:04
     */
    public static function rotate($filename,$degrees){
        //创建图像资源，以jpeg格式为例
        $source = imagecreatefromjpeg($filename);
        //使用imagerotate()函数按指定的角度旋转
        $rotate = imagerotate($source, $degrees, 0);
        //旋转后的图片保存
        imagejpeg($rotate,$filename);
    }
}