<?php
 /**
 * pubs.php LA1Q:fc03fd96df76942f3f997ed09a8f73022180
 * Created by yichaxin.com V190612_0123551NJ
 * @author yujianyue<admin@ewuyi.net>
 * Date: 190612@5cffe3ac06977_12391.net 
 * 注意;著作权所有,不得公开发布和出售
 */
function webalert($Key){
$html="<script>\r\n";
$html.="alert('".$Key."');\r\n";
$html.="history.go(-1);\r\n";
$html.="</script>";
exit($html);
}
function characet($data){
if(!empty($data) ){
$fileType = mb_detect_encoding($data , array('UTF-8','GBK','LATIN1','BIG5')) ;
if( $fileType != 'UTF-8'){
$data = mb_convert_encoding($data ,'utf-8' , $fileType);
}
}
return $data;
}
function charaget($data){
if(!empty($data) ){
$fileType = mb_detect_encoding($data , array('UTF-8','GBK','LATIN1','BIG5')) ;
if( $fileType != 'GBK'){
$data = mb_convert_encoding($data ,'GBK' , $fileType);
}
}
return $data;
}
Function rephtmls($Keys){
$Keys = str_replace(array(" "), "&nbsp;", $Keys);
$Keys = str_replace(array("\""), "&quot;", $Keys);
$Keys = str_replace(array("<"), "&lt;", $Keys);
$Keys = str_replace(array(">"), "&gt;", $Keys);
$Keys = str_replace(array("\r\n", "\r", "\n"), "<br>", $Keys);
return $Keys;
}

 //pubs.php?t=190612@5cffe3ac06977&m=fc03fd96df76942f3f997ed09a8f7302 
?>