<?php include "inc/safe.php";?><?php include "inc/conn.php";?><?php include "inc/pubs.php";?>
<!doctype html><?php $tts = date("YmdHis",time());?><?php include "inc/sqls.php";?>
<html lang="zh-CN">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<title><?php echo $title;?></title>
<meta name="by-forflash" content="886abe98cf5a188f818dfccedba9c5b2" />
<meta property="ai:yaha" content="931b22bdcc0585dd374123b31027a340" />
<link href="inc/css/style.css<?php echo $jscss; ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="inc/js/js.js<?php echo $jscss; ?>"></script>
</head>
<body onLoad="inst();">
<div class="html">
<div class="divs" id="divs">
<div id="head" class="head" onclick="location.href='?t=<?php echo $tts;?>';">
<?php echo $title;?>
</div>
<div class="main" id="main">
<?php
$stime=microtime(true);
$codes = trim($_GET['code']);
$shuru1 = trim($_GET['name']);

if(!$shuru1){
?>
  <form name="qu" method="GET" action="?t=<?php echo $tts;?>" onsubmit="return Check1NJ(0);">
  <div class="so_box" id="11">
  <input name="name" type="text" class="txts" id="name" value="" placeholder="请输入<?php echo $tiaojian1cn;?>" onfocus="st('name',1)" onBlur="Check1NJ(2)" />
  </div>
<?php
if($ismas=="1"){
?>
  <div class="so_box" id="33">
  <input name="code" type="text" class="txts" id="code" placeholder="请输入验证码" onfocus="this.value=''" onBlur="Check1NJ(3)" />
  <div class="more" id="clearkey">
  <img src="inc/code.php?t=<?php echo $tts;?>" id="Codes" onClick="this.src='inc/code.php?t='+new Date();" />
  </div></div>
<?php }?>
<div class="so_but">
<input type="submit" name="button" class="buts" id="sub" value="立即查询" />
<input type="button" class="buts" value="刷新本页" name="print" onclick="location.reload();">
</div>
<div class="so_bus" id="tishi">
说明:【输入<?php echo $tiaojian1cn;?>
<?php if($ismas=="1"){?>+验证码<?php }?>】查询。<br>
  <!---你的其他说明在这里添加：开始-->
  请按格式输入，例如：2000-01，或2000-01-01<br>
  显示检索数据，提供分页下载
  <!--你的其他说明在这里添加：结束-->
  </div>
  <div id="tishi1" style="display:none;">请输入<?php echo $tiaojian1cn;?></div>
  <div id="tishi4" style="display:none;">请输入4数字验证码</div>
  </form>
<?php
}else{
  if($ismas=="1"){
    session_start();
  if($codes!=$_SESSION['Code1NJ']){
    webalert("请正确输入验证码！");
  }
}
//这里自行增加接受参数的过滤。
if(!$shuru1){
  webalert("请输入$tiaojian1cn!");
}
$pagesize = "1000"; //单页显示的数据条数，也是分割包的大小
$page = trim($_GET["page"]);
$paix = trim($_GET["a"]);
$ascx = trim($_GET["d"]);

if(strlen($shuru1)>1){ //1:输入得两字以上
  $sqs = "WHERE `{$tiaojian1}` LIKE '{$shuru1}%' ORDER BY `{$tiaojian1}`"; //模糊搜索
  //$sqs = "WHERE `{$tiaojian1}` = '{$shuru1}'"; //等于关系
}else{
  webalert("请输入$tiaojian1cn!");
}
if(strlen($paix)>0 && strlen($ascx)>0){
  $pais = " ORDER BY `{$paix}` {$ascx}";
}else{
  $pais = " ";
}

$db=ConnectMysqli::getIntance($conn);
$sql="SELECT COUNT(*)  FROM `{$biaoge}` " . $sqs;
$list=$db->getRow($sql);
$recs=$list['COUNT(*)'];//查询到的总条数
//Echo "<h3>计数</h3>$sql ： $recs<br>";

if (0){ //批量查询太慢，暂时关掉功能，移除相关按键
$sql="SELECT * FROM `{$biaoge}` $sqs";
$list=$db->getAll($sql);
//Echo "<h3>生成全部</h3>$sql<br>";
if (count($list)>0){
  $jsonstringall =  json_encode($list, JSON_UNESCAPED_UNICODE);
  $jsonfileall = $jsonpath.$shuru1.'.json';
  file_put_contents($jsonfileall, $jsonstringall);
//  if(file_exists($jsonfileall)){
//    Echo "生成成功<br>";
//  }else{
//    echo "生成失败<br>";
//  }
}
}

//$pagecount = bcdiv($recs+$pagesize-1,$pagesize,0); //算出总页数
$pagecount = floor(($recs+$pagesize-1)/$pagesize);
//Echo "pagecount: ".$pagecount."<br>";
$urls = "&name={$shuru1}";
if(strlen($paix)>0){ $urls .= '&a='.$paix;}
if(strlen($ascx)>0){ $urls .= '&d='.$ascx;}
if(strlen($keys)>0){ $urls .= '&keys='.$keys;}
if(!isset($page)) $page = 1; //如果没有指定显示页码，缺省为显示第一页
if(!is_numeric($page)) $page = 1;
if($page<1) $page = 1; //如果页码比1小，则显示第一页
if($page>$pagecount) $page = $pagecount; //如果页码比总页数大，则显示最后一页
$p = $page * $pagesize + 1 - $pagesize -1;
if($p<0) $p = 0; //如果
$sql="SELECT * FROM `{$biaoge}` $sqs limit $p, $pagesize";
$list=$db->getAll($sql);
if (count($list)>0){
  $jsonstringthis =  json_encode($list, JSON_UNESCAPED_UNICODE);
  $jsonfilethis = $jsonpath.$shuru1.'_'.$p.'_'.$pagesize.'.json';
  file_put_contents($jsonfilethis, $jsonstringthis);
}
//Echo "<h3>查询</h3>$sql<br>";

echo "<h1>&nbsp;</h1>\r\n";
?>
<div class="so_but">
<input type="button" class="buts" value="下载当前页面" name="single" onclick="download(<?php echo "'".$jsonfilethis."'"; ?>)">
<!-- input type="button" class="buts" value="下载全部页面" name="download" onclick="download(<?php echo "'".$jsonfileall."'"; ?>)"-->
<input type="button" class="buts" value="返回搜索页面" id="reset" onclick="location.href='?t=back';"></div>
<?php
echo "<div style=\"margin:0 auto;overflow-x:auto;width:98%;max-width:1188px;\">";
echo "\r\n<!--startprint-->\r\n<h1>查询结果</h1>\r\n";

if($recs<1){
  echo "<tr>\r\n";
  echo "<td data-label=\"查询提示：\" colspan=\"{$li}\">没有查询到相关信息哦</td>\r\n";
  echo "</tr>\r\n";
  echo "</tbody>\r\n";
}else{
  echo "</tbody>\r\n";
  if($pagecount>1){ //页码比0大，表示有数据
    echo "<tr><td colspan=\"{$li}\">";
    if($page>1){
      echo '<a href="?page=1' . $urls . '">首页</a> ';
      echo '<a href="?page='. ($page-1) . '' . $urls . '">前页</a> ';
    }
    if($page<$pagecount){
      echo '<a href="?page='. ($page+1) . '' . $urls . '">后页</a> ';
      echo '<a href="?page=' . $pagecount . '' . $urls . '">尾页</a> ';
    }
    echo '页次: <span>' . $page . '</span>/<span>' . $pagecount . '</span>页 ';
    echo '<span>' . $pagesize . '</span>条/页 ';
    echo '共<span>' . $recs . '</span>条 </td><tr>';
  }
}

echo "<table cellspacing=\"0\" class=\"table\"> \r\n";
$ii=0;
foreach ($list as $lina ) {
  $ii++;
  if($ii=="1"){
    echo "\r\n<thead>\r\n<tr class=\"tt\">\r\n";
    $li=0;
    //echo "<td><nobr>ID</nobr></td>\r\n";
    foreach ($lina as $keya => $vale ) {
      $li++; //支持搜索功能，隐藏指定列、网址调用等的定制
      echo "<td><nobr>$keya</nobr></td>\r\n";
    }
    echo "</tr>\r\n</thead>\r\n";
    echo "\r\n<tbody>\r\n";
  }
  echo "\r\n<tr>\r\n";
  //echo "<td><nobr>$ii</nobr></td>\r\n";
  foreach ($lina as $keya => $vale ) {
    if(strlen(Trim($vale))<1){$vale = "-";} //空值情况
    echo "<td data-label=\"{$keya}：\">$vale</td>\r\n";
  }
  echo "</tr>\r\n";
}
echo "</table>\r\n";
echo "\r\n<!--endprint-->\r\n</div>\r\n";
}
$etime=microtime(true);
$total=$etime-$stime;
echo "<!----页面执行时间：{$total} ]秒--->";
?>
</div>
<div class="boto" id="boto">
&copy;<?php echo date('Y');?>&nbsp;
<a href="<?php echo $copyu;?>" target="_blank"><?php echo $copyr;?></a>
</div>
</div>
</div>
</body>
</html>
