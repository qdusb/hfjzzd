<?
/*::::::::::::::::::::Class::::::::::::::::::::::*/
class admin extends mc_vote {
	
	function daddslashes($string,$force = 0) {
	
		if(!$GLOBALS['magic_quotes_gpc'] || $force) {
			if(is_array($string)) {
				foreach($string as $key => $val) {
					$string[$key] = $this->daddslashes($val, $force);
				}
			} else {
				$string = addslashes($string);
			}
		}
		return $string;
	}
	
	//添加
	function newvote($vote) {
		$lastvote = explode($this->sep, trim($this->data[$this->datanum-1]));
		$newid = $lastvote[1] + 1;
		$vote[0] = '<?die();?'.'>';
		$vote[1] = $newid;
		$this->wfile($this->file, "\n".implode($this->sep, $vote), 'ab');
		
	}
	
	//修改
	function editvote($vote) {
		$a = 0;
		$b = $this->datanum;
		while($a < $b){
			$t = floor(($a + $b)/2);
			$line = explode($this->sep, trim($this->data[$t]));
			if ($line[1] == $vote[1]) {
				$this->index = $t;
				$vote[0] = $line[0];
				$vote[17] = $line[17];
				$vote[18] = $line[19];
				$this->data[$t] = implode($this->sep, $vote);
				break;
			}
			
			if ($id > $line[1]) {
				$a = $t;
			} else {
				$b = $t;
			}
		}
		$this->writedata();
	}
	
	function oorc($id) {
		$vote = $this->get_vote($id);
		$vote[13] = $vote[13] ? 0 : 1;
		$this->data[$this->index] = implode($this->sep, $vote);
		$this->writedata();
		return $vote[13];
	}
	
	function del($id) {
		$this->get_vote($id);
		unset($this->data[$this->index]);
		$this->writedata();
		//print_r($this->data);
	}
	
	function msg($message, $url_forward = '') {
		if($url_forward) {
			$message .= "<br><br><a href=\"$url_forward\">如果您的浏览器没有自动跳转，请点击这里</a>\n";
			$message .= "<meta http-equiv=\"refresh\" content=\"2;url=$url_forward\">\n";
		}
		include './tpl/msg.php';
		exit;
	}
		
}
?>