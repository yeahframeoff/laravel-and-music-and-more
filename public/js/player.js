 function registerPlayer() {

    $('.addTrack').on('click', function(e)
    {
        e.preventDefault();
        if ($(this).find('span:first').hasClass('glyphicon-ok'))
            return 0;

        var id = $(this).attr('data-id');
        var a = $(this);

        if ($(this).attr('deezer') !== undefined) {
            var link = '/importTrackFromDeezer/' + id;
        } else {
            var link = '/importTrack/' + id;
        }

        $.get(link)
            .success(function(data){
                $(a).find('span:first').attr('class', 'glyphicon glyphicon-ok');
                $(a).removeClass('addTrack');
            })
            .fail(function(data){
                console.log(data);
            });
    });
}
