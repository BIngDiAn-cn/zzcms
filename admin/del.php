<?php 
//set_time_limit(1800);
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css"> 
<title></title>
</head>
<body>
<?php
checkadminisdo("siteconfig");
$pagename=trim($_POST["pagename"]);
$tablename=trim($_POST["tablename"]);
$id="";
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $id=$id.($_POST['id'][$i].',');
    }
	$id=substr($id,0,strlen($id)-1);//去除最后面的","
}

if ($id==""){
echo "<script>alert('操作失败！至少要选中一条信息。');history.back(-1)</script>";
mysql_close($conn);
}

switch ($tablename){
case "zzcms_main";
if (strpos($id,",")>0){
$sql="select img,img2,img3,flv,id from zzcms_main where id in (". $id .")";
}else{
$sql="select img,img2,img3,flv,id from zzcms_main where id='$id'";
}
$rs=mysql_query($sql);
while($row=mysql_fetch_array($rs)){
		if ($row["img"]<>"/image/nopic.gif") {
		$f="../".substr($row["img"],1);//前面必须加../否则完法删
		$fs="../".substr(str_replace(".","_small.",$row["img"]),1);
			if (file_exists($f)){
			unlink($f);
			unlink($fs);		
			}
		}
		if ($row["img2"]<>"/image/nopic.gif") {
		$f="../".substr($row["img2"],1);
		$fs="../".substr(str_replace(".","_small.",$row["img2"]),1);
			if (file_exists($f)){
			unlink($f);
			unlink($fs);		
			}
		}
		if ($row["img3"]<>"/image/nopic.gif") {
		$f="../".substr($row["img3"],1);
		$fs="../".substr(str_replace(".","_small.",$row["img3"]),1);
			if (file_exists($f)){
			unlink($f);
			unlink($fs);		
			}
		}
		if ($row['flv']<>''){//flv里没有设默认值
			$f="../".substr($row['flv'],1);
			if (file_exists($f)){
			unlink($f);
			}
		}
		mysql_query("delete from zzcms_main where id=".$row['id']."");
		mysql_query("update zzcms_dl set cpid=0 where cpid=".$row["id"]."");//把代理信息中的ID设为0
}
mysql_close($conn);
echo "<script>location.href='".$pagename."'</script>"; 
break;

case "zzcms_licence";
if (strpos($id,",")>0){
$sql="select * from zzcms_licence where id in (". $id .")";
}else{
$sql="select * from zzcms_licence where id='$id'";
}
$rs=mysql_query($sql);
while($row=mysql_fetch_array($rs)){
		if ($row["img"]<>"/image/nopic.gif") {
		$f="../".substr($row["img"],1)."";
		$fs="../".substr(str_replace(".","_small.",$row["img"]),1)."";
			if (file_exists($f)){
			unlink($f);
			unlink($fs);		
			}
		}
		mysql_query("delete from zzcms_licence where id=".$row['id']."");
}
mysql_close($conn);
echo "<script>location.href='".$pagename."'</script>"; 
break;

case "zzcms_ad";
if (strpos($id,",")>0){
$sql="select * from zzcms_ad where id in (". $id .")";
}else{
$sql="select * from zzcms_ad where id='$id'";
}
$rs=mysql_query($sql);
while($row=mysql_fetch_array($rs)){
		if ($row["img"]<>"") {
		$f="../".substr($row["img"],1)."";
		$fs="../".substr(str_replace(".","_small.",$row["img"]),1)."";
			if (file_exists($f)){
			unlink($f);
			unlink($fs);		
			}
		}
		mysql_query("delete from zzcms_ad where id='".$row['id']."'");
}
mysql_close($conn);
echo "<script>location.href='".$pagename."'</script>"; 
break;

case "zzcms_dl";
for($i=0; $i<count($_POST['id']);$i++){
    $ids=$_POST['id'][$i];
	$ids=explode("|",$ids);
	$id=$ids[0];
	$classzm=$ids[1];
	mysql_query("delete from zzcms_dl where id ='$id'");
	mysql_query("delete from zzcms_dl_".$classzm." where dlid ='$id'");
}
echo "<script>location.href='".$pagename."'</script>"; 
break;

default;
if (strpos($id,",")>0){
$sql="delete from ".$tablename." where id in (". $id .")";
}else{
$sql="delete from ".$tablename." where id='$id'";
}
mysql_query($sql);
mysql_close($conn);
echo "<script>location.href=\"$pagename\"</script>"; 
}
?>
<a href="<?php echo $pagename?>">返回</a>
</body>
</html>