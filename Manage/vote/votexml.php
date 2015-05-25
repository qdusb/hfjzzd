<?
require './class.php';

$voteid = $_GET['voteid'];
$mc = new mc_vote;

if (!$voteid) {
	$vote = $mc->get_end_line();
} else {
	$vote = $mc->get_vote($voteid);
}
//print_r($vote);
if (!$vote[13]) {
	echo '&back=连接数据发生错误'.$vote[13];
	exit;
}

$bgcolor = $vote[14] ? $vote[14] : 'EEEEEE';
$wordcolor = $vote[15] ? $vote[15] : '000000';
$wordsize = $vote[16] ? $vote[16] : '12';
$sorm = $vote[19] ? 'True' : 'False';

$votecount = 0;
for ($i=0;$i<5;$i++) {
	if ($vote[$i+3]) $votecount++;
}

//$mc->updateview();	//更新查看次数

header("Content-type: application/xml");
echo '<?xml version="1.0" encoding="GB2312"?'.'>';
?>
 
 <vote>
 	<system>
 		<voteid><?php echo $vote[1]?></voteid>
 		<voteco><![CDATA[<?php echo $vote[2]?>]]></voteco>
 		<votevi><?php echo $vote[18]?></votevi>
 		<votebgcolor><![CDATA[<?php echo $bgcolor?>]]></votebgcolor>
 		<votewordcolor><![CDATA[<?php echo $wordcolor?>]]></votewordcolor>
 		<votecount><?php echo $votecount?></votecount>
 		<word_size><?php echo $wordsize?></word_size>
 		<sorm><?php echo $sorm?></sorm>
 	</system>
<?
for ($i=0;$i<5;$i++) {
	if ($vote[$i+3]) {
?>
 	<cs>
 		<csco><![CDATA[<?php echo $vote[$i+3]?>]]></csco>
 		<csnum><?php echo $vote[$i+8]?></csnum>
 	</cs>
<?
	}
}
?>
 	<prenext>
 		<next><?php echo $mc->get_nextid()?></next>
 		<pre><?php echo $mc->get_preid()?></pre>
 	</prenext>
 </vote>
