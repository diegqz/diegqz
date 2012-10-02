<? 
include '../db.inc.php';
//数据库文件导入函数
function do_sql(){
global $host,$user,$password,$db;
@$conn=mysql_connect($host,$user,$password) or die("数据库链接失败！请检查你填写的数据库信息。");
@mysql_query("set names 'utf8'");
@$select=mysql_select_db($db,$conn);
if($conn and $select){
############执行数据库
$sql_txt=file_get_contents("qq.sql");
$explode = explode(";",$sql_txt);
$cnt = count($explode);
//循环导入数据库文件
for($i=0;$i<$cnt ;$i++){
    $sql = $explode[$i];
    $result = mysql_query($sql);}
if($result){
        echo "数据库初始化成功，共".$i."个查询<br>";
}else{
        echo "数据库初始化失败，请手动导入".mysql_error();
    }
}else{echo "数据库连接失败！<br />";}
}	
?>
<!DOCTYPE html PUBLIC"-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/favicon.ico" rel="icon" type="image/x-icon" />
<link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link href="/favicon.ico" rel="bookmark"> 
<title>Install--iZzx开放平台 Power by IZZX</title>
<link rel="stylesheet" type="text/css" href="../common.css">
</head>
<body>
<?  
@$type=$_GET['type'];
//判断标记文件是否存在，存在就退出，防止重复运行
if(file_exists("../install/install.lock")){?>
<div id="main-nav-host"> 重新安装失败</div>
如果你是网站管理员，请手动删除install文件夹下的install.lock文件。如果你不是网站管理员，请自觉离开！
			<? exit; } 
if(!isset($_GET['agree']) or $_GET['agree']==""){
	 $agree="";
	 }else{
		 $agree=$_GET['agree'];}
if($agree=="yes"){
	if($type=="1"){?>
	<div class="module">
       <div class="module-content">
            <div id="main-nav-host"> 配置数据库</div>       
                <form id="form2" name="form2" method="post" action="index.php?agree=yes&type=2">
                数据库地址:
                <br />
                <input name="host" type="text" id="host" value="localhost" size="15" maxlength="30" />
                <br />
                数据库用户名:<br />
                <input name="user" type="text" id="user" size="15" />
                <br />
                数据库登录密码:<br />
                <input name="pass" type="password" id="pass" size="15" />
                <br />
                数据库名字:<br />
                <input name="db" type="text" id="db" size="15" />
                <br />
                数据表前缀(这个不要改，不然安装后无法正常):<br />
                <input name="table" type="text" id="table" value="qq_" size="15" />
                <br />
                腾讯微博账号:<br />
                <input name="weibo" type="text" id="table" value="a469567135" size="15" />
                <br />
                公告（顶部）:<br />
                <input name="msg" type="text" id="table" value="欢迎来到心挂Q！" size="15" />
                <br />
                帮助（底部）:<br />
                <input name="gqfaq" type="text" id="table" value="iZzx&无心问世版权所有" size="15" />
                <br />
                Pctowap App_id(<a href='http://open.pctowap.com/pop_developer_login.html'>申请一个</a>):<br />
                <input name="pcwapid" type="text" id="table" value="" size="15" />
                <br />
                管理员帐号:<br />
                <input name="spuser" type="text" id="table" value="admin" size="15" />
                <br />
                管理员密码:<br />
                <input name="sppass" type="text" id="table" value="" size="15" />
                <br />
                <input type="submit" class="btn-s" name="button" id="button" value="下一步" />
                </form>
              </div>
        </div>
		<? }
   if ($type=="2"){
	   	@$conn=mysql_connect($_POST['host'],$_POST['user'],$_POST['pass']);
        @mysql_query("set names 'utf8'");
        @$select=mysql_select_db($_POST['db'],$conn);
        if($conn and $select){
	    @    $txt="
<?
//本文件可以通过安装的时候生成！

static \$_config=array();

\$host=\"$_POST[host]\"; //数据库的IP
\$db=\"$_POST[db]\"; //数据库名字
\$user=\"$_POST[user]\"; //数据库的用户名
\$password=\"$_POST[pass]\"; //数据库的密码
\$table=\"$_POST[table]\"; //数据表前缀
\$weibo=\"$_POST[weibo]\"; //腾讯微博账号
\$msg=\"$_POST[msg]\"; //公告（顶部）
\$gqfaq=\"$_POST[gqfaq]\"; //帮助（底部）
\$pcwapid=\"$_POST[pcwapid]\"; 
/*Pctowap App_id  到http://open.pctowap.com/pop_developer_login.html申请一个账号并登陆。
点击\"申请应用\"来获得一个默认调用代码，将代码中的&app_id=***中的***写入即可。

例：

默认调用代码:
<script src='http://open.pctowap.com/dowap/popcall.php?u=123.pctowap.com/wap&app_id=114' ></script>        144即为App_id.  */


\$spuser=\"$_POST[spuser]\"; //管理员帐号
\$sppass=\"$_POST[sppass]\"; //管理员密码
\$ad1=\"\"; //广告位1 Cpc类型广告
\$ad2=\"\"; //广告位2 Cpv、Cpm类型广告
?>
";
        $fp=fopen("../db.inc.php","w");
        flock($fp,LOCK_EX);
        $write=fputs($fp,$txt);
        flock($fp,LOCK_UN);
        fclose($fp);
        if($write){
	         echo '配置文件成功';
			 echo "</br><div class='btn-s'><a href='index.php?agree=yes&type=3'>下一步</a></div>";
	    }else{
		     echo "保存配置失败！请开启目录0777权限。无法进一步安装<br />";
		}
	}else{
		echo "链接数据库失败！无法进一步安装<br />";
		}
	   }
   if ($type=="3"){
	   do_sql();?>
       <div class="module">
       <div class="module-content">
            <div id="main-nav-host"> 配置网站信息</div>       
                <form id="form2" name="form2" method="post" action="index.php?agree=yes&type=4">
                网站名称:
                <br />
                <input name="webname" type="text" id="webname" value="心挂Q,云在线!" size="15" maxlength="30" />
                <input type="submit" class="btn-s" name="button" id="button" value="完成" />
                </form>
              </div>
        </div>
       
   
   <? }if ($type=="4"){
	   $txt2='<? $webname="'.$_POST['webname'].'"; ?>';
	   $fp=fopen("../db.inc.php","a++");
       flock($fp,LOCK_EX);
       $write=fputs($fp,$txt2);
       flock($fp,LOCK_UN);
       fclose($fp);
       if($write){
	         $fp2=fopen("../install/install.lock","w");
             flock($fp2,LOCK_EX);
             $write2=fputs($fp2,"安装成功！");
             flock($fp2,LOCK_UN);
             fclose($fp2);?>
             <div class="module">
                <div class="module-content">
                    <div id="main-nav-host"> 网站安装成功</div>       
                    <b>感谢您使用本程序</b></br>
                    <b><a href='http://www.izzx.cc'>iZzx科技开放平台欢迎您！</a></b></br>
                    <a href='../index.php'>&gt;进入首页<br />
                    <a href='../admin.php'>&gt;进入管理中心<br />
                    </a> <a href='../reg.php'>&gt;马上注册</a>
              </div>
        </div>
			 
	    
		<? }else{
		     echo "保存配置失败！请开启目录0777权限。无法进一步安装<br />";
		}?>
       

       
       <? }} ?>


<? if(!isset($_GET['type']) or $_GET['type']==""){?>
<div id="main-nav-host"> iZzx应用安装协议</div>
<div class="module">
  <div class="module-content">
    <div class="padding-5-0 border-btm">
        1.不得随意修改版权。。</br>
        2.本程序为免费开源，未在官方允许需下，任何人不得将本程序置于商业活动中。<br />
        3.程序代码，可供学习，但如果要引用其中的代码，必须保留代码顶端的版权。<br /> 
        4.凡安装IZZX挂Q，默认同意本协议！<br />
<a href='index.php?agree=yes&type=1'>&gt;我同意本协议<br />
</a> <a href='index.php?agree=no&type=0'>&gt;我不同意本协议</a>
</div>
        </div>
  </div>
</div><? } ?>
<? if($agree=="no"){?>
<div id="main-nav-host">感谢使用本程序</div>
<a href='http://www.izzx.cc'>iZzx科技开放平台欢迎您！</a>
<? } ?>
</body>
</html>