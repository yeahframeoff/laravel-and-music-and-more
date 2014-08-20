/*

$(function() { 
    
    
    // Setup the player to autoplay the next track
    var a = audiojs.createAll({
        trackEnded: function() {
            var next = $('ol li.playing').next();
            if (!next.length) next = $('ol li').first();
            next.addClass('playing').siblings().removeClass('playing');
            audio.load($('a', next).attr('data-src'));
            audio.play();
        }
    });

    // Load in the first track
    var audio = a[0];
    first = $('ol a').attr('data-src');
    $('ol li').first().addClass('playing');
    audio.load(first);

    // Load in a track on click
    $('ol li').click(function(e) {
        e.preventDefault();
        $(this).addClass('playing').siblings().removeClass('playing');
        audio.load($('a', this).attr('data-src'));
        audio.play();
    });
});
*/

function onPlayerLoaded() {
    console.log('load');
    DZ.player.playTracks([14669216]);
    //DZ.player.play();
}


$(document).ready(function(){
    DZ.init({
        appId : '8',
        channelUrl : 'http://developers.deezer.com/examples/channel.php',
        player : {
            onload : onPlayerLoaded
        }
    });

    $('ol li').click(function(e) {
        e.preventDefault();
        $(this).addClass('playing').siblings().removeClass('playing');
        var link = $('a', this).attr('data-src');
        if (/^-?[\d.]+(?:e-?\d+)?$/.test(link))
            DZ.player.playTracks([link]);
        else
            DZ.player.playExternalTracks([link]);
        //audio.play();
    });

});

