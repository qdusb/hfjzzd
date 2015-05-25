<?php
if(!defined('IN_EKMENG')) {
	exit('Access Denied');
}
Class dbconn{
	var $link,$querynum;
	var $rs_recrod;
	var $db_record;
	var $fetch_mode = MYSQL_ASSOC;

	Function connect($dbname,$dbuser,$dbpwd,$dbhost){
		if($pconnect) {
			if(!$this->link = @mysql_pconnect($dbhost, $dbuser, $dbpwd)) {
				$this->halt('Can not connect to MySQL server');
			}
		} else {
			if(!$this->link = @mysql_connect($dbhost, $dbuser, $dbpwd)) {
				$this->halt('Can not connect to MySQL server');
			}
		}
		
		if($this->version() > '4.1') {
			global $charset, $dbcharset;
			if(!$dbcharset && in_array(strtolower($charset), array('gbk', 'big5', 'utf-8'))) {
				$dbcharset = str_replace('-', '', $charset);
			}

			if($dbcharset) {
				mysql_query("SET character_set_connection=$dbcharset, character_set_results=$dbcharset, character_set_client=binary", $this->link);
			}

			if($this->version() > '5.0.1') {
				mysql_query("SET sql_mode=''", $this->link);
			}
		}

		if($dbname) {
			mysql_select_db($dbname, $this->link);
		}	

	}

	Function select_db($dbname) {
		return mysql_select_db($dbname, $this->link);
	} 

	Function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}

	Function query($sql, $type = '') {
		$func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ?
			'mysql_unbuffered_query' : 'mysql_query';
		$this->db_result = null;
		if(!($this->db_result  = $func($sql, $this->link)) && $type != 'SILENT') {
			$this->halt('MySQL Query Error', $sql);
		}

		$this->querynum++;
		return $this->db_result;
	}

	function affected_rows() {
		return mysql_affected_rows($this->link);
	}

	function error() {
		return (($this->link) ? mysql_error($this->link) : mysql_error());
	}

	function errno() {
		return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());
	}

	function result($query, $row) {
		$query = @mysql_result($query, $row);
		return $query;
	}

	function num_rows($query) {
		$query = mysql_num_rows($query);
		return $query;
	}

	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function free_result($query) {
		return mysql_free_result($query);
	}

	function insert_id() {
		return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}

	function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}

	function fetch_fields($query) {
		return mysql_fetch_field($query);
	}

	function version() {
		return mysql_get_server_info($this->link);
	}

	function getMax($table,$field,$where=""){
		$sql="select max($field) as id from $table";
		if($where!=""){
			$sql.=" where $where";
		}
		$query=$this->query($sql);
		$arr=$this->fetch_array($query);		
		if($arr){			
			$maxid=$arr['id'];
		}else{
			$maxid=0;
		}
		return $maxid;

	}

	function getCount($table,$field,$where=""){
		$sql="select count($field) as id from $table";
		if($where!=""){
			$sql.=" where $where";
		}
		$query=$this->query($sql);
		$arr=$this->fetch_array($query);		
		return $arr['id'];
	}

	Function GetField($table,$field,$where=""){
		$sql="select $field as f from $table";
		if($where!=""){
			$sql.=" where $where";
		}
		$query=$this->query($sql);
		$arr=$this->fetch_array($query);		
		return $arr['f'];
	}
	
	/**
     * ?SQL?е?(?)
     *
     * @param string $sql ??в?SQL
     * @return ?????,??false
     */
    function getAll($sql)
	{
        $this->query($sql);
        $this->db_record = array();
        while ($row = @mysql_fetch_array($this->db_result, $this->fetch_mode)) 
		{
            $this->db_record[] = $row;
        }
        @mysql_free_result($this->db_result);
        if (!is_array($this->db_record) || empty($this->db_record)){
            return false;
        }
        return $this->db_record;
    }

//?

	function page_1($pagesql,$page=1,$pagesize=15){	
		$page=(int)$page<1?1:$page;
		$query=$this->query($pagesql);
		$rscount=$this->num_rows($query);
		$url=basename($HTTP_SERVER_VARS['PHP_SELF']).'?'.$_SERVER['QUERY_STRING'];
		$url=preg_replace('/[&]?page=[\w]*[&]?/i','',$url);
		$pagecount=$rscount%$pagesize==0?$rscount/$pagesize:(int)($rscount/$pagesize)+1;
		
		if($pagecount==0 or $pagecount=="") return;		
		$pagestr='';
		if($page>$pagecount){
			echo "<script>location.href='$url&page=$pagecount'</script>";
			return;
		}
		$pagestr="[第".$page."页 共".$pagecount."页 共".$rscount."条记录]  [<a href='$url&page=1'>首页</a>] [<a href='$url&page=".($page-1)."'>上页</a>] [<a href='$url&page=".($page+1)."'>下页</a>] [<a href='$url&page=$pagecount'>末页</a>] ";
		return $pagestr;
	}

function page_2($pagesql,$sql,$pagesize,$listsize=7){
	if($page=="")	$page=1;	
	$query=$this->query($pagesql);
	$rscount=$this->num_rows($query);
	$url=basename($HTTP_SERVER_VARS['PHP_SELF']).'?'.$_SERVER['QUERY_STRING'];
	$url=preg_replace('/[&]?page=[\w]*[&]?/i','',$url);

	$pagecount=$rscount%$pagesize==0?$rscount/$pagesize:(int)($rscount/$pagesize)+1;
	if($pagecount==0 or $pagecount=="") return;
	$midpage=(int)($listsize/2);
	$pagestr='';
	if($page>$pagecount){
		echo "<script>location.href='$url&page=$pagecount'</script>";
		return;
	}
	if($listsize>=$pagecount){
		for($i=1;$i<=$pagecount;$i++){
			$pagestr.=($i==$page)?'&nbsp;<a href="'.$url.'&page='.$i.'"><span style="color:#ff0000">'.$i.'</span></a>&nbsp;':'&nbsp;<a href="'.$url.'&page='.$i.'">'.$i.'</a>&nbsp;';
		}	
	}elseif(($page+$midpage)>$listsize && ($page+$midpage)>=$pagecount){	
		
		for($i=$listsize-1;$i>=0;$i--){
		$pagestr.=(($pagecount-$i)==$page)?'&nbsp;<a href="'.$url.'&page='.($pagecount-$i).'"><span style="color:#ff0000">'.($pagecount-$i).'</span></a>&nbsp;':'&nbsp;<a href="'.$url.'&page='.($pagecount-$i).'">'.($pagecount-$i).'</a>&nbsp;';
		}
	}elseif(($page-$midpage<=0) && $listsize<=$pagecount){		
		for($i=1;$i<=$listsize;$i++){			
			$pagestr.=($i==$page)?'&nbsp;<a href="'.$url.'&page='.$i.'"><span style="color:#ff0000">'.$i.'</span></a>&nbsp;':'&nbsp;<a href="'.$url.'&page='.$i.'">'.$i.'</a>&nbsp;';
		}
		
	}else{		
			
		for($i=$midpage;$i>=1;$i--){
			$pagestr.='&nbsp;<a href="'.$url.'&page='.($page-$i).'">'.($page-$i).'</a>&nbsp;';
		}		
		$pagestr.='&nbsp;<a href="'.$url.'&page='.$page.'"><span style="color:#ff0000">'.$page.'</span></a>&nbsp;';
		for($i=1;$i<=$midpage;$i++){
			$pagestr.='&nbsp;<a href="'.$url.'&page='.($page+$i).'">'.($page+$i).'</a>&nbsp;';
		}
	}

	$str='[ <a href="'.$url.'&page=1"><FONT style="FONT-FAMILY: Webdings">7</FONT></a>&nbsp;<a href="'.$url.'&page='.($page-1).'"><FONT style="FONT-FAMILY: Webdings">3</FONT></a>'.$pagestr.'<a href="'.$url.'&page='.($page+1).'"><FONT style="FONT-FAMILY: Webdings">4</FONT></a>&nbsp;<a href="'.$url.'&page='.($pagecount).'"><FONT style="FONT-FAMILY: Webdings">8</FONT></a> ]';
	return $str;

}
//--------------
	function close() {
		return mysql_close($this->link);
	}

	function halt($message = '', $sql = '') {

		define('CACHE_FORBIDDEN', TRUE);
		require_once ROOT_PATH.'./include/db_mysql_error.inc.php';
	}
}
?>