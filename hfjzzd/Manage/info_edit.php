<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$sec_id		=(int)$_GET['sec_id'];
$third_id	=(int)$_GET['third_id'];
$page		=(int)$_GET['page'];
$id			=(int)$_GET['id'];

if($sec_id<1){
	Warning("û��ָ������ID�ţ�");
}
$listURL="info_list.php?sec_id=$sec_id&third_id=$third_id&page=$page";
$editURL="info_edit.php?sec_id=$sec_id&third_id=$third_id&page=$page&id=$id";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

$sql="select big_id,sec_name,out_name,third_state from sec_class where id=$sec_id";
$db->query($sql);

if($arr=$db->fetch_array($db->query($sql))){
	$big_id=$arr['big_id'];
	$sec_name=$arr['sec_name'];
	$sec_third_state=$arr['third_state'];
	$out_name=$arr['out_name'];
}else{
	$db->close();
	Warning("ָ���Ķ������಻���ڣ�");
}

$sql="select * from big_class where id=$big_id";
if($arr=$db->fetch_array($db->query($sql))){
	$big_name=$arr['typename'];

	$hasViews		=	$arr['hasViews'];
	$hasHot			=	$arr['hasHot'];
	$hasKeyword		=	$arr['hasKeyword'];
	$hasState		=	$arr['hasState'];

	$hassmaPic		=	$arr['hassmaPic'];
	$hasbigPic		=	$arr['hasbigPic'];
	$hasFile		=	$arr['hasFile'];

	$hasIntro		=	$arr['hasIntro'];
	$hasContent		=	$arr['hasContent'];
	$hasWebsite		=	$arr['hasWebsite'];

	$hasAuthor		=	$arr['hasAuthor'];
	$hasSource		=	$arr['hasSource'];
	$hasPublishdate	=	$arr['hasPublishdate'];	
	
}else{
	$db->close();
	Warning("ָ���ļ�¼�����ڣ�");
}

if ($sec_third_state=="YES"){
	if($third_id>0){
		$sql="select third_name from third_class where sec_id=$sec_id and id=$third_id";
		if($arr=$db->fetch_array($db->query($sql))){
			$third_name=$arr['third_name'];			
		}else{
			$db->close();
			Warning("ָ�����������಻���ڣ�");
		}

	}else{
		$sql="select id,third_name from third_class where sec_id=$sec_id order by shownum asc";
		if($arr=$db->fetch_array($db->query($sql))){
			$third_id=$arr['id'];
			$third_name=$arr['third_name'];
		}else{
			$db->close();
			Warning("û���������࣬���Ƚ�����");
		}
	}

}


if($_SERVER['REQUEST_METHOD']=='POST'){
	$third_id=(int)$_POST['third_id'];

	if($sec_third_state=="YES"){
		if($third_id<1){
			$db->close();
			Warning("ѡ�������������Ч��");
		}else{
			if($db->getCount("third_class", "*", "sec_id=$sec_id and id=$third_id")!=1){
				$db->close();
				Warning("ѡ�������������Ч��");
			}
		}
	}else{
		$third_id=0;
	}
	
	$shownum	= (int)$_POST['shownum'];
	$new_type	= (int)$_POST['new_type'];
	$title		= substr($_POST['title'],0,100);
	$website	= substr($_POST['website'],0,100);
	$keyword	= substr($_POST['keyword'],0,100);
	$author		= substr($_POST['author'],0,100);
	$source		= substr($_POST['source'],0,100);
	$publishdate= substr($_POST['publishdate'],0,100);
	$color		= substr($_POST['color'],0,100);
	$intro		= $_POST['intro'];
	//echo $intro;
	//exit;
	$content	= $_POST['content'];
	$state		= ToLimitLng($_POST['state'],0,4);
	$hot		= ToLimitLng($_POST['hot'],0,1);
	$adduser	=$_SESSION['username'];
	$gx	= (int)$_POST['gx'];
	//���
	if($title=="" ){
		$db->close();
		Warning("��д�������д���");
	}
	if($shownum<1){
		$shownum=$db->getMax('info','shownum',"big_id=$big_id")+10;
	}

	if($id>0){	
		if($_SESSION['sql_adv']!='all' && !@in_array('update', $_SESSION['sql_adv']))
		{
			echo "<script>alert('��û�д��޸�Ȩ��!');history.back();</script>";
			exit;
		}
		
		$sql="update info set third_id=$third_id,shownum=$shownum,title='$title',website='$website',keyword='$keyword',author='$author',source='$source',publishdate='$publishdate',intro='$intro',content='$content',state=$state,hot=$hot,modify_time='".time()."',color='$color',new_type=$new_type,gx=$gx where id=$id";
	
	
		
	}else{

		if($_SESSION['sql_adv']!='all' && !@in_array('insert', $_SESSION['sql_adv']))
		{
			echo "<script>alert('��û�д����Ȩ��!');history.back();</script>";
			exit;
		}		
		
		
		$id=$db->getMax("info","id")+1;
		$sql="insert into info values($id,$big_id,$sec_id,$third_id,'$adduser',$shownum,'$title','$website','$keyword','$author','$source','$publishdate','$intro','$content',0,0,$state,$hot,0,'".time()."','".time()."','$color',1,'$shuser',".intval($_SESSION['dept_id']).",$new_type,$gx)";
	}
	
	
	if($db->query($sql)){
	
		Redirect($listURL);
	}else{
		Warning("�༭��Ϣʧ��!");
	}	
	
}else{
	if($id>0){
		//��ѯ��¼
		$sql="select * from info where id=$id and sec_id=$sec_id";
		if($arr=$db->fetch_array($db->query($sql))){

			$third_id			=	$arr['third_id'];
			$shownum			=	$arr['shownum'];
			$title				=	$arr['title'];
			$keyword			=	$arr['keyword'];
			$website			=	$arr['website'];
			$author				=	$arr['author'];
			$source				=	$arr['source'];
			$publishdate		=	$arr['publishdate'];
			$intro				=	$arr['intro'];
			$content			=	$arr['content'];
			$state				=	$arr['state'];
			$hot				=	$arr['hot'];
			$color				=	$arr['color'];
			$new_type			=	$arr['new_type'];
			$gx					=	$arr['gx'];
		if(!$publishdate){$publishdate=date("Y-m-d h:i:s",time());}

		}else{
			$db->close();
			Warning("ָ���ļ�¼�����ڣ�");
		}

	}else{
	if(!$publishdate){$publishdate=date("Y-m-d h:i:s",time());}
		//�趨Ĭ��ֵ
		$shownum=$db->getMax('info','shownum',"big_id=$big_id")+10;
		$state=1;
		$hot=0;	
		$new_type=0;
	}
}
?>
<html>
	<head>

		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="Expires" content="-1000">
		<link href="images/default.css" rel="stylesheet" type="text/css">
		<script language="javascript" src="images/common.js"></script>
		<script type="text/javascript" charset="gb2312" src="/data/ueditorgbk/editor_config.js"></script>
		<script type="text/javascript" charset="gb2312" src="/data/ueditorgbk/editor_all.js"></script>
		<script language="javascript" type="text/javascript" src="date/WdatePicker.js"></script>
<?php if($id==0){?>
<script language="javascript">
function check1(form)
{

}
</script>
<?php
}
?>

		<script language="javascript">
			function check(form)
			{
				if (form.title.value == "")
				{
					alert("��������⣡");
					form.title.focus();
					return false;
				}


				if (form.third_id && form.third_id.options)
				{
					if (form.third_id.options[form.third_id.selectedIndex].value == "0")
					{
						alert("��ѡ�����࣡");
						form.third_id.focus();
						return false;
					}
				}



				return true;
			}
		</script>
		
<script type="text/javascript" language="javascript">
<!--
var ColorHex=new Array('00','33','66','99','CC','FF')
var SpColorHex=new Array('FF0000','00FF00','0000FF','FFFF00','00FFFF','FF00FF')
var current=null

function intocolor()
{
var colorTable=''
for (i=0;i<2;i++)
 {
  for (j=0;j<6;j++)
   {
    colorTable=colorTable+'<tr height=12>'
    colorTable=colorTable+'<td width=11 style="background-color:#000000">'
    
    if (i==0){
    colorTable=colorTable+'<td width=11 style="background-color:#'+ColorHex[j]+ColorHex[j]+ColorHex[j]+'">'} 
    else{
    colorTable=colorTable+'<td width=11 style="background-color:#'+SpColorHex[j]+'">'} 

    
    colorTable=colorTable+'<td width=11 style="background-color:#000000">'
    for (k=0;k<3;k++)
     {
       for (l=0;l<6;l++)
       {
        colorTable=colorTable+'<td width=11 style="background-color:#'+ColorHex[k+i*3]+ColorHex[l]+ColorHex[j]+'">'
       }
     }
  }
}
colorTable='<table width=253 border="0" cellspacing="0" cellpadding="0" style="border:1px #000000 solid;border-bottom:none;border-collapse: collapse" bordercolor="000000">'
           +'<tr height=30><td colspan=21 bgcolor=#cccccc>'
           +'<table cellpadding="0" cellspacing="1" border="0" style="border-collapse: collapse">'
           +'<tr><td width="3"><td><input type="text" name="DisColor" size="6" disabled style="border:solid 1px #000000;background-color:#ffff00"></td>'
           +'<td width="3"><td><input type="text" name="HexColor" size="7" style="border:inset 1px;font-family:Arial;" value="#000000"></td></tr></table></td></table>'
           +'<table border="1" cellspacing="0" cellpadding="0" style="border-collapse: collapse" bordercolor="000000" onmouseover="doOver()" onmouseout="doOut()" onclick="doclick()" style="cursor:hand;">'
           +colorTable+'</table>';          
colorpanel.innerHTML=colorTable
}

//����ɫֵ��ĸ��д
function doOver() {
      if ((event.srcElement.tagName=="TD") && (current!=event.srcElement)) {
        if (current!=null){current.style.backgroundColor = current._background}     
        event.srcElement._background = event.srcElement.style.backgroundColor
        DisColor.style.backgroundColor = event.srcElement.style.backgroundColor
        HexColor.value = event.srcElement.style.backgroundColor.toUpperCase();
        event.srcElement.style.backgroundColor = "white"
        current = event.srcElement
      }
}

//����ɫֵ��ĸ��д
function doOut() {

    if (current!=null) current.style.backgroundColor = current._background.toUpperCase();
}

function doclick()
{
    if (event.srcElement.tagName == "TD")
    {
        var clr = event.srcElement._background;
        clr = clr.toUpperCase(); //����ɫֵ��д
        if (targetElement)
        {
            //��Ŀ���޼�������ɫֵ
            targetElement.value = clr;
        }
        DisplayClrDlg(false);
        return clr;
    }
}
-->
</script>
<div id="colorpanel" style="position:absolute;display:none;width:253px;height:177px; z-index:100"></div>			
	</head>
	<body onLoad="document.form1.title.focus();">

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">��ǰλ��: ��������  -&gt; <?php echo $big_name?> -&gt; <?php echo $sec_name?> -&gt; ��Ϣ</td>
			</tr>
		</table>

		<table width="100%" border="0" cellSpacing="1" cellPadding="0" align="center" id="mainTable">
			<form name="form1" action="<?php echo $editURL?>" method="post" onSubmit="return check(this);">
			
				<tr class="editHeaderTr">
					<td width="13%" class="editHeaderTd">����/�༭</td>
				    <td width="87%" align="right" class="editHeaderTd"><a href="<?php echo $listURL?>">[�����б�]</a>&nbsp; </td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">���</td>
					<td class="editRightTd"><input name="shownum" type="text" id="shownum" value="<?php echo $shownum?>" size="10" maxlength="8"></td>
				</tr>
				<tr class="editTr">
                  <td class="editLeftTd">����</td>
				  <td class="editRightTd"><input type="text" value='<?php echo strip_tags($title)?>' name="title" size="60" maxlength="100">
				      <input name="color" type="text" id="color" size="9" alt="clrDlg" value="<?php echo $color?>">
				    ��ɫѡ��</td>
			  </tr>
				<?php if($out_name){?>
			  <?php
			  }
			  ?>
					<?php
					if($hasState){
					?>
				<tr class="editTr">
					<td class="editLeftTd">״̬</td>
				  <td class="editRightTd">
						<input type="radio" name="state" value="0" <?php echo $state==0?"checked":""?> > ����ʾ
						<input type="radio" name="state" value="1" <?php echo $state==1?"checked":""?>> ����
						<input type="radio" name="state" value="2" <?php echo $state==2?"checked":""?> > �ö�
						<input type="radio" name="state" value="3" <?php echo $state==3?"checked":""?> > ���ö�						</td>
				</tr>
				<?php }else{?>
						<input type="hidden" name="state" value="1">
				<?php }?>
					
					<?php
					if($hasHot){
					?>
						<tr class="editTr">
							<td class="editLeftTd">�ȵ�</td>
							<td class="editRightTd">
							<input type="radio" name="hot" value="1" <?php echo $hot==1?"checked":""?> > ��
							<input type="radio" name="hot" value="0" <?php echo $hot==0?"checked":""?>> ��							</td>
						</tr>
					<?php }?>					
					<?php
						if($sec_third_state=="YES"){	
					?>
					<tr class="editTr">
						<td class="editLeftTd">��������</td>
						<td class="editRightTd">
							<select name="third_id">
										<?php
										$sql="select id,third_name from third_class where sec_id=$sec_id";
										$query=$db->query($sql);
										while($arr=mysql_fetch_array($query)){
										?>					
										<option value="<?php echo $arr['id']?>"<?php echo $third_id==$arr['id']?" selected":""?>><?php echo $arr['third_name']?></option>
										<?php
										}?>								
							</select>						</td>
					</tr>
					<?php 
						}else{
							?>
							<input type="hidden" name="third_id" value="0">
							<?php
						}
					?>
				
				<?php
				if($hasWebsite){
				?>
					<tr class="editTr">
						<td class="editLeftTd">���ӵ�ַ</td>
						<td class="editRightTd"><input type="text" name="website" value="<?php echo $website?>" size="50" maxlength="100"></td>
					</tr>
				<?php 
				}else{
				?>
					<input type="hidden" name="hasWebsite" value="<?php echo $hasWebsite?>">
				<?php
				}?>
				<?php 
					if($hasKeyword){	
				?>
					<tr class="editTr">
						<td class="editLeftTd">�ؼ���</td>
						<td class="editRightTd"><input type="text" name="keyword" value="<?php echo $keyword?>" size="30" maxlength="50"></td>
					</tr>
				<?php 
				}else{
				?>
					<input type="hidden" name="hasKeywork" value="<?php echo $hasKeyword?>">
				<?php
				}?>
				<?php 
					if($hasAuthor){	
				?>
					<tr class="editTr">
						<td class="editLeftTd">ǩ����</td>
						<td class="editRightTd"><input type="text" name="author" value="<?php echo $author?>" size="30" maxlength="50"></td>
					</tr>
				<?php 
				}else{
				?>
					<input type="hidden" name="hasAuthor" value="<?php echo $hasAuthor?>">
				<?php
				}?>
				<?php 
					if($hasSource){	
				?>
					<tr class="editTr">
						<td class="editLeftTd">�Ϲ���ͨ��</td>
						<td class="editRightTd"><input type="text" name="source" value="<?php echo $source?>" size="30" maxlength="50"></td>
					</tr>
				<?php 
				}else{
				?>
					<input type="hidden" name="hasSource" value="<?php echo $hasSource?>">
				<?php
				}?>
				<?php 
					if($hasPublishdate){	
				?>
					<tr class="editTr">
						<td class="editLeftTd">����ʱ��</td>
						<td class="editRightTd"><input type="text" name="publishdate" value="<?php echo $publishdate?>" size="30" maxlength="15" onFocus="WdatePicker({startDate:'%y-%M-01 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"></td>
					</tr>
				<?php 
				}else{
				?>
					<input type="hidden" name="hasPublishdate" value="<?php echo $hasPublishdate?>">
				<?php
				}?>
				<?php 
					if($hasIntro){	
				?>
					<tr class="editTr">
						<td class="editLeftTd">����</td>
					    <td class="editRightTd">
				 <textarea name="intro" cols="65" rows="6"><?php echo htmlspecialchars($intro)?></textarea></td>
					</tr>
				<?php 
				}else{
				?>
					<input type="hidden" name="Intro" value="<?php echo $Intro?>">
				<?php
				}?>
				<?php 
					if($hasContent){	
				?>
					<tr class="editTr">
						<td class="editLeftTd">��ϸ����</td>
					  <td class="editRightTd">
					<input type="hidden" name="content" value="<?php echo htmlspecialchars($content)?>">
					<IFRAME ID="eWebEditor_content" name="content_new" style="border:#D0D0C8 1px solid" SRC="./phpeditor/ewebeditor.htm?id=content&style=light&show=easy" FRAMEBORDER="0" SCROLLING="no" WIDTH="100%" HEIGHT="500"></IFRAME>
					</td>
					</tr>
				<?php 
				}else{
				?>
					<input type="hidden" name="content" value="<?php echo $content?>">
				<?php
				}?>

				<tr class="editFooterTr">
					<td class="editFooterTd">&nbsp;</td>
				    <td class="editFooterTd"><input name="submit" type="submit" value=" �� �� " class="submit">
                      <input name="reset" type="reset" value=" �� �� " class="submit"></td>
				</tr>
			</form>
		</table>
		
<script type="text/javascript" language="javascript">
<!--
//Ӧ����ɫ�Ի������ע�����㣺
//��ɫ�Ի��� id : colorpanel ���ܱ�
//������ɫ�Ի�����ʾ���ı��򣨻������������� alt ���ԣ���ֵΪ clrDlg�����ܺ��Դ�Сд��

var targetElement = null; //������ɫ�Ի��򷵻�ֵ��Ԫ��

//���������ʱ��ȷ����ʾ����������ɫ�Ի���
//�����ɫ�Ի���������������ʱ���öԻ�������
//�����ɫ�Ի���ɫ��ʱ���� doclick ���������ضԻ���
function OnDocumentClick()
{
    var srcElement = event.srcElement;
    if (srcElement.alt == "clrDlg")
    {
        //��ʾ��ɫ�Ի���
        targetElement = event.srcElement;
        DisplayClrDlg(true);
    }
    else
    {
        //�Ƿ�������ɫ�Ի����ϵ����
        while (srcElement && srcElement.id!="colorpanel")
        {
            srcElement = srcElement.parentElement;
        }
        if (!srcElement)
        {
            //��������ɫ�Ի����ϵ����
            DisplayClrDlg(false);
        }
    }
    
}

//��ʾ��ɫ�Ի���
//display ������ʾ��������
//�Զ�ȷ����ʾλ��
function DisplayClrDlg(display)
{
    var clrPanel = document.getElementById("colorpanel");
    if (display)
    {
        var left = document.body.scrollLeft + event.clientX;
        var top = document.body.scrollTop + event.clientY;
        if (event.clientX+clrPanel.style.pixelWidth > document.body.clientWidth)
        {
            //�Ի�����ʾ������ҷ�ʱ��������ڵ���������ʾ�������
            left -= clrPanel.style.pixelWidth;
        }
        if (event.clientY+clrPanel.style.pixelHeight > document.body.clientHeight)
        {
            //�Ի�����ʾ������·�ʱ��������ڵ���������ʾ������Ϸ�
            top -= clrPanel.style.pixelHeight;
        }
        
        clrPanel.style.pixelLeft = left;
        clrPanel.style.pixelTop = top;
        clrPanel.style.display = "block";
    }
    else
    {
        clrPanel.style.display = "none";
    }
}

document.body.onclick = OnDocumentClick;
document.body.onload = intocolor;
//-->
</script>
	</body>
</html>