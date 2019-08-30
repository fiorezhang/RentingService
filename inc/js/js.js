var $=function(node){
return document.getElementById(node);
}
function $(objId){
return document.getElementById(objId);
}
document.onkeydown = function(e){
if(!e) e = window.event;
if((e.keyCode || e.which) == 13){
document.getElementById("sub").click();
}
}
function inst() {
if ($("name")!=null) $("name").value = $("tishi1").innerHTML;
if ($("code")!=null) $("code").value = $("tishi4").innerHTML;
}
function preview()
{
bdhtml=window.document.body.innerHTML;
sprnstr="<!--startprint-->";
eprnstr="<!--endprint-->";
prnhtml=bdhtml.substr(bdhtml.indexOf(sprnstr)+17);
prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));
window.document.body.innerHTML=prnhtml;
window.print();
}
function download(filename)
{
var src = filename; //可以不一样，那就要传参
if (src == null || src == '')
    return;
var link = document.createElement('a');
//设置下载的文件名
link.download = filename;
//link.style.display = 'none';
//设置下载路径
link.href = src;
//触发点击
document.body.appendChild(link);
link.click();
//移除节点
document.body.removeChild(link);
}
function st(ids,Num){
if ($(ids).value == $("tishi"+Num).innerHTML){
$(ids).value = "";
}
}
function Check1NJ(Num) {
if(Num == 2 || Num == 0){
if($("name").value == "" || $("name").value == $("tishi1").innerHTML){
$("name").value = $("tishi1").innerHTML;
$('11').style.borderColor='red';
return false;
}else{
$('11').style.borderColor='green';
}
}
if(Num == 3 || Num == 0){
if ($("code")!=null){
if (!$("code").value.match(/^[0-9]{4}$/)){
$("code").value = $("tishi4").innerHTML;
$('33').style.borderColor='red';
return false;
}else{
$('33').style.borderColor='green';
}
}
}
if(Num == "0"){
}
}
