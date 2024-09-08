function tag(text1, text2) {
    if ((document.selection)) {
        document.message.msg.focus();
        document.message.document.selection.createRange().text = text1 + document.message.document.selection.createRange().text + text2;
    } else if (document.forms['message'].elements['msg'].selectionStart != undefined) {
        var element = document.forms['message'].elements['msg'];
        var len = document.message.msg.selectionStart;
        var str = element.value;
        var scroll = document.message.msg.scrollTop;
        var start = element.selectionStart;
        var length = element.selectionEnd - element.selectionStart;
        element.value = str.substr(0, start) + text1 + str.substr(start, length) + text2 + str.substr(start + length);
        var scroll2 = scroll + text1.length + text2.length + length;
        document.message.msg.scrollTop = scroll2;
        var len2 = text1.length + len + text2.length + length;
        document.message.msg.setSelectionRange(len2,len2);
        document.message.msg.focus();
    } else {
        document.message.msg.value += text1 + text2;
    }
}
