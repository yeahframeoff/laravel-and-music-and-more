registerNotification = function()
{
    console.log('notification registered');

    var $notify = $('a#notify-check'),
        $href = $notify.data('href'),
        time = 4000,
        timer,
        data = [],
        newData = [];

    function updateNotifier()
    {
        console.log(data);
        var $badge = $notify.find('span#badge');
        if (data.length != 0)
        {
            $badge.addClass('badge');
            $badge.html(data.length);
            $notify.addClass('new-notifications');
            $notify.parent('li').addClass('dropdown');
        }
        else
        {
            $badge.removeClass('badge');
            $badge.html('');
            $notify.removeClass('new-notifications');
            $notify.parent('li').removeClass('dropdown');
        }
    }

    function updateData(incomingData)
    {
        newData.length = 0;
        for (var i = 0; i < incomingData.length; ++i)
        {
            var d = incomingData[i];
            console.log(data);
            var found = $.grep(data, function(v)
            {
                return v.id == d.id;
            });
            if (found.length == 0)
            {
                newData.push(d);
                   data.push(d);
            }
        }
    }

    function toolTips()
    {
        $notify.attr ('data-toggle','tooltip');
        newData.forEach(function(e)
        {
            console.log('tooltip: ');
            console.log(e);
            $notify.attr('data-original-title', e.popupText);
            //$notify.data('original-title', e.popupText);
            $notify.tooltip('show')
            setTimeout(function(){
                $notify.tooltip('hide');
            }, 3000);
        });
        $notify.attr('data-toggle','');
    }

    function updateDropdown()
    {
        $dropdown = $notify.parent('li.dropdown').find('> ul.dropdown-menu');
        $dropdown.empty();
        data.forEach(function(e)
        {
            
        });
    }

    $notify.on('show.bs.dropdown', function()
    {
        var checked = [];
        data.forEach(function(e) {
            checked.push(e.id);
        });
        $.post($href, {'checked[]' : checked});
        data.length = 0;
    });

    startCheck = function()
    {
        timer = setInterval(function () {
            console.log('interval');
            $.get($href,
                function (incomingData) {
                updateData(incomingData);
                updateNotifier();
                updateDropdown();
                toolTips();
            }, 'json');
        }, time);
    };

    stopCheck = function() { clearInterval(timer); };

    startCheck();
}
