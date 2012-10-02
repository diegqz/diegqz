<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title><?php include('./db.inc.php'); echo $webname;?></title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link rel="icon" type="image/ico" href="favicon.ico" />
<?php
set_time_limit(0);
$conn = @mysql_connect("$host","$user","$password");
        if (!$conn){
            die("连接数据库失败：" . mysql_error());}
        mysql_select_db($db, $conn);
        $sql =  mysql_query("SELECT COUNT(id) FROM {$table}online");
        $result=mysql_query("SELECT * FROM {$table}online");
		while($row = mysql_fetch_array($result)){
            $url = "http://pt.3g.qq.com/s?aid=nLogin3gqqbysid&3gqqsid=".$row['url'];
            $contents = file_get_contents($url);
       if(!$contents){echo '处理失败';}
	   else{echo '处理成功';}
	   }
?>