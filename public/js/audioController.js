var app = {};

function initPlayers()
{
    var ui = '.musicPlayer';

    app.volume = 1;

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
    DZ.Event.subscribe('track_end', function(){
        playNext();
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
    sound.on('ended', function(){
        playNext();
    });

    $('.volume-slider .volume-current').css('width', '100%');
    //0 - DZ
    //1 - audio5
    var currentPlayer;

    //slider click
    $(".time-total").click(function(evt,arg){
        var posX = evt.pageX - $(this).offset().left;
        if(currentPlayer == 0)
            DZ.player.seek((posX/$(this).width()) * 100);
        if(currentPlayer == 1)
            sound.seek(sound.duration * (posX/$(this).width()));
    });

    $(".volume-slider").click(function(evt,arg){
        var posX = evt.pageX - $(this).offset().left;
        if(currentPlayer == 0)
            DZ.player.setVolume((posX/$(this).width()) * 100);
        if(currentPlayer == 1)
            sound.volume(posX/$(this).width());
        app.volume = posX/$(this).width();
        $('.volume-slider .volume-current').css('width', (posX/$(this).width()) * 100 + '%');
    });


    // Load in a track on click
    $(ui + '.li').on('click', function(e) {
        e.preventDefault();
        $(ui + ' > .play').addClass('pause');
        $(ui + ' > .play').removeClass('play');

        $(this).addClass('playing').siblings().removeClass('playing');
        var link = $('a', this).attr('data-src');
        var cover_link = $('a', this).attr('data-cover');
        if (!cover_link.length)
            cover_link = '/public/images/empty.png';
        $(ui).find('img').attr('src', cover_link);
        $(ui + ' h1').html($(this).text());

        if (/^-?[\d.]+(?:e-?\d+)?$/.test(link)){
            currentPlayer = 0;
            DZ.player.playTracks([link]);
            DZ.player.setVolume(app.volume * 100);
            if(sound.playing)
                sound.pause();
        }
        else{
            currentPlayer = 1;
            DZ.player.pause();
            if(sound.playing)
                sound.pause();
            sound.load(($('a', this).attr('data-src')));
            sound.volume(app.volume);
        }
        var data = getCurrentAudioInfo();
        Backbone.trigger('audio:playingNow', data);
        console.log('volume', app.volume);
    });


    //TODO in 1 method?
    //button process
    $(ui + ' > .play').on('click', function(){
        playPause.call(this);
    });

    $(ui + ' > .play-broadcast').on('click', function(){
        if(confirm('Start broadcast?')){
            playPause().call(this);
        }
    });

    $('.next').on('click', function(){
        console.log('next');
        playNext();
    });

    $('.prev').on('click', function(){
        console.log('prev');
        var prev = $('li.playing' + ui).prev();
        if (!prev.length)
            prev = $('ol li' + ui).last();
        prev.click();
    });

    var getCurrentAudioInfo = function(){
        var currentAudio = $('a', 'li.playing' + ui);
        var data = {
            name: currentAudio.html(),
            cover: currentAudio.attr('data-cover'),
            src: currentAudio.attr('data-src')
        }
        return data;
    }

    var playNext = function(){
        var next = $('li.playing' + ui).next();
        $(ui + ' h1').html(next.text());
        if (!next.length)
            next = $('ol li' + ui).first();
        next.click();
    }

    var playPause = function(){
        console.log('playPause');
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
    }

    this.playFromData = function(data){
        console.log('play from data');
        console.log(data);
        var link = data.src;
        var cover_link = data.cover;
        if (!cover_link.length)
            cover_link = '/public/images/empty.png';
        $(ui).find('img').attr('src', cover_link);
        $(ui + ' h1').html(data.name);

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
            sound.load(link);
        }
    }
}


$(function() {
    player = new initPlayers();
});