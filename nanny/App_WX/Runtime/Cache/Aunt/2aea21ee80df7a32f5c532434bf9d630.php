<?php if (!defined('THINK_PATH')) exit();?><!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <LINK rel="Bookmark" href="/favicon.ico" >
    <LINK rel="Shortcut Icon" href="/favicon.ico" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/Public/aunt/lib/html5.js"></script>
    <script type="text/javascript" src="/Public/aunt/lib/respond.min.js"></script>
    <script type="text/javascript" src="/Public/aunt/lib/PIE_IE678.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/Public/aunt/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/Public/aunt/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/Public/aunt/lib/Hui-iconfont/1.0.7/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/Public/aunt/lib/icheck/icheck.css" />
    <link rel="stylesheet" type="text/css" href="/Public/aunt/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/Public/aunt/static/h-ui.admin/css/style.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <!--/meta 作为公共模版分离出去-->

    <title>添加用户</title>
    <style>
        .table td{line-height: 19px;border: 1px solid #b73bbf;word-break: break-all;padding:1px 2px;}
        .table .lab_td{text-align: center;}
    </style>
</head>
<body>
<article class="page-container">
    <form class="form-horizontal" enctype='multipart/form-data' id='addclient' name='addclient' method='post' action='/index.php/Aunt/User/add'>
        <div class="table-c" align="center">
            <table width="800" border="0" cellspacing="0" cellpadding="0" class="table table-border table-bordered table-hover table-bg table-sort" style="width: 56%;    border-collapse: collapse;border-spacing: 0;">
                <tr>
                    <td colspan="5" style="background-color: #b73bbf;font-size: 16px;padding: 7px 13px;color: antiquewhite;">
                        基本信息
                    </td>
                </tr>
                <tr>
                    <td rowspan="9" width="10%">
                        <div class="img"><img src="/Uploads/aunt_img/mini/<?php echo ($info["pic"]); ?>" class="myimg" id="img1" myid="1"></div>
                        <input name="cid" value="<?php echo ($info["id"]); ?>" type="hidden" />
                    </td>
                </tr>

                <tr>
                    <td class="lab_td">姓名</td>
                    <td ><?php echo ($info["name"]); ?></td>
                    <td class="lab_td">工号</td>
                    <td><?php echo ($info["jobnumber"]); ?></td>
                </tr>

                <tr>
                    <td class="lab_td">籍贯</td>
                    <td>
                        <?php echo ($info["city"]); ?>
                    </td>
                    <td class="lab_td">年龄</td>
                    <td><?php echo ($info["age"]); ?></td>
                </tr>


                <tr>
                    <td class="lab_td">属相</td>
                    <td><?php echo ($info["animal"]); ?></td>
                    <td class="lab_td">工作类型</td>
                    <td><?php echo ($info["wtype"]); ?></td>
                </tr>

                <tr>
                    <td class="lab_td">学历</td>
                    <td><?php echo ($info["edu"]); ?></td>
                    <td class="lab_td">食宿</td>
                    <td><?php echo ($info["room"]); ?></td>
                </tr>

                <tr>
                    <td class="lab_td">出生年月</td>
                    <td>
                        <?php echo ($info["birth"]); ?>
                    </td>
                    <td class="lab_td">工作年限</td>
                    <td><?php echo ($info["worktime"]); ?></td>
                </tr>

                <tr>
                    <td class="lab_td">资质证书</td>
                    <td>
                        <?php echo ($info["certification"]); ?>
                    </td>
                    <td class="lab_td">服务过家庭</td>
                    <td>
                        <?php echo ($info["shome"]); ?> 个
                    </td>
                </tr>

                <tr>
                    <td class="lab_td">语言能力</td>
                    <td><?php echo ($info["language"]); ?></td>
                    <td class="lab_td">煮菜口味</td>
                    <td><?php echo ($info["taste"]); ?></td>
                </tr>

                <tr>
                    <td class="lab_td">工作区域</td>
                    <td><?php echo ($info["workspace"]); ?> </td>
                    <td class="lab_td">工作状态</td>
                    <td>
                        <?php echo ($info["workstate"]); ?>
                    </td>

                </tr>

                <!--<tr>
                    <td>手机号码</td>
                    <td>
                        <?php echo ($info["phone"]); ?>
                    </td>
                    <td>入住时间</td>
                    <td><?php echo ($info["createtime"]); ?></td>
                </tr>-->

                <tr>
                    <td style="text-align: center;">工作经历</td>
                    <td colspan="5"><?php echo ($info["workhistory"]); ?></td>
                </tr>
                <tr>
                    <td style="text-align: center;">工作技能</td>
                    <td colspan="5"><?php echo ($info["workability"]); ?></td>
                </tr>
                <tr>
                    <td style="text-align: center;">自我评价</td>
                    <td colspan="5"><?php echo ($info["evaluation"]); ?></td>
                </tr>
                <tr>
                    <td colspan="5" style="background-color: #b73bbf;padding:2px;">
                    </td>
                </tr>
            </table>
        </div>
    </form>
</article>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/aunt/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/Public/aunt/lib/layer/2.1/layer.js"></script>
<script type="text/javascript" src="/Public/aunt/lib/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/Public/aunt/lib/jquery.validation/1.14.0/messages_zh.min.js"></script>
<script type="text/javascript" src="/Public/aunt/static/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="/Public/aunt/static/h-ui.admin/js/H-ui.admin.js"></script>
<!--/_footer /作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript">

    var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
    function sub_form(){
        $.ajax({
            url:"<?php echo U('user/user_edit_submit');?>",
            type:'POST', //GET
            data:$('#addclient').serialize(),
            dataType:'json',    //返回的数据格式：json/xml/html/script/jsonp/text
            beforeSend:function(xhr){
                layer.load();
            },
            success:function(data){
                layer.closeAll('loading');
                if(data.status == 1){
                    tips(data.msg,'',6);
                    //parent.parent.window.location.reload();
                    parent.layer.close(index);
                }else{
                    tips(data.msg);
                }
            },
        });
    }

    //提示窗口
    function tips(){
        msg = arguments[0] ? arguments[0] : '出现错误';
        offsets = arguments[1] ? arguments[1] : '50px';
        icon = arguments[2] ? arguments[2] : 5;
        parent.layer.msg(msg, {time: 800, icon:icon,shade: 0.3,offset: offsets });
    }

    $(function(){
        $(".myimg").click(function () {
            $('#file' + $(this).attr("myid")).click();
        });

        //上传图片
        $(".uploadpic").change(function () {
            var myid = $(this).attr("myid");
            var img = $('#img' + myid);
            var myimg = img.attr("src");
            img.attr("src", "/Public/aunt/image/loading.gif");
            var file = this.files[0];
            if (!file || !file.type.match(/image.*/)) return;
            if (file.size > 40000000) {
                alert("图片大小<10M");
                return;
            }
            var fd = new FormData();
            fd.append("id", 9163);
            fd.append("name", $(this).attr("myname"));
            fd.append("img", file);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "<?php echo U('user/upload_pic');?>");
            var span = document.createElement("span");
            img.after(span);
            xhr.upload.addEventListener("progress", function (e) {
                if (e.lengthComputable) {
                    var percentage = Math.round((e.loaded * 100) / e.total);
                    span.innerText = percentage + "%";
                }
            }, false);
            xhr.addEventListener("readystatechange", function (e) {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var res = JSON.parse(xhr.responseText);
                    if (res.status) {
                        img.attr("src", res.thumb);
                        $("#pic").attr("value", res.img);
                    } else {
                        tips(res.msg);
                        img.attr("src", myimg);
                        $('#file' + myid).val('');
                    }
                    span.parentNode.removeChild(span);
                    span = null;
                }
            }, false);
            xhr.send(fd);
        });
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>