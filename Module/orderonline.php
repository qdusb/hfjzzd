<?php
if(!defined('IN_EKMENG')) {
	exit('Access Denied');
}
	
	$big_id=3;
	$id=(int)$_GET['id'];
	if($id>0 && $big_id>0){
		$sql="select title from info where big_id=$big_id and id=$id";
		if($arr=$db->fetch_array($db->query($sql))){
			$title=$arr['title'];
		}
	}
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$prod_name=$_POST['prod_name'];
		$prod_num=$_POST['prod_num'];
		$tel=$_POST['tel'];
		$puser=$_POST['puser'];
		$content=$_POST['content'];
		if($prod_name=="" || $prod_num<1){
			echo "<script>alert('�����빺��Ĳ�Ʒ����������');location.href='default.php';</script>";
			exit();
		}
		if($tel=="" || $puser==""){
			echo "<script>alert('��������ϵ�绰����ϵ������');hlocation.href='default.php';</script>";
			exit();
		}
		
		//$sql="select id from info where (big_id=2 or bigid=3) and title='".trim($prod_name)."'";
		//echo $sql;
		//die();
		
		//$db->fetch_array($db->query($sql));
			//$id=$arr['id'];
			$time=time();
			$sql="insert into `order`(prod_name,shop_num,tel,puser,content,create_time) values('$prod_name',$prod_num,'$tel','$puser','$content',$time)";
		
			if($db->query($sql)){
				$db->close();
				echo "<script>alert('�µ��ɹ�,���ǻ�������ʱ���ں�����ϵ,лл!');location.href='default.php';</script>";
				exit();
				}else{
				echo "<script>alert('�µ�ʧ��,����û����Ҫ�Ĳ�Ʒ,лл!');location.href='default.php';</script>";
				exit();
			}
		
	}
?>
<form name="form1" method="post" action="">
  <table width="80%" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
      <td width="30%" align="center">��Ʒ����:</td>
      <td><input name="prod_name" type="text" id="prod_name" value="<?php echo $title?>" size="40"></td>
    </tr>
    <tr>
      <td align="center">��������:</td>
      <td><input name="prod_num" type="text" id="prod_num" size="10" maxlength="4" value="1"></td>
    </tr>
    <tr>
      <td align="center">��ϵ�绰:</td>
      <td><input name="tel" type="text" id="tel" size="40"></td>
    </tr>
    <tr>
      <td align="center">�� ϵ ��:</td>
      <td><input name="puser" type="text" id="puser" size="40"></td>
    </tr>
    <tr>
      <td align="center">˵������:</td>
      <td><textarea name="content" cols="50" rows="8" id="content"></textarea></td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td><input type="submit" name="Submit" value="��Ҫ����"> <input type="button" name="Submit2" value="ȡ������" onClick="history.back();"></td>
    </tr>
  </table>
</form>
