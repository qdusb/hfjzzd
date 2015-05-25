config.ButtonDir = "blue";
config.StyleUploadDir = "../uploadfile/";
config.InitMode = "EDIT";
config.AutoDetectPasteFromWord = "1";
config.BaseUrl = "1";
config.BaseHref = "";
config.AutoRemote = "1";
config.ShowBorder = "0";
config.StateFlag = "1";
config.CssDir = "coolblue";
config.AutoDetectLanguage = "1";
config.DefaultLanguage = "zh-cn";
config.AllowBrowse = "1";

function showToolbar(){

	document.write ("<table border=0 cellpadding=0 cellspacing=0 width='100%' class='Toolbar' id='eWebEditor_Toolbar'><tr><td><div class=yToolbar><DIV CLASS=Btn TITLE='"+lang["Bold"]+"' onclick=\"format('bold')\"><IMG CLASS=Ico SRC='buttonimage/blue/bold.gif'></DIV><DIV CLASS=Btn TITLE='"+lang["Italic"]+"' onclick=\"format('italic')\"><IMG CLASS=Ico SRC='buttonimage/blue/italic.gif'></DIV><DIV CLASS=Btn TITLE='"+lang["UnderLine"]+"' onclick=\"format('underline')\"><IMG CLASS=Ico SRC='buttonimage/blue/underline.gif'></DIV><DIV CLASS=Btn TITLE='"+lang["JustifyLeft"]+"' onclick=\"format('justifyleft')\"><IMG CLASS=Ico SRC='buttonimage/blue/justifyleft.gif'></DIV><DIV CLASS=Btn TITLE='"+lang["JustifyCenter"]+"' onclick=\"format('justifycenter')\"><IMG CLASS=Ico SRC='buttonimage/blue/justifycenter.gif'></DIV><DIV CLASS=Btn TITLE='"+lang["JustifyRight"]+"' onclick=\"format('justifyright')\"><IMG CLASS=Ico SRC='buttonimage/blue/justifyright.gif'></DIV><DIV CLASS=Btn TITLE='"+lang["JustifyFull"]+"' onclick=\"format('JustifyFull')\"><IMG CLASS=Ico SRC='buttonimage/blue/justifyfull.gif'></DIV><DIV CLASS=Btn TITLE='"+lang["Image"]+"' onclick=\"showDialog('img.htm', true)\"><IMG CLASS=Ico SRC='buttonimage/blue/img.gif'></DIV><DIV CLASS=Btn TITLE='"+lang["CreateLink"]+"' onclick=\"createLink()\"><IMG CLASS=Ico SRC='buttonimage/blue/createlink.gif'></DIV><DIV CLASS=Btn TITLE='"+lang["Unlink"]+"' onclick=\"format('UnLink')\"><IMG CLASS=Ico SRC='buttonimage/blue/unlink.gif'></DIV><DIV CLASS=TBGen>&nbsp;</DIV></div></td></tr></table>");

}
