//检测是否是框架,如果不是则返回
function check_frame(url){
	if (top.location==self.location)
	{
		top.location.href=url;
	}
}

//检查参数是否是日期加上时间
function isDateTime(str)
{
	var dateTime;

	dateTime = str.split(" ");

	if (dateTime.length != 2)
	{
		return false;
	}

	if (!isDate(dateTime[0]))
	{
		return false;
	}

	if (!isTime(dateTime[1]))
	{
		return false;
	}

	return true;
}


//检查参数是否是时间
function isTime(str)
{
	var time;

	time = str.split(":");

	if (time.length != 3)
	{
		return false;
	}


	if (!/^[0-9]{1,2}$/.exec(time[0]))
	{
		return false;
	}
	if (!/^[0-9]{1,2}$/.exec(time[1]))
	{
		return false;
	}
	if (!/^[0-9]{1,2}$/.exec(time[2]))
	{
		return false;
	}


	time[0] = parseInt(time[0], "10");
	time[1] = parseInt(time[1], "10");
	time[2] = parseInt(time[2], "10");

	if (time[0] < 0 || time[0] > 24)
	{
		return false;
	}
	if (time[1] < 0 || time[1] > 60)
	{
		return false;
	}
	if (time[2] < 0 || time[2] > 60)
	{
		return false;
	}


	return true;
}



//检查参数是否是日期
function isDate(str)
{
	var date;

	date = str.split("-");

	if (date.length != 3)
	{
		return false;
	}


	if (!/^(19|20){0,1}[0-9]{2}$/.exec(date[0]))
	{
		return false;
	}
	if (!/^[0-1]{0,1}[0-9]{1}$/.exec(date[1]))
	{
		return false;
	}
	if (!/^[0-3]{0,1}[0-9]{1}$/.exec(date[2]))
	{
		return false;
	}


	date[0] = parseInt(date[0], "10");
	date[1] = parseInt(date[1], "10");
	date[2] = parseInt(date[2], "10");

	if (date[1] < 1 || date[1] > 12)
	{
		return false;
	}
	if (date[2] < 1 || date[2] > 31)
	{
		return false;
	}
	if (date[1] == 4 || date[1] == 6 || date[1] == 9 || date[1] == 11)
	{
		if (date[2] > 30)
		{
			return false;
		}
	}
	if (date[1] == 2)
	{
		if (date[2] > 29)
		{
			return false;
		}
	}


	return true;
}



//反向选中指定的选择框对象
function reverseCheck(obj)
{
	if (!obj) return;
	if (!obj.length)
	{
		if (obj.desabled) return false;
		obj.checked = !obj.checked;
	}

	for (i = 0; i < obj.length; i++)
	{
		if (obj[i].disabled) continue;
		if (obj[i].checked)
		{
			obj[i].checked = false;
		}
		else
		{
			obj[i].checked = true;
		}
	}
}



//检查是否选择了条目，并提示是否删除选中的条目
function delCheck(obj)
{
	var hasChecked = false;

	if (!obj)
	{
		return false;
	}

	if (obj.length)
	{
		for (i = 0; i < obj.length; i++)
		{
			if (obj[i].checked)
			{
				hasChecked = true;
				break;
			}
		}
	}
	else
	{
		hasChecked = obj.checked;
	}

	if (!hasChecked)
	{
		alert('请先选择准备删除的记录');
		return false;
	}
	else
	{
		if (confirm('即将删除所有选择的记录, 且该操作不能恢复! 是否继续 ?'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}


//检查是否选择了条目，并提示是否删除选中的条目
function shCheck(obj)
{
	var hasChecked = false;

	if (!obj)
	{
		return false;
	}

	if (obj.length)
	{
		for (i = 0; i < obj.length; i++)
		{
			if (obj[i].checked)
			{
				hasChecked = true;
				break;
			}
		}
	}
	else
	{
		hasChecked = obj.checked;
	}

	if (!hasChecked)
	{
		alert('请先选择记录!');
		return false;
	}
	else
	{
		if (confirm('您确定要审核吗 ?'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}




//是否删除 (一条记录)
function del(title)
{
	if (confirm('即将删除 [ ' + title + ' ] , 且该操作不能恢复! 是否继续 ?'))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function pic(table_name, table_id, table_order, flag_field, id_field)
{
	var str
	str = "./pic_upload.asp?";
	str = str + "table_name="+ table_name +"&table_id=" + table_id + "&table_order="+ table_order +"&flag_field="+ flag_field +"&id_field=" + id_field;
	var p = window.open(str, "p", "width=550, height=400, scrollbars=1, left=100, top=100");
}

function file(table_name, table_id, table_order, flag_field, id_field)
{
	var str
	str = "./file_upload.asp?";
	str = str + "table_name="+ table_name +"&table_id=" + table_id + "&table_order="+ table_order +"&flag_field="+ flag_field +"&id_field=" + id_field;
	var p = window.open(str, "f", "width=550, height=250, scrollbars=1, left=100, top=100");
}

function adver(table_name, table_id, table_order, flag_field, id_field)
{
	var str
	str = "./adver_upload.asp?";
	str = str + "table_name="+ table_name +"&table_id=" + table_id + "&table_order="+ table_order +"&flag_field="+ flag_field +"&id_field=" + id_field;
	var p = window.open(str, "f", "width=550, height=400, scrollbars=1, left=100, top=100");
}