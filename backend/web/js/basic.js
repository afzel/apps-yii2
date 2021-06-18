jQuery.fn.load = function(callback){ $(window).on("load", callback) };

var csrfParam = 0;
var csrfToken = 0;
var this_host = '';
var output = new Object();

$(function(){
    this_host = window.location.protocol + "//" + window.location.hostname;
    csrfParam = $('meta[name="csrf-param"]').attr("content");
    csrfToken = $('meta[name="csrf-token"]').attr("content");
});

function nl2br(str) {
    return str.replace(/([^>])\n/g, '$1<br/>');
}

function message(text,timer) {
    $(".message_form_text").text('');
    $(".message_text").html(text);
    $("#message_form").modal().show();
    if (timer >= 0 || !timer ) {
        if (!timer) timer = 1000;
        setTimeout(function(){
            $('#message_form').modal('hide');
        },timer);
    }
}

//опирование текста в буфер для обычного боди - исполнитель
function fallbackCopyTextToClipboard(text) {
    var textArea = document.createElement("textarea");
    textArea.value = text;
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
        var successful = document.execCommand('copy');
        var msg = successful ? 'successful' : 'unsuccessful';
        console.log('Fallback: Copying text command was ' + msg);
    } catch (err) {
        console.error('Fallback: Oops, unable to copy', err);
    }

    document.body.removeChild(textArea);
}

//Копирование текста в буфер для модальных окон - исполнитель
function fallbackCopyTextToClipboardModal(text){
    const el = document.createElement('textarea');
    el.value = text;
    document.getElementById('task_modal').appendChild(el);
    el.select();
    document.execCommand('Copy');
    document.getElementById('task_modal').removeChild(el);

}

//Копирование текста в буфер обмена для обычноо боди
function copyTextToClipboard(text) {

    if (!navigator.clipboard) {
        alert('Ссылка: '+ text +' скопирована в буфер обмена!');
        fallbackCopyTextToClipboard(text);
        return;
    }
    navigator.clipboard.writeText(text).then(function() {
        console.log('Async: Copying to clipboard was successful!');
    }, function(err) {
        console.error('Async: Could not copy text: ', err);
    });
}

//Копирование текста в буфер обмена для модальных окон
function copyTextToClipboardMoadl(text) {

    if (!navigator.clipboard) {
        alert('Ссылка: '+ text +' скопирована в буфер обмена!');
        fallbackCopyTextToClipboardModal(text);
        return;
    }
    navigator.clipboard.writeText(text).then(function() {
        console.log('Async: Copying to clipboard was successful!');
    }, function(err) {
        console.error('Async: Could not copy text: ', err);
    });
}