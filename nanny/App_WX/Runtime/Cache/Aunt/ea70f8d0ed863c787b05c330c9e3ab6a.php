<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
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
    <title>用户管理</title>
    <style>
        .head_pic{width:120px;height:140px;}
        .user_lable{background-color: #97d1ef;width: 10%;font-size: 15px;}
        .epy_nav{height:20px;}
        ul li{  list-style: none;float:left; padding: 2px 12px;  border: 1px solid #b5afaf;margin:0px 2px;}
        .active{    background-color: #5eb95e;  color: #FFf;}
        .table td{padding:2px;}
    </style>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户管理 <span class="c-gray en">&gt;</span> 阿姨列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form action="<?php echo U('aunt_list');?>" method="get" id="fm1">
    <div class="text-c"> 搜索：
        <select class="input-text" name="search_type" style="width: 100px;vertical-align: middle;"><?php echo ($search_type); ?></select>
        <input type="text" class="input-text" name="search_info" style="width:200px" placeholder="根据条件搜索姓名，手机号等信息" value="<?php echo I('get.search_info');?>" />
        入住时间:
        <input type="text" class="input-text" name="createtime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" style="width:150px" placeholder="入住时间" value="<?php echo I('get.createtime');?>" />
        <button type="submit" class="btn btn-success radius" ><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
        <button type="button" onclick="user_export()" class="btn btn-success radius"><i class="Hui-iconfont">&#xe640;</i> 导出Excel</button>
        <button type="button" onclick="window.location.href='<?php echo U('aunt_list');?>'" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 清空</button>
    </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"> <a href="javascript:;" onclick="member_add('编辑用户','<?php echo U('user/user_edit');?>','','510')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加用户</a></span> <span class="r">共有数据：<strong><?php echo ($count); ?></strong> 条</span> </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <!--<thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="80">ID</th>
                <th width="100">用户名</th>
                <th width="40">性别</th>
                <th width="90">手机</th>
                <th width="150">邮箱</th>
                <th width="">地址</th>
                <th width="130">加入时间</th>
                <th width="70">状态</th>
                <th width="100">操作</th>
            </tr>
            </thead>-->
            <tbody>
            <!--<tr class="text-c">
                <td><input type="checkbox" value="1" name=""></td>
                <td>1</td>
                <td><u style="cursor:pointer" class="text-primary" onclick="member_show('张三','member-show.html','10001','360','400')">张三</u></td>
                <td>男</td>
                <td>13000000000</td>
                <td>admin@mail.com</td>
                <td class="text-l">北京市 海淀区</td>
                <td>2014-6-11 11:11:42</td>
                <td class="td-status"><span class="label label-success radius">已启用</span></td>
                <td class="td-manage"><a style="text-decoration:none" onClick="member_stop(this,'10001')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a> <a title="编辑" href="javascript:;" onclick="member_edit('编辑','member-add.html','4','','510')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="change_password('修改密码','change-password.html','10001','600','270')" href="javascript:;" title="修改密码"><i class="Hui-iconfont">&#xe63f;</i></a> <a title="删除" href="javascript:;" onclick="member_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
            </tr>-->
            <?php if(is_array($content)): $i = 0; $__LIST__ = $content;if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
                    <td colspan="2" rowspan="4" width="10%">
                        <img class="head_pic" onclick="parent.layer_show('查看图片','/Uploads/aunt_img/<?php echo ($vo["pic"]); ?>')" src="/Uploads/aunt_img/mini/<?php echo ($vo["pic"]); ?>"/>
                    </td>
                    <td class="user_lable">姓名</td>
                    <td><?php echo ($vo["name"]); ?></td>
                    <td class="user_lable">工号</td>
                    <td><?php echo ($vo["jobnumber"]); ?></td>
                    <td class="user_lable">籍贯</td>
                    <td><?php echo ($vo["city"]); ?></td>
                    <td class="user_lable" >年龄</td>
                    <td class="td-manage"><?php echo ($vo["age"]); ?></td>
                </tr>
                <tr class="text-c">


                    <td class="user_lable">工作区域</td>
                    <td><?php echo ($vo["workspace"]); ?></td>
                    <td class="user_lable">工作类型</td>
                    <td ><?php echo ($vo["wtype"]); ?></td>
                    <td class="user_lable">学历</td>
                    <td><?php echo ($vo["edu"]); ?></td>
                    <td class="user_lable">食宿</td>
                    <td ><?php echo ($vo["room"]); ?></td>
                </tr>
                <tr class="text-c">

                    <td class="user_lable">出生年月</td>
                    <td><?php echo ($vo["birth"]); ?></td>
                    <td class="user_lable">工作年限</td>
                    <td><?php echo ($vo["worktime"]); ?></td>
                    <td class="user_lable">资质证书</td>
                    <td><?php echo ($vo["certification"]); ?></td>
                    <td class="user_lable">服务过家庭</td>
                    <td ><?php echo ($vo["shome"]); ?> 个</td>
                </tr>

                <tr class="text-c">

                    <td class="user_lable" >工作状态</td>
                    <td><?php echo ($vo["workstate"]); ?></td>
                    <td class="user_lable">工作经历</td>
                    <td colspan="3" style="text-align: left;"> <?php echo ($vo["workhistory"]); ?></td>
                    <td><button type="button" onclick="window.open('<?php echo U('user/chk_user',array('id' => $vo['id']));?>')" class="btn btn-primary btn-xs">查看信息</button></td>
                    <td width="5%">
                        <button type="button" onclick="member_add('编辑信息','<?php echo U('user/user_edit',array('id' => $vo['id']));?>','','510')" class="btn btn-success btn-xs">编辑信息</button>
                    </td>
                </tr>

                <tr><td colspan="10" class="epy_nav"></td></tr><?php endforeach; endif; else: echo "暂时没有数据" ;endif; ?>
            </tbody>
        </table>
        <div class="row" style="margin-top:10px;width: 100%;">
            <div class="col-xs-6">
                <div class="dataTables_info" id="dynamic-table_info"
                     role="status" aria-live="polite"><?php echo ($page["header"]); ?></div>
            </div>
            <div class="col-xs-6">
                <div class="dataTables_paginate paging_simple_numbers"
                     id="dynamic-table_paginate">
                    <ul class="pagination">
                        <?php echo ($page["pagecontent"]); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/Public/aunt/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/Public/aunt/lib/layer/2.1/layer.js"></script>
<script type="text/javascript" src="/Public/aunt/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript" src="/Public/aunt/lib/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/Public/aunt/static/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="/Public/aunt/static/h-ui.admin/js/H-ui.admin.js"></script>
<script type="text/javascript">
    /*用户-添加*/
    function member_add(title,url,w,h){
        parent.layer_show(title,url,w,h);
    }

    /*用户信息导出*/
    function user_export(){
        window.location.href = "<?php echo U('user/aunt_info_export');?>" + "?" + $('#fm1').serialize();
    }
    /*用户-查看*/
    function open_img(title,url,w,h){
        layer.open({
            type: 1,
            shade: false,
            title: false, //不显示标题
            content: "<img src='"+url+"'/>", //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
        });
    }

</script>
</body>
</html>