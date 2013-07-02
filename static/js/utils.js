//=============================================================
//==  Stylesheets manipulations
//=============================================================
function setActiveStyleSheet(title, disableOther) {
	var i, a, main;
	for (i=0; (a = document.getElementsByTagName("link")[i]); i++) {
		if (a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
			if (disableOther) a.disabled = true;
			if (a.getAttribute("title") == title) a.disabled = false;
    	}
  	}
}

function getActiveStyleSheet() {
	var i, a;
	for (i=0; (a = document.getElementsByTagName("link")[i]); i++) {
		if (a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title") && !a.disabled) return a.getAttribute("title");
	}
	return null;
}

function getPreferredStyleSheet() {
	var i, a;
	for (i=0; (a = document.getElementsByTagName("link")[i]); i++) {
		if (a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("rel").indexOf("alt") == -1 && a.getAttribute("title") )
			return a.getAttribute("title");
	}
	return null;
}


//=============================================================
//==  ListBox & ComboBox manipulations
//=============================================================
function addListBoxItem(box, val, text) {
	var item = new Option();
	item.value = val;
	item.text = text;
    box.options.add(item);
}

function clearListBox(box) {
	for (var i=box.options.length-1; i>=0; i--)
		box.options[i] = null;
}

function delListBoxItemByValue(box, val) {
	for (var i=0; i<box.options.length; i++) {
		if (box.options[i].value == val) {
			box.options[i] = null;
			break;
		}
	}
}

function delListBoxItemByText(box, txt) {
	for (var i=0; i<box.options.length; i++) {
		if (box.options[i].text == txt) {
			box.options[i] = null;
			break;
		}
	}
}

function findListBoxItemByValue(box, val) {
	var idx = -1;
	for (var i=0; i<box.options.length; i++) {
		if (box.options[i].value == val) {
			idx = i;
			break;
		}
	}
	return idx;
}

function findListBoxItemByText(box, txt) {
	var idx = -1;
	for (var i=0; i<box.options.length; i++) {
		if (box.options[i].text == txt) {
			idx = i;
			break;
		}
	}
	return idx;
}

function selectListBoxItemByValue(box, val) {
	for (var i = 0; i < box.options.length; i++) {
		box.options[i].selected = (val == box.options[i].value);
	}
}

function selectListBoxItemByText(box, txt) {
	for (var i = 0; i < box.options.length; i++) {
		box.options[i].selected = (txt == box.options[i].text);
	}
}

function getListBoxValues(box) {
	var delim = arguments[1] ? arguments[1] : ',';
	var str = '';
	for (var i=0; i<box.options.length; i++) {
		str += (str ? delim : '') + box.options[i].value;
	}
	return str;
}

function getListBoxTexts(box) {
	var delim = arguments[1] ? arguments[1] : ',';
	var str = '';
	for (var i=0; i<box.options.length; i++) {
		str += (str ? delim : '') + box.options[i].text;
	}
	return str;
}

function sortListBox(box)  {
	var temp_opts = new Array();
	var temp = new Option();
	for(var i=0; i<box.options.length; i++)  {
		temp_opts[i] = box.options[i].clone();
	}
	for(var x=0; x<temp_opts.length-1; x++)  {
		for(var y=(x+1); y<temp_opts.length; y++)  {
			if(temp_opts[x].text > temp_opts[y].text)  {
				temp = temp_opts[x];
				temp_opts[x] = temp_opts[y];
				temp_opts[y] = temp;
			}  
		}  
	}
	for(var i=0; i<box.options.length; i++)  {
		box.options[i] = temp_opts[i].clone();
	}
}

function getListBoxSelectedIndex(box) {
	for (var i = 0; i < box.options.length; i++) {
		if (box.options[i].selected)
			return i;
	}
	return -1;
}

function getListBoxSelectedValue(box) {
	for (var i = 0; i < box.options.length; i++) {
		if (box.options[i].selected) {
			return box.options[i].value;
		}
	}
	return null;
}

function getListBoxSelectedText(box) {
	for (var i = 0; i < box.options.length; i++) {
		if (box.options[i].selected) {
			return box.options[i].text;
		}
	}
	return null;
}

function getListBoxSelectedOption(box) {
	for (var i = 0; i < box.options.length; i++) {
		if (box.options[i].selected) {
			return box.options[i];
		}
	}
	return null;
}


//=============================================================
//==  Radiobuttons manipulations
//=============================================================
function getRadioGroupValue(radioGroupObj) {
	for (var i=0; i < radioGroupObj.length; i++)
		if (radioGroupObj[i].checked) return radioGroupObj[i].value;
	return null;
}

function setRadioGroupCheckedByNum(radioGroupObj, num) {
	for (var i=0; i < radioGroupObj.length; i++)
		if (radioGroupObj[i].checked && i!=num) radioGroupObj[i].checked=false;
		else if (i==num) radioGroupObj[i].checked=true;
}

function setRadioGroupCheckedByValue(radioGroupObj, val) {
	for (var i=0; i < radioGroupObj.length; i++)
		if (radioGroupObj[i].checked && radioGroupObj[i].value!=val) radioGroupObj[i].checked=false;
		else if (radioGroupObj[i].value==val) radioGroupObj[i].checked=true;
}


//=============================================================
//==  Array manipulations
//=============================================================
function sortArray(thearray)  {
	var caseSensitive = arguments[1] ? arguments[1] : false;
	for (var x=0; x<thearray.length-1; x++)  {
		for (var y=(x+1); y<thearray.length; y++)  {
			if (caseSensitive) {
				if (thearray[x] > thearray[y])  {
					tmp = thearray[x];
					thearray[x] = thearray[y];
					thearray[y] = tmp;
				}  
			} else {
				if (thearray[x].toLowerCase() > thearray[y].toLowerCase())  {
					tmp = thearray[x];
					thearray[x] = thearray[y];
					thearray[y] = tmp;
				}  
			}
		}  
	}
}


//=============================================================
//==  String functions
//=============================================================
function inList(list, str) {
	var delim = arguments[2] ? arguments[2] : '|';
	var icase = arguments[3] ? arguments[3] : true;
	var retval = false;
	if (icase) {
		str = str.toLowerCase();
		list = list.toLowerCase();
	}
	parts = list.split(delim);
	for (var i=0; i<parts.length; i++) {
		if (parts[i]==str) {
			retval=true;
			break;
		}
	}
	return retval;
}

function alltrim(str) {
	var dir = arguments[1] ? arguments[1] : 'a';
	var rez = '';
	var i, start = 0, end = str.length-1;
	if (dir=='a' || dir=='l') {
		for (i=0; i<str.length; i++) {
			if (str.substr(i,1)!=' ') {
				start = i;
				break;
			}
		}
	}
	if (dir=='a' || dir=='r') {
		for (i=str.length-1; i>=0; i--) {
			if (str.substr(i,1)!=' ') {
				end = i;
				break;
			}
		}
	}
	return str.substring(start, end+1);
}

function ltrim(str) {
	return alltrim(str, 'l');
}

function rtrim(str) {
	return alltrim(str, 'r');
}

function padl(str, len) {
	var char = arguments[2] ? arguments[2] : ' ';
	var rez = str.substr(0,len);
	if (rez.length < len) {
		for (var i=0; i<len-str.length; i++)
			rez += char;
	}
	return rez;
}

function padr(str, len) {
	var char = arguments[2] ? arguments[2] : ' ';
	var rez = str.substr(0,len);
	if (rez.length < len) {
		for (var i=0; i<len-str.length; i++)
			rez = char + rez;
	}
	return rez;
}

function padc(str, len) {
	var char = arguments[2] ? arguments[2] : ' ';
	var rez = str.substr(0,len);
	if (rez.length < len) {
		for (var i=0; i<Math.floor((len-str.length)/2); i++)
			rez = char + rez + char;
	}
	return rez+(rez.length<len ? char : '');
}

function replicate(str, num) {
	rez = '';
	for (var i=0; i<num; i++) {
		rez += str;
	}
	return rez;
}


//=============================================================
//==  Numbers functions
//=============================================================

// Clear number from any characters and append it with 0 to desired precision
function clearNumber(num) {
	var precision = arguments[1] ? arguments[1] : 0;
	var defa = arguments[2] ? arguments[2] : 0;
	var res = '';
	var float = -1;
	num = ""+num;
	if (num=="") num=""+defa;
	for (var i=0; i<num.length; i++) {
		if (float==0) break;
		else if (float>0) float--;
		var ch = num.substr(i,1);
		if (ch=='.') {
			if (precision>0) {
				res += ch;
			}
			float = precision;
		} else if ((ch>=0 && ch<=9) || (ch=='-' && i==0))
			res+=ch;
	}
	if (precision>0 && float!=0) {
		if (float==-1) {
			res += '.';
			float = precision;
		}
		for (i=float; i>0; i--)
			res +='0'; 
	}
	//if (isNaN(res)) res = clearNumber(defa, precision, defa);
	return res;
}

function dec2hex(n) { 
	return Number(n).toString(16);
}

function hex2dec(hex) {
	return parseInt(hex,16); 
}

function roundNumber(num) {
	var precision = arguments[1] ? arguments[1] : 0;
	var p = Math.pow(10,precision);
	return Math.round(num*p)/p;
}

//=============================================================
//==  Color manipulations
//=============================================================
function rgb2hex(color) {
	var aRGB;
	color = color.replace(/\s/g,"").toLowerCase();
	if (color=='rgba(0,0,0,0)' || color=='rgba(0%,0%,0%,0%)')
		color = 'transparent';
	if (color.indexOf('rgba(')==0)
		aRGB = color.match(/^rgba\((\d{1,3}[%]?),(\d{1,3}[%]?),(\d{1,3}[%]?),(\d{1,3}[%]?)\)$/i);
	else	
		aRGB = color.match(/^rgb\((\d{1,3}[%]?),(\d{1,3}[%]?),(\d{1,3}[%]?)\)$/i);
	
	if(aRGB) {
		color = '';
		for (var i=1; i<=3; i++) 
			color += Math.round((aRGB[i][aRGB[i].length-1]=="%"?2.55:1)*parseInt(aRGB[i])).toString(16).replace(/^(.)$/,'0$1');
	} else 
		color = color.replace(/^#?([\da-f])([\da-f])([\da-f])$/i, '$1$1$2$2$3$3');
	return (color.substr(0,1)!='#' ? '#' : '') + color;
}

function _rgb2hex(r,g,b) {
	return '#'+
		Number(r).toString(16).toUpperCase().replace(/^(.)$/,'0$1') +
		Number(g).toString(16).toUpperCase().replace(/^(.)$/,'0$1') +
		Number(b).toString(16).toUpperCase().replace(/^(.)$/,'0$1');
}

function split_rgb(color) {
	color = rgb2hex(color);
	var matches = color.match(/^#?([\dabcdef]{2})([\dabcdef]{2})([\dabcdef]{2})$/i);
	if (!matches) return false;
	for (var i=1, rgb = new Array(3); i<=3; i++)
		rgb[i-1] = parseInt(matches[i],16);
	return rgb;
}

function iColorPicker(){
	var colors = arguments[0] ? arguments[0] : 
	'#f00,#ff0,#0f0,#0ff,#00f,#f0f,#fff,#ebebeb,#e1e1e1,#d7d7d7,#cccccc,#c2c2c2,#b7b7b7,#acacac,#a0a0a0,#959595,'
	+'#ee1d24,#fff100,#00a650,#00aeef,#2f3192,#ed008c,#898989,#7d7d7d,#707070,#626262,#555,#464646,#363636,#262626,#111,#000,'
	+'#f7977a,#fbad82,#fdc68c,#fff799,#c6df9c,#a4d49d,#81ca9d,#7bcdc9,#6ccff7,#7ca6d8,#8293ca,#8881be,#a286bd,#bc8cbf,#f49bc1,#f5999d,'
	+'#f16c4d,#f68e54,#fbaf5a,#fff467,#acd372,#7dc473,#39b778,#16bcb4,#00bff3,#438ccb,#5573b7,#5e5ca7,#855fa8,#a763a9,#ef6ea8,#f16d7e,'
	+'#ee1d24,#f16522,#f7941d,#fff100,#8fc63d,#37b44a,#00a650,#00a99e,#00aeef,#0072bc,#0054a5,#2f3192,#652c91,#91278f,#ed008c,#ee105a,'
	+'#9d0a0f,#a1410d,#a36209,#aba000,#588528,#197b30,#007236,#00736a,#0076a4,#004a80,#003370,#1d1363,#450e61,#62055f,#9e005c,#9d0039,'
	+'#790000,#7b3000,#7c4900,#827a00,#3e6617,#045f20,#005824,#005951,#005b7e,#003562,#002056,#0c004b,#30004a,#4b0048,#7a0045,#7a0026';
	var colorsList = colors.split(',');
	var tbl = '<table class="colorPickerTable"><thead>';
	for (var i=0; i<colorsList.length; i++) {
		if (i%16==0) tbl += (i>0 ? '</tr>' : '') + '<tr>';
		tbl += '<td style="background-color:'+colorsList[i]+'"></td>';
	}
	tbl += '</tr></thead><tbody><tr><td style="border:1px solid #000;background:#fff;cursor:pointer;height:60px;-moz-background-clip:-moz-initial;-moz-background-origin:-moz-initial;-moz-background-inline-policy:-moz-initial;" colspan="16" align="center" id="colorPreview"><span style="color:#000;border:1px solid rgb(0, 0, 0);padding:5px;background-color:#fff;font:11px Arial, Helvetica, sans-serif;"></span></td></tr></tbody></table>';
	tbl += '<style>#iColorPicker input{margin:2px}</style>';

	jQuery(document.createElement("div"))
		.attr("id","iColorPicker")
		.css('display','none')
		.html(tbl)
		.appendTo("body")
		.on('mouseover', 'thead td', function(){
			var aaa=rgb2hex(jQuery(this).css('background-color'));
			jQuery('#colorPreview').css('background',aaa);
			jQuery('#colorPreview span').text(aaa);
		})
		.on('click', 'thead td', function(){
			var id = jQuery('#iColorPicker').data('fieldId');
			var func = jQuery('#iColorPicker').data('func');
			var aaa=rgb2hex(jQuery(this).css('background-color'));
			if (id) jQuery("#"+id).val(aaa).css("background", aaa).trigger('change');
			if (func!=null && func!='undefined') func(id, aaa);
			jQuery("#iColorPickerBg").hide();
			jQuery("#iColorPicker").fadeOut();
		});
	jQuery(document.createElement("div"))
		.attr("id","iColorPickerBg")
		.click(function() {
			jQuery("#iColorPickerBg").hide();
			jQuery("#iColorPicker").fadeOut();
		})
		.appendTo("body");
	jQuery('#iColorPicker td')
		.css({
			'width':'12px',
			'height':'14px',
			'border':'1px solid #000',
			'cursor':'pointer'
		});
	jQuery('#iColorPicker table')
		.css({'border-collapse':'collapse'});
	jQuery('#iColorPicker')
		.css({
			'border':'1px solid #ccc',
			'background':'#333',
			'padding':'5px',
			'color':'#fff',
			'z-index':999999
		});
	jQuery('#colorPreview')
		.css({'height':'50px'});
}

function iColorShow(id,id2,func) { 
	var eICP=jQuery("#"+id2).offset();
	jQuery("#iColorPicker")
		.data({fieldId: id, func: func})
		.css({
			'top':eICP.top+jQuery("#"+id).outerHeight()+"px",
			'left':eICP.left-jQuery("#"+id).outerWidth()+"px",
			'position':'absolute'
		})
		.fadeIn("fast");
	jQuery("#iColorPickerBg")
		.css({
			'position':'fixed',
			'top':0,
			'left':0,
			'width':'100%',
			'height':'100%'
		})
		.fadeIn("fast");

	var def=jQuery("#"+id).val();
	jQuery('#colorPreview span').text(def);
	jQuery('#colorPreview').css('background',def);
	jQuery('#color').val(def);
}


//=============================================================
//==  Cookies manipulations
//=============================================================
function getCookie(name) {
	var defa = arguments[1]!='undefined' ? arguments[1] : null;
	var start = document.cookie.indexOf(name + '=');
	var len = start + name.length + 1;
	if ((!start) && (name != document.cookie.substring(0, name.length))) {
		return defa;
	}
	if (start == -1)
		return defa;
	var end = document.cookie.indexOf(';', len);
	if (end == -1)
		end = document.cookie.length;
	return unescape(document.cookie.substring(len, end));
}


function setCookie(name, value, expires, path, domain, secure) {
	var today = new Date();
	today.setTime(today.getTime());
	if (expires) {
		expires = expires * 1000;		// * 60 * 60 * 24;
	}
	var expires_date = new Date(today.getTime() + (expires));
	document.cookie = name + '='
			+ escape(value)
			+ ((expires) ? ';expires=' + expires_date.toGMTString() : '')
			+ ((path)    ? ';path=' + path : '')
			+ ((domain)  ? ';domain=' + domain : '')
			+ ((secure)  ? ';secure' : '');
}


function deleteCookie(name, path, domain) {
	if (getCookie(name))
		document.cookie = name + '=' + ((path) ? ';path=' + path : '')
				+ ((domain) ? ';domain=' + domain : '')
				+ ';expires=Thu, 01-Jan-1970 00:00:01 GMT';
}


//=============================================================
//==  Debug functions
//=============================================================
function objDisplay(obj) {
	var html = arguments[1] ? arguments[1] : false;				// Tags decorate
	var recursive = arguments[2] ? arguments[2] : false;		// Show inner objects (arrays)
	var showMethods = arguments[3] ? arguments[3] : false;		// Show object's methods
	var level = arguments[4] ? arguments[4] : 0;				// Nesting level (for inner use only)
	var dispStr = "";
	var addStr = "";
	if (level>0) {
		dispStr += (obj===null ? "null" : "Object") + (html ? "\n<br />" : "\n");
		addStr = replicate(html ? '&nbsp;' : ' ', level*2);
	}
	if (obj!==null) {
		for (var prop in obj) {
			if (!showMethods && typeof(obj[prop])=='function')	// || prop=='innerHTML' || prop=='outerHTML' || prop=='innerText' || prop=='outerText')
				continue;
			if (recursive && (typeof(obj[prop])=='object' || typeof(obj[prop])=='array') && obj[prop]!=obj)
				dispStr += addStr + (html ? "<b>" : "")+prop+(html ? "</b>" : "")+'='+objDisplay(obj[prop], html, recursive, showMethods, level+1);
			else
				dispStr += addStr + (html ? "<b>" : "")+prop+(html ? "</b>" : "")+'='+(typeof(obj[prop])=='string' ? '"' : '')+obj[prop]+(typeof(obj[prop])=='string' ? '"' : '')+(html ? "\n<br />" : "\n");
		}
	}
	return dispStr;
}
