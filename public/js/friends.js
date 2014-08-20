function friendshipToggle(btn, url)
{
    $btn = $(btn);
    $btn.find('> span.btn-title').hide();
    $btn.find('> strong.title-loading').show();
    
    $btn.attr('disabled', 'disabled');
    $.get(url)
        .success(function(data){
            console.log(data);
            $btn.replaceWith(data);
        })
        .fail(function(data){
            console.log(data);
            $btn.find('> span.btn-title').show();
            $btn.find('> strong.title-loading').hide();
            $btn.removeAttr('disabled');
        });
}