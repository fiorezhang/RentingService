<?php
 /**
 * safe.php LA1Q:d1035cc0bbfe3ca6becc94530d15f2592180
 * Created by yichaxin.com V190612_0123551NJ
 * @author yujianyue<admin@ewuyi.net>
 * Date: 190612@5cffe3ac06977_12391.net 
 * ע��;����Ȩ����,���ù��������ͳ���
 */
//�����������mysql��ע��Ȱ�ȫ����
//��˵mysqli�Ѿ��Դ���������֪�����
// ��⣬����ɾ����ҳ��ȫ���˴��룬����������
/*
�������Դ�룬����ٶ�:
7384���й�������ѯϵͳԴ��
7384ѧ���ɼ���ѯϵͳ
asp+excel����;��ѯϵͳ
asp+excelͼ�����߼���ϵͳ
asp+excelͼ�����߼���ϵͳ�ֻ���
asp+txt ͨ�ò�ѯϵͳ�ֻ���
asp+txt ͨ�ù��ʲ�ѯϵͳ
asp+txt ά�޵��ݽ��Ȳ�ѯϵͳ
asp+txtͨ�óɼ���ѯϵͳ
aspͨ������ʽֵ���ѯϵͳ
PHP+Csv(Excel)ͨ�óɼ���ѯϵͳ
PHP+Csv(Excel)ͨ�óɼ���ѯϵͳ�ֻ���
PHP+excel����;��ѯϵͳ
PHP+excelͨ�óɼ���ѯϵͳ
PHP+excelͨ�óɼ���ѯϵͳ
php+excelͨ�ÿα��ѯϵͳ
php+Txt �ɼ���ѯϵͳͨ�ð�
php+Txt����;��ѯϵͳ
����������ѯϵͳС͵
asp���֤������ѯ����ϵͳ
asp��վ�ٶ�������ѯϵͳ
php+access ͨ�ÿ��Բ��ϵͳ
php+sqlite ͨ�óɼ���ѯϵͳ
*/
//get���ع���
$getfilter = "\\<.+javascript:window\\[.{1}\\\\x|<.*=(&#\\d+?;?)+?>|<.*(data|src)=data:text\\/html.*>|\\b(alert\\(|confirm\\(|expression\\(|prompt\\(|benchmark\s*?\(.*\)|sleep\s*?\(.*\)|load_file\s*?\\()|<[a-z]+?\\b[^>]*?\\bon([a-z]{4,})\s*?=|^\\+\\/v(8|9)|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)@{0,2}(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\"))FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
/**
*  �������
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
*  ������ʾҳ
*/
function webscan_pape(){
$pape='<style type="text/css">h1,p{text-align:center;}';
$pape.='h1{line-height:150%;font-size:38px;color:red;}';
$pape.='p{line-height:120%;font-size:18px;color:blue;}</style>';
$pape.="<h1>��ӭ���٣���������</h1>";
$pape.="<p>�������ݴ���Σ���ַ�����Ĳ���������</p>";
echo $pape;
exit();
}
/**
*  �����������
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