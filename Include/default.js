//��վ����
webname="�ڿ�����--�����������з�����";
weburl=new Array("localhost");
//�������
function checkurl(){
	var str=window.top.location.href;
	url=str.split('/');
	falg=false;
	for(i=0;i<weburl.length;i++){
		if(url[2]==weburl[i]){
			falg=true;
			break;
		}
	}
	if(!falg){
		window.top.location.href="http://"+weburl[0]+"/Warning.php?msg=<li>�������ʵ���Դ����"+webname+"��վ����ͨ����ȷ����������<li>&url=http://"+weburl[0];
	}
}

//����Ƿ��ǿ��,��������򷵻�
function check_frame(url){
	if (top.location==self.location)
	{
		top.location.href=url;
	}
}

//�����ַ������ȣ�һ�����ֶ����ֽڣ�
function cnstrlen(str){
	return   str.replace(/[^\x00-\xff]/g,"**").length; 
}
//����ַ����Ƿ������֣���ĸ���»���
function checkchar(str){
	var eng = /^[A-Za-z0-9]+[A-Za-z0-9_]*$/;
	if(eng.test(str))			
		return true;
	else
		return false;
}
//���Ϸ������ַ

function checkmail(str){
	var eng= /^[a-z]([a-z0-9]*[-_]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?$/i;
	if(eng.test(str))			
		return true;
	else
		return false;
}

//����ʱ��
function nowdate(){  
  var     now     =     new     Date();       
  var     yy     =     now.getYear(); 
  var     mm     =     now.getMonth()+1;
  mm=(mm)<10?"0"+mm:mm;
  var     dd     =     now.getDate(); 
  dd=(dd)<10?"0"+dd:dd;
  var	  date=yy+"-"+mm+"-"+dd;
  //ȡʱ��   
  var     hh     =     now.getHours();       
  var     mm     =     now.getMinutes();       
  var     ss     =     now.getTime()     %     60000;       
  ss     =     (ss     -     (ss     %     1000))     /     1000;  
  var     time     =     hh+':';       
  if     (mm     <     10)     time     +=     '0';       
  time     +=     mm+':';       
  if     (ss     <     10)     time     +=     '0';       
  time     +=     ss;  
  
  document.all.listdate.innerHTML="��ǰʱ�䣺"+date+" "+time;
  setTimeout("nowdate()",1000);
}


checkurl();