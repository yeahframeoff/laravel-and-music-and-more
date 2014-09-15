registerRating = function ()
{
    var data = [];
    $('.raty-rated').each(function(){
        data.push({
            'type' : $(this).data('rated-type'),
            'id' : $(this).data('id')
        });
    });

    function onClick(score, event)
    {
        console.log(event);
        var params = {
            'type' : $(this).data('rated-type'),
            'id'   : $(this).data('id'),
            'value': score
        };
        var failed = false;

        $.post('rate', params)
            .done(function(d){
                if (d.hasOwnProperty('error')) failed = true;
            })
            .fail(function(){
                failed = true;
            });

        if (failed)
            return false;
    }
    console.log({'objects[]' : data});

    $.get('rate', {'objects[]' : data}, function(data) {
        console.log(data);
        data.each(function(){
            var d = $(this);
            var selector = sprintf('.raty-rated[data-id=%d][data-rated-type=%s]',
                d.id, d.type
            );
            $(selector).raty({
                starOn  : 'public/images/star-on.png',
                starOff : 'public/images/star-off.png',
                score: d.userRate || 0,
                click: onClick
            });

        });
    }, 'json');
}