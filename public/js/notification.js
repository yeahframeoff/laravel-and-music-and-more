registerNotification = function()
{
    console.log('notification registered');

    var $notify = $('a#notify-check'),
        $href = $notify.data('href'),
        updPeriod = 4000,
        tooltipShowTime = 2500,
        timeBetweenToolTips = 1500,
        timer,
        data = [],
        newData = [];

    function updateNotifier()
    {
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
        var d;
        for (var i = 0; i < incomingData.length; ++i)
        {
            d = incomingData[i];
            var found = $.grep(data, function(v) {
                return v.id == d.id;
            });
            if (found.length == 0)
            {
                newData.push(d);
                   data.push(d);
            }
        }
        data = incomingData;
    }

    function toolTips()
    {
        var t = 0;
        newData.forEach(function(e)
        {
            $notify.attr('data-original-title', e.popupText);
            setTimeout(function(){
                $notify.tooltip('show');
            }, t);
            setTimeout(function(){
                $notify.tooltip('hide');
            }, t += tooltipShowTime);
            t += timeBetweenToolTips;
        });
    }

    function updateDropdown()
    {
        $dropdown = $notify.parent('li.dropdown').find('> ul.dropdown-menu');
        $dropdown.empty();
        data.forEach(function(e) {
            $dropdown.append('<li><a>' + e.message + '</a></li>');
        });
    }

    $notify.parent('li.dropdown').on('show.bs.dropdown', function()
    {
        var checked = [];
        data.forEach(function(e) {
            checked.push(e.id);
        });
        console.log(checked);
        $.post($href, {'checked' : checked}).done(function(d){console.log(d)});
        data.length = 0;
    });

    startCheck = function()
    {
        timer = setInterval(function () {
            $.get($href,
                function (incomingData)
                {
                    updateData(incomingData);
                    updateNotifier();
                    updateDropdown();
                    toolTips();
                }, 'json');
        }, updPeriod);
    };

    stopCheck = function() { clearInterval(timer); };

    startCheck();
};
