<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
	<script type="text/javascript" src="/Public/aunt/lib/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
<!--<?php if($txt): endif; ?>-->
<img src="/Uploads/qrcode/<?php echo ($code); ?>"/>
<span id='again_build' style="    padding: 5px;background: brown;">重新生成</span>
<!--<form action="<?php echo U('build_qrcode');?>" method="post">
<input type="text" name="qrcode"/>
    <input type="submit" name="提交"/>
</form>-->
<script>
$(function(){
  $('#again_build').click(function(){
		$.ajax({
            url:"<?php echo U('user/again_qrcode');?>",
            type:'POST', //GET
            dataType:'json',    //返回的数据格式：json/xml/html/script/jsonp/text
            success:function(data){
                if(data.status == 1){
                    window.location.reload();
                }
            },
        });
  });
});
</script>
</body>
</html>