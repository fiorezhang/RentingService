<?php
 /**
 * safe.php LA1Q:d1035cc0bbfe3ca6becc94530d15f2592180
 * Created by yichaxin.com V190612_0123551NJ
 * @author yujianyue<admin@ewuyi.net>
 * Date: 190612@5cffe3ac06977_12391.net 
 * 注意;著作权所有,不得公开发布和出售
 */
//这里可以增加mysql防注入等安全代码
//传说mysqli已经自带防护，不知道真假
// 糟糕，忘记删除本页安全过滤代码，便宜你们了
/*
更多免费源码，详情百度:
7384城市公交网查询系统源码
7384学生成绩查询系统
asp+excel多用途查询系统
asp+excel图书在线检索系统
asp+excel图书在线检索系统手机版
asp+txt 通用查询系统手机版
asp+txt 通用工资查询系统
asp+txt 维修点快递进度查询系统
asp+txt通用成绩查询系统
asp通用日历式值班查询系统
PHP+Csv(Excel)通用成绩查询系统
PHP+Csv(Excel)通用成绩查询系统手机版
PHP+excel多用途查询系统
PHP+excel通用成绩查询系统
PHP+excel通用成绩查询系统
php+excel通用课表查询系统
php+Txt 成绩查询系统通用版
php+Txt多用途查询系统
无名公交查询系统小偷
asp身份证批量查询与解读系统
asp网站速度批量查询系统
php+access 通用考试查分系统
php+sqlite 通用成绩查询系统
*/
//get拦截规则
$getfilter = "\\<.+javascript:window\\[.{1}\\\\x|<.*=(&#\\d+?;?)+?>|<.*(data|src)=data:text\\/html.*>|\\b(alert\\(|confirm\\(|expression\\(|prompt\\(|benchmark\s*?\(.*\)|sleep\s*?\(.*\)|load_file\s*?\\()|<[a-z]+?\\b[^>]*?\\bon([a-z]{4,})\s*?=|^\\+\\/v(8|9)|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)@{0,2}(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\"))FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
/**
*  参数拆分
*/
function webscan_arr_foreach($arr) {
static $str;
if (!is_array($arr)) {
return $arr;
}
foreach ($arr as $key => $val ) {
if (is_array($val)) {
webscan_arr_foreach($val);
} else {
$str[] = $val;
}
}
return implode($str);
}
/**
*  防护提示页
*/
function webscan_pape(){
$pape='<style type="text/css">h1,p{text-align:center;}';
$pape.='h1{line-height:150%;font-size:38px;color:red;}';
$pape.='p{line-height:120%;font-size:18px;color:blue;}</style>';
$pape.="<h1>欢迎光临，手下留情</h1>";
$pape.="<p>输入内容存在危险字符，你的操作被拦截</p>";
echo $pape;
exit();
}
/**
*  攻击检查拦截
*/
function webscan_StopAttack($StrFiltKey,$StrFiltValue,$ArrFiltReq,$method) {
$StrFiltValue=webscan_arr_foreach($StrFiltValue);
if (preg_match("/".$ArrFiltReq."/is",$StrFiltValue)==1){
webscan_pape();
}
if (preg_match("/".$ArrFiltReq."/is",$StrFiltKey)==1){
webscan_pape();
}
}
if ($webscan_get) {
foreach($_GET as $key=>$value) {
webscan_StopAttack($key,$value,$getfilter,"GET");
}
}

 //safe.php?t=190612@5cffe3ac06977&m=d1035cc0bbfe3ca6becc94530d15f259 
?>