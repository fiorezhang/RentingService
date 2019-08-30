<?php
//error_reporting(0); //如果容错删除行首双斜杠
header("content-Type: text/html; charset=utf-8");//输出编码
$title="数塔科技 - 租赁数据查询系统";	//设置查询标题,相信你懂的。
$copyr="数塔科技";		//设置底部版权文字,相信你懂的。
$copyu="/";			//设置底部版权连接,相信你懂的。
$biaoge="full";		//设置mysql表名称。
$tiaojian1="sVisitDate";		//查询条件1列标题，跟excel列头一致，注意无空格回车;
$tiaojian1cn="日期";		//查询条件1列标题，跟excel列头一致，注意无空格回车;
$ismas="0";			//设置是否使用验证码，1是0否。多页查询有bug，先关闭
$jsonpath = 'json/';
$jscss = "?v=20190830";		//每次修改js，css文件后修改这个参数。

 //conn.php?t=190612@5cffe3ac02c6e&m=8036b980e7fa26cc16fbc6e7056e3970 
?>
