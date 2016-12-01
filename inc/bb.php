<div class="menu"><script language="JavaScript" type="text/javascript">
function tag(text1, text2) {
if ((document.selection)) {
document.form.message.focus();
document.form.document.selection.createRange().text = text1+document.form.document.selection.createRange().text+text2;
} else if(document.forms['form'].elements['message'].selectionStart!=undefined) {
var element = document.forms['form'].elements['message'];
var str = element.value;
var start = element.selectionStart;
var length = element.selectionEnd - element.selectionStart;
element.value = str.substr(0, start) + text1 + str.substr(start, length) + text2 + str.substr(start + length);
} else document.form.message.value += text1+text2;
}
</script>
<a href="#form" onclick="javascript:tag('[url=]', '[/url]');"><img src="/css/bb/url.gif"> </a> 
<a href="#form" onclick="javascript:tag('[b]', '[/b]');"><img src="/css/bb/b.gif"></a>
<a href="#form" onclick="javascript:tag('[i]', '[/i]');"><img src="/css/bb/i.gif"></a>
<a href="#form" onclick="javascript:tag('[u]', '[/u]');"><img src="/css/bb/u.gif"></a>
<a href="#form" onclick="javascript:tag('[img]', '[/img]');"><img src="/css/bb/img.gif"></a>
<a href="#form" onclick="javascript:tag('[red]', '[/red]');"><img src="/css/bb/red.gif"></a>
<a href="#form" onclick="javascript:tag('[green]', '[/green]');"><img src="/css/bb/green.gif"></a>
<a href="#form" onclick="javascript:tag('[blue]', '[/blue]');"><img src="/css/bb/blue.gif"></a></div>