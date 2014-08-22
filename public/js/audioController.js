
function onPlayerLoaded()
{
    console.log('load');
}


$(function() {

    //init DZ
    DZ.init({
        appId : '8',
        channelUrl : 'http://developers.deezer.com/examples/channel.php',
        player : {
            onload : onPlayerLoaded
        }
    });

    // init audio
    var a = audiojs.createAll({
        trackEnded: function() {
            var next = $('ol li.playing').next();
            if (!next.length) next = $('ol li').first();
            next.addClass('playing').siblings().removeClass('playing');
            audio.load($('a', next).attr('data-src'));
            audio.play();
        }
    });
    audio = a[0];

    // Load in a track on click
    $('ol li').click(function(e) {
        e.preventDefault();
        $(this).addClass('playing').siblings().removeClass('playing');
        var link = $('a', this).attr('data-src');
        if (/^-?[\d.]+(?:e-?\d+)?$/.test(link)){
            DZ.player.playTracks([link]);
            audio.pause();
        }
        else{
            DZ.player.pause();
            audio.load($('a', this).attr('data-src'));
            audio.play();
        }
    });






    /*
     * TODO to other file?
     */
    $('.addTrack').on('click', function(){
        if ($(this).find('span:first').hasClass('glyphicon-ok'))
            return 0;

        var id = $(this).attr('data-id');
        var a = $(this);
        $.get('/importTrack/' + id)
            .success(function(data){
                $(a).find('span:first').attr('class', 'glyphicon glyphicon-ok');
                $(a).removeClass('addTrack');
            })
            .fail(function(data){
                console.log(data);
            });
    });

});