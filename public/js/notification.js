function registerNotification()
{
    console.log('notification registered');

    $notify = $('#notify-check');
    $href = $notify.attr('href');
    var time = 4000;

    updateNotifier = function(data)
    {
        $badge = $notify.find('span#badge');
        if (data.length != 0)
        {
            $badge.addClass('badge');
            $badge.html(data.length);
            $notify.addClass('new-notifications');
        }
        else
        {
            $badge.removeClass('badge');
            $badge.html('');
            $notify.addClass('new-notifications');
        }
    }
    timer = setInterval(function()
    {
        console.log('interval');
        $.get($href, function(data) {
            console.log(data);
            updateNotifier(data);
        }, 'json');
    }, time);
};
