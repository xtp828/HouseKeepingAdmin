<?php
/**
 * 获取银行卡信息
 * @param $bank_no
 * @return bool
 */
function getBankInfo ($bank_no) {

    $url = 'http://api.lxtone.com:8089/reward/cash/bankinfo';
    $data = array('bank_card_id' => $bank_no);
    $result = curl_post($url, $data);
    $result = json_decode($result, true);
    if (isset($result) && ! empty($result) && $result['status'] === '00000') {
        return $result['data'];
    }
    return false;
}


function getReceiptQrCode ($data, $code='')
{
    import('Aunt.Vendor.QRCode.qrcode', '', '.php');
    // 纠错级别：L、M、Q、H
    $level = 'L';
    // 点的大小：1到10,用于手机端4就可以了
    $size = 5;

    $rootPath = 'Uploads/qrcode/';
    //$saveName =  'code.png';
	$saveName = date('Ymd') . '.png';
    $filePath = $rootPath  . $saveName;

	
	
	if($code || !file_exists($filePath)){
		// 把二维码图片保存到本地的,如果要保存图片,用$fileName替换第二个参数false
		\QRcode::png($data, $filePath, $level, $size);
	}else{
		return false;
	}

    //if (file_exists($filePath)) {
    //    return $saveName;
    //}
    //return false;
}

/**
 * 添加日志
 */
function add_logs(array $info,$dir = 'pay'){
    $str  = isset($info['title']) && $info['title'] ? '>>Title：' . $info['title'].'----' : '';
    $str .= isset($info['return']) && $info['return'] ? '>>Return：' . $info['return'].'----' : '';
    $str .= isset($info['sql']) && $info['sql'] ? '>>Sql：' . $info['sql'].'----' : '';
    $str .= isset($info['input']) && $info['input'] ? '>>Input：' . $info['input'].'----' : '';
    $str .= '\r\n';

    $info['lab'] = isset($info['lab']) ? $info['lab'] : 'INFO';
    C('LOG_PATH', realpath(LOG_PATH) . '/' . MODULE_NAME . "/{$dir}/");//定义保存日志的路径地
    \Think\Log::write($str, $info['lab']);
}

//获取订单号
function build_order($prefix){
    return $prefix . '0' . mt_rand(10, 99) . date('YmdHis') . substr(microtime(), 2, 6);
}

//去除网页元素
function removeAllTags($sourceData,$noNL=false,$encoding="utf-8"){
    mb_regex_encoding($encoding);
    $newData = mb_ereg_replace("<[^>]*[a-zA-Z]*[^<]*>","",$sourceData);
    $newData = strip_tags($newData);
    if($noNL)$newData = mb_ereg_replace("(.\n)+","",$newData);//去除换行元素
    return $newData;
}

//截取字符串
function sub_Str($oStr,$sLength,$removeTag=true,$spotAddtion=true,$startPoint=0){
    if($removeTag)
        $oStr = removeAllTags($oStr,true);
    $outPut = mb_substr($oStr,$startPoint,$sLength,"utf-8");
    if($spotAddtion)$outPut .= (mb_strlen($oStr,"utf-8")>$sLength)?"...":"";
    return $outPut;
}


//RC4加密
function convert_to_number($str) {
    $length = strlen($str);
    $number_str = '';
    for($i = 0; $i < $length; $i++) {
        $istr = dechex(ord($str[$i]));
        if(strlen($istr) == 1) {
            $istr = '0'.$istr;
        }
        $number_str .= $istr;
    }

    return $number_str;
}

function RC4($data, $key) {
    $seed[] = '';
    $box[]  = '';

    $key_length  = strlen($key);
    $data_length = strlen($data);

    for($i = 0; $i < 256; $i++) {
        $seed[$i] = ord($key[$i%$key_length]);
        $box[$i]  = $i;
    }

    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j+$box[$i]+$seed[$i])%256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    $cipher = '';
    for($a = $j = $i = 0; $i < $data_length; $i++) {
        $a = ($a+1)%256;
        $j = ($j+$box[$a])%256;
        $tmp = $box[$a];

        $box[$a] = $box[$j];
        $box[$j] = $tmp;

        $k = $box[(($box[$a]+$box[$j])%256)];
        $cipher .= chr(ord($data[$i])^$k);
    }

    return $cipher;
}

//充值卡解密
function str_encode($card_pwd){
    $card_key = '1b3k62f7cm24a59e';   					 // 秘钥，由于加密充值卡密码
    $card_pwd = RC4($card_pwd, $card_key);              // 解密

    $card_pwd = convert_to_number($card_pwd);           // 转十六进制
    return $card_pwd;
}


function urlsafe_b64encode($string) {
    $data = base64_encode($string);
    $data = str_replace(array('+','/','='),array('l_l','_',''),$data);
    return $data;
}

function urlsafe_b64decode($string) {
    $data = str_replace(array('l_l','_'),array('+','/'),$string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    return base64_decode($data);
}

function keyED($txt,$encrypt_key) {
    $encrypt_key = md5($encrypt_key);
    $ctr=0;
    $tmp = "";
    for ($i=0;$i<strlen($txt);$i++){
        if ($ctr==strlen($encrypt_key)) $ctr=0;
        $tmp.= substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1);
        $ctr++;
    }
    return $tmp;
}
function encrypt($txt,$key="design is Jack") {
    srand((double)microtime()*1000000);
    $encrypt_key = md5(rand(0,32000));
    $ctr=0;
    $tmp = "";
    for ($i=0;$i<strlen($txt);$i++) {
        if ($ctr==strlen($encrypt_key)) $ctr=0;
        $tmp.= substr($encrypt_key,$ctr,1) . (substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1));
        $ctr++;
    }
    return urlsafe_b64encode(keyED($tmp,$key));
}
function decrypt($txt,$key="design is Jack") {
    $txt = keyED(urlsafe_b64decode($txt),$key);
    $tmp = "";
    for ($i=0;$i<strlen($txt);$i++) {
        $md5 = substr($txt,$i,1);
        $i++;
        $tmp.= (substr($txt,$i,1) ^ $md5);
    }
    return $tmp;
}

/*
 * 窗体一般选择字段产生器
 * @param $AryData 内容
 * @param $selects 被选中的值
 * */
function getOption($AryData,$emptyinfo=false,$selects=false){
    if(is_array($AryData)){
        $str = '<option value="">'.$emptyinfo.'</option>';
        foreach ($AryData as $k=>$v){
            $se = $k == $selects?' selected = "selected"':'';
            $str .= '<option value="'.$k.'" '.$se.'>'.$v.'</option>';
        }
        unset($AryData,$emptyinfo,$selects);
        return $str;
    }
}

