registerNotification = function()
{
    console.log('notification registered');

    var $notify = $('a#notify-check'),
        $href = $notify.data('href'),
        updPeriod = 2000,
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
        //console.log(incomingData);
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
        data.forEach(function(e) {
            toAppend = '<li><a';
            if (e.object.hasOwnProperty('profileUrl'))
                toAppend += ' href="' + e.object.profileUrl +'" ';
            toAppend += '>';
            console.log('started making notification tile');
            console.log(e);
            console.log(e.object_type);
            if (e.object_type.indexOf('\\User') != -1)
            {
                console.log('contains');
                toAppend += '<img class="icon" src="' + e.object.photo + '">';
                console.log(toAppend);
            }
            toAppend += '' + e.message + '</a></li>';
            console.log(toAppend);
            $dropdown.append(toAppend);
        });
    }

    $notify.parent('li.dropdown').on('show.bs.dropdown', function()
    {
        var checked = [];
        data.forEach(function(e) {
            checked.push(e.id);
        });
        console.log(checked);
        $.post($href, {'checked' : checked});
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
