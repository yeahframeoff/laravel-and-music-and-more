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
        var toAppend;
        data.forEach(function(e)
        {
            toAppend = '<li><a';
            if (e.hasOwnProperty('objectUrl'))
                toAppend += ' href="' + e.objectUrl +'" ';
            toAppend += '>';
            if (e.object_type.indexOf('\\User') != -1)
                toAppend += '<img class="icon" src="' + e.object.photoUrl + '">';
            toAppend += '' + e.message + '</a></li>';
            $dropdown.append(toAppend);
        });
    }

    $notify.parent('li.dropdown').on('show.bs.dropdown', function()
    {
        var checked = [];
        data.forEach(function(e) {
            checked.push(e.id);
        });
        $.post($href, {'checked' : checked});
        data.length = 0;
    });

    startCheck = function()
    {
        timer = setInterval(function () {
            var fIds = [];
            $('a.friendship').each(function(i, fb) {
                fIds.push ($(fb).attr('id'));
            });
            $.get($href, {friends : fIds},
                function (incomingData)
                {
                    updateData(incomingData.notifications);
                    updateNotifier();
                    updateDropdown();
                    toolTips();
                    if (incomingData.hasOwnProperty('friends'))
                    {
                        console.log(incomingData);
                        Friends.updateBtns(incomingData.friends);
                    }
                }, 'json');
        }, updPeriod);
    };

    stopCheck = function() { clearInterval(timer); };

    startCheck();
};
