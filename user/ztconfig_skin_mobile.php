<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/ztconfig_skin_mobile.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $f_array[0]?></title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php
if (check_usergr_power("zt")=="no" && $usersf=='个人'){
echo $f_array[1];
exit;
}

if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
if($action=="modify"){
$skin=$_POST["skin"];

mysql_query("update zzcms_usersetting set skin_mobile='$skin' where username='".$username."'");			
echo $f_array[2];
}
?>
</head>
<body>
<div class="main">
<?php
include("top.php");
?>
<div class="pagebody">
<div class="left">
<?php
include("left.php");
?>
</div>
<div class="right">
<div class="admintitle"><?php echo $f_array[0]?></div>
<form name="myform" method="post" action="?action=modify"> 
<table width="95%" border="0" cellpadding="5" cellspacing="0">
                  <tr>        
                    <?php 
$rs=mysql_query("select skin_mobile from zzcms_usersetting where username='".$username."'");
$row=mysql_fetch_array($rs);					
$dir = opendir("../skin/mobile");
$i=0;
while(($file = readdir($dir))!=false){
  if ($file!="." && $file!=".." && strpos($file,".zip")==false && strpos($file,".rar")==false ) { //不读取. ..
    //$f = explode('.', $file);//用$f[0]可只取文件名不取后缀。 
?>
                    <td><table width="120" border="0" cellpadding="5" cellspacing="1">
                        <tr> 
                          <td align="center" <?php if($row["skin_mobile"]==$file){ echo "bgcolor='#025BAD'";}else{echo "bgcolor='#FFF'"; }?>>
						  <img src='../skin/mobile/<?php echo $file?>/image/mb.gif' width="120"  border='0'/></td>
                        </tr>
                        <tr> 
                          <td align="center" bgcolor="#FFFFFF"> <input name="skin" type="radio" id='<?php echo $file?>' value="<?php echo $file?>" <?php if($row["skin_mobile"]==$file){ echo"checked";}?>/> 
                            <label for='<?php echo $file?>'><?php echo $file?></label><br />
<input name="Submit" type="submit" class="buttons" value="<?php echo $f_array[3]?>" />
</td>
                        </tr>
                      </table></td>
                    <?php 
				  $i=$i+1;
				  if($i % 5==0 ){
				  echo"<tr>";
				  }
				}
				}	
closedir($dir)
				?>
           </table>  
</form>
</div>
</div>
</div>
</body>
</html>