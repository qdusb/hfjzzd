<?php
//¼ì²âÓÃ»§
@session_start();
if($_SESSION['realname']=="" || $_SESSION['username']=="" || $_SESSION['is_admin']==""){
	@session_destroy();
	echo "<script>window.top.location.href='login.php'</script>";
	exit();
}
?>
