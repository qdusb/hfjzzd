config.ButtonDir = "gray";
config.StyleUploadDir = "../uploadfile/";
config.InitMode = "EDIT";
config.AutoDetectPasteFromWord = "1";
config.BaseUrl = "1";
config.BaseHref = "";
config.AutoRemote = "1";
config.ShowBorder = "0";
config.StateFlag = "1";
config.CssDir = "office";
config.AutoDetectLanguage = "1";
config.DefaultLanguage = "zh-cn";
config.AllowBrowse = "1";

function showToolbar(){

	document.write ("<table border=0 cellpadding=0 cellspacing=0 width='100%' class='Toolbar' id='eWebEditor_Toolbar'><tr><td><div class=yToolbar><DIV CLASS=Btn TITLE='"+lang["JustifyLeft"]+"' onclick=\"format('justifyleft')\"><IMG CLASS=Ico SRC='buttonimage/gray/justifyleft.gif'></DIV><DIV CLASS=Btn TITLE='"+lang["JustifyCenter"]+"' onclick=\"format('justifycenter')\"><IMG CLASS=Ico SRC='buttonimage/gray/justifycenter.gif'></DIV><DIV CLASS=Btn TITLE='"+lang["JustifyRight"]+"' onclick=\"format('justifyright')\"><IMG CLASS=Ico SRC='buttonimage/gray/justifyright.gif'></DIV><DIV CLASS=Btn TITLE='"+lang["ForeColor"]+"' onclick=\"showDialog('selcolor.htm?action=forecolor', true)\"><IMG CLASS=Ico SRC='buttonimage/gray/forecolor.gif'></DIV><DIV CLASS=Btn TITLE='"+lang["Image"]+"' onclick=\"showDialog('img.htm', true)\"><IMG CLASS=Ico SRC='buttonimage/gray/img.gif'></DIV><DIV CLASS=Btn TITLE='"+lang["File"]+"' onclick=\"showDialog('file.htm', true)\"><IMG CLASS=Ico SRC='buttonimage/gray/file.gif'></DIV><DIV CLASS=Btn TITLE='"+lang["CreateLink"]+"' onclick=\"createLink()\"><IMG CLASS=Ico SRC='buttonimage/gray/createlink.gif'></DIV><DIV CLASS=Btn TITLE='"+lang["Unlink"]+"' onclick=\"format('UnLink')\"><IMG CLASS=Ico SRC='buttonimage/gray/unlink.gif'></DIV></div></td></tr></table>");

}
