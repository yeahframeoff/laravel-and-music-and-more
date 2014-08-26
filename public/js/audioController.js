
function initPlayers()
{
    var ui = '.musicPlayer';

    //init DZ
    DZ.init({
        appId : '8',
        channelUrl : 'http://developers.deezer.com/examples/channel.php',
        player : {
            onload : function(){console.log('load');}
        }
    });
    DZ.Event.subscribe('player_position', function(arg){
        $('.time-total .time-current').css('width', (100*arg[0]/arg[1]) + '%');
    });

    //init audio5
    var sound = new Audio5js({
        format_time: false
    });
    sound.on('canplay', function(){
        sound.play();
    });
    sound.on('timeupdate', function(position, duration){
        $('.time-total .time-current').css('width', (100*position/duration) + '%');
    });

    //0 - DZ
    //1 - audio5
    var currentPlayer;

    //slider click
    $(".time-total").click(function(evt,arg){
        var posX = evt.pageX - $(this).offset().left;
        console.log(evt.pageX, posX, $(this).offset().left);
        if(currentPlayer == 0)
            DZ.player.seek((posX/$(this).width()) * 100);
        if(currentPlayer == 1)
            sound.seek(sound.duration * (posX/$(this).width()));
    });

    // Load in a track on click
    $(ui + '.li').on('click', function(e) {
        e.preventDefault();
        $(this).addClass('playing').siblings().removeClass('playing');
        var link = $('a', this).attr('data-src');
        var cover_link = $('a', this).attr('data-cover');
        if (!cover_link.length)
            cover_link = 'http://imgs.tuts.dragoart.com/how-to-draw-pink-floyd-dark-side-of-the-moon_1_000000002854_5.jpg';
        $(ui).find('img').attr('src', cover_link);
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


    //TODO in 1 method?
    //button process
    $(ui + ' > .play').on('click', function(){
        $(this).toggleClass('play');
        $(this).toggleClass('pause');

        if($(this).hasClass('pause')){
            if (currentPlayer == 0)
                DZ.player.play();
            if (currentPlayer == 1)
                sound.play();
        } else {
            if (currentPlayer == 0)
                DZ.player.pause();
            if (currentPlayer == 1)
                sound.pause();
        }
    });

    $(ui + '.next').on('click', function(){
        var next = $('li.playing' + ui).next();
        if (!next.length)
            next = $('ol li' + ui).first();
        next.click();
    });

    $(ui + '.prev').on('click', function(){
        var prev = $('li.playing' + ui).prev();
        if (!prev.length)
            prev = $('ol li' + ui).last();
        prev.click();
    });
}


$(function() {
    initPlayers();
});