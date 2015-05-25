<?php
@session_start();
if(!defined('IN_EKMENG')) {
	exit('Access Denied');
}
// [CH] 站点文件路径
define('ROOT_PATH',dirname(__FILE__));
// [CH] 以下变量请根据空间商提供的账号参数修改,如有疑问,请联系服务器提供商
	$dbhost = 'localhost';			// 数据库服务器
	$dbuser = 'root';				// 数据库用户名
	$dbpwd = 'jzzd123';				// 数据库密码
	$dbname = 'hfjzzd';			// 数据库名
	$pconnect = 0;					// 数据库持久连接 0=关闭, 1=打开
// [CH] 如您对 cookie 作用范围有特殊要求, 或用户前台登录不正常, 请修改下面变量, 否则请保持默认
	$cookiepre = 'ekm_';			// cookie 前缀
	$cookiedomain = ''; 			// cookie 作用域
	$cookiepath = '/';				// cookie 作用路径
// [CH] 程序投入使用后不能修改的变量
	$tablepre = 'ekm_';   			// 表名前缀, 同一数据库安装多个程序请修改此处
// [CH] 小心修改以下变量, 否则可能导致程序无法正常使用
	$dbcharset = '';// 数据库字符集, 可选 'gbk', 'big5', 'utf8', 'latin1', 留空为按照默认字符集设定
	$charset = 'gbk';				// 页面默认字符集, 可选 'gbk', 'big5', 'utf-8'
	$headercharset = 0;				// 强制页面使用默认字符集，可避免部分服务器空间页面出现乱码，一般无需开启。 0=关闭 1= 开启
	$tplrefresh = 1;				// 模板自动刷新开关 0=关闭, 1=打开。
// [CH] 程序安全设置, 调整以下设置，可以增强程序的安全性能和防御性能
	$adminemail = '';	// 系统管理员 Email
	$forumfounders = '';			// 程序创始人 UID, 可以支持多个创始人，之间使用 “,” 分隔。[出于安全考虑，请务必设置一名管理员为创始人]
									// 管理创始人可对其他管理员进行设置。如果不设置管理创始人，则管理员之间权利平等。
	$dbreport = 0;					// 程序出现数据库错误时，是否通过 email 发送错误报告给系统管理员
	$errorreport = 1;				// 是否屏蔽程序错误信息, 0=屏蔽所有错误(安全) 1=报告给管理员和版主(安全) 2=报告给任何人
	$attackevasive = 0;				// 程序防御级别，可防止大量的非正常请求造成的拒绝服务攻击
	$admincp = array();
	$admincp['forcesecques'] = 0;	// 管理人员必须设置安全提问才能进入系统设置, 0=否, 1=是[安全]
	$admincp['checkip'] = 0;		// 后台管理操作是否验证管理员的 IP, 1=是[安全], 0=否。仅在管理员无法登陆后台时设置 0。
	$admincp['tpledit'] = 0;		// 是否允许在线编辑程序模板 1=是 0=否[安全]
	$admincp['runquery'] = 0;		// 是否允许后台运行 SQL 语句 1=是 0=否[安全]
	$admincp['dbimport'] = 0;		// 是否允许后台恢复程序数据  1=是 0=否[安全]
	
	if ($_REQUEST['act'] == 'captcha')
	{
		include(ROOT_PATH . '/include/captcha.class.php');
	
		$img = new captcha(ROOT_PATH . '/data/captcha/', 80, 20);
		@ob_end_clean(); //清除之前出现的多余输入
		$img->generate_image();
		exit;
	}
?>