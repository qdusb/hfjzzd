//网站域名
webname="亿客聊盟--互联网技术研发中心";
weburl=new Array("localhost");
//检测域名
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
		window.top.location.href="http://"+weburl[0]+"/Warning.php?msg=<li>您所访问的资源来自"+webname+"网站，请通过正确的域名访问<li>&url=http://"+weburl[0];
	}
}

//检测是否是框架,如果不是则返回
function check_frame(url){
	if (top.location==self.location)
	{
		top.location.href=url;
	}
}

//返回字符串长度（一个汉字二个字节）
function cnstrlen(str){
	return   str.replace(/[^\x00-\xff]/g,"**").length; 
}
//检查字符串是否是数字，字母，下划线
function checkchar(str){
	var eng = /^[A-Za-z0-9]+[A-Za-z0-9_]*$/;
	if(eng.test(str))			
		return true;
	else
		return false;
}
//检查合法邮箱地址

function checkmail(str){
	var eng= /^[a-z]([a-z0-9]*[-_]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?$/i;
	if(eng.test(str))			
		return true;
	else
		return false;
}

//日期时间
function nowdate(){  
  var     now     =     new     Date();       
  var     yy     =     now.getYear(); 
  var     mm     =     now.getMonth()+1;
  mm=(mm)<10?"0"+mm:mm;
  var     dd     =     now.getDate(); 
  dd=(dd)<10?"0"+dd:dd;
  var	  date=yy+"-"+mm+"-"+dd;
  //取时间   
  var     hh     =     now.getHours();       
  var     mm     =     now.getMinutes();       
  var     ss     =     now.getTime()     %     60000;       
  ss     =     (ss     -     (ss     %     1000))     /     1000;  
  var     time     =     hh+':';       
  if     (mm     <     10)     time     +=     '0';       
  time     +=     mm+':';       
  if     (ss     <     10)     time     +=     '0';       
  time     +=     ss;  
  
  document.all.listdate.innerHTML="当前时间："+date+" "+time;
  setTimeout("nowdate()",1000);
}


checkurl();