
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
    DZ.Event.subscribe('player_position', function(arg){
        $("#slider_seek").find('.bar').css('width', (100*arg[0]/arg[1]) + '%');
    });

    //init audio5
    var sound = new Audio5js({
        format_time: false
    });
    sound.on('canplay', function(){
        sound.play();
    });
    sound.on('timeupdate', function(position, duration){
        $("#slider_seek").find('.bar').css('width', (100*position/duration) + '%');
    });


    $("#slider_seek").click(function(evt,arg){
        var posX = evt.pageX - $(this).position().left;
        if(currentPlayer == 0)
            DZ.player.seek((posX/$(this).width()) * 100);
        if(currentPlayer == 1)
            sound.seek(sound.duration * (posX/$(this).width()));
    });

    //0 - DZ
    //1 - audio5
    var currentPlayer;


    // Load in a track on click
    $('ol li').click(function(e) {
        e.preventDefault();
        $(this).addClass('playing').siblings().removeClass('playing');
        var link = $('a', this).attr('data-src');
        if (/^-?[\d.]+(?:e-?\d+)?$/.test(link)){
            currentPlayer = 0;
            DZ.player.playTracks([link]);
            if(sound.playing)
                sound.pause();
        }
        else{
            currentPlayer = 1;
            DZ.player.pause();
            if(sound.playing)
                sound.pause();
            sound.load(($('a', this).attr('data-src')));
        }
    });

    playerPlay = function()
    {
        if (currentPlayer == 0){
            DZ.player.play();
        }
        if (currentPlayer == 1){
            sound.play();
        }
    }

    playerPause = function()
    {
        if (currentPlayer == 0){
            DZ.player.pause();
        }
        if (currentPlayer == 1){
            sound.pause();
        }
    }

    playerNext = function()
    {
        var next = $('li.playing').next();
        if (!next.length)
            next = $('ol li').first();
        next.click();
    }

    playerPrev = function()
    {
        var next = $('li.playing').prev();
        if (!next.length)
            next = $('ol li').last();
        next.click();
    }





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