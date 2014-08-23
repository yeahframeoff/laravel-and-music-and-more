function registerNotification()
{
    console.log('notification registered');

    $notify = $('#notify-check');
    $('#notify-check').click(function(e)
    {
        console.log('#notify-check clicked');
        e.preventDefault();
        href = $(this).attr('href')
        $.get(href, function(data) {
            console.log(data);
            console.log (typeof data);
            if (data.length != 0)
            {
                console.log($notify);
                console.log($notify.parent());
                $notify.parent().addClass('active');
            }
        }, 'json');
    });
};
