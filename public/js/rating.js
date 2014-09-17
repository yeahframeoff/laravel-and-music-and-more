registerRating = function ()
{
    var tracks = [], lists = [];

    $('.raty-rated').each(function(){
        if ($(this).data('rated-type') == 'track')
            tracks.push($(this).data('id'));
        else
            lists.push($(this).data('id'));
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

        $.post('/rate', params)
            .done(function(d){
                if (d.hasOwnProperty('error')) failed = true;
            })
            .fail(function(){
                failed = true;
            });

        if (failed)
            return false;
    }

    $.get('/rates', {tracks : tracks, playlists : lists}, function(data) {
        console.log(data);
        data.track.forEach(function(d){
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
};