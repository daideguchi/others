/* jQuery tubular plugin
|* by Sean McCambridge
|* http://www.seanmccambridge.com/tubular
|* version: 1.0 (customized)
|* updated: October 1, 2012
|* since 2010
|* licensed under the MIT License
|* Enjoy.
|* 
|* Thanks,
|* Sean */

;(function ($, window) {

    // test for feature support and return if failure
    
    // defaults
    var defaults = {
        ratio: 16/9, // usually either 4/3 or 16/9 -- tweak as needed
        videoId: 'ZCAnLxRvNNc', // toy robot in space is a good default, no?
        mute: true,
        repeat: true,
        width: $(window).width(),
        wrapperZIndex: 99,
        playButtonClass: 'tubular-play',
        pauseButtonClass: 'tubular-pause',
        muteButtonClass: 'tubular-mute',
        volumeUpClass: 'tubular-volume-up',
        volumeDownClass: 'tubular-volume-down',
        increaseVolumeBy: 10,
        start: 0,
        playerVars: {
            autohide: 1,
            controls: 0,
            showinfo: 0,
            modestbranding: 1,
            wmode: 'transparent',
            playlist: ''
        },
        events: {
            onReady: null,
            onStateChange: null,
            onPlaybackQualityChange: null,
            onPlaybackRateChange: null,
            onError: null,
            onApiChange: null
        }
    };

    // methods

    var tubular = function(node, options) { // should be called on the wrapper div
        var options, optionsPlayerVars, optionsEvents,
            $body = $('body') // cache body node
            $node = $(node); // cache wrapper node

        // build container
        var tubularContainer = '<div id="tubular-container" style="overflow: hidden; position: fixed; z-index: 1; width: 100%; height: 100%"><div id="tubular-player" style="position: absolute"></div></div><div id="tubular-shield" style="width: 100%; height: 100%; z-index: 2; position: absolute; left: 0; top: 0;"></div>';
        var $tubularContainer = $(tubularContainer);

        options.playerVars = $.extend({}, defaults.playerVars, options.playerVars);

        if (typeof options.playerVars.loop !== 'undefined') {
            options.repeat = options.playerVars.loop;
        } else {
            options.playerVars.loop = options.repeat;
        }

        if (typeof options.playerVars.start !== 'undefined') {
            options.start = options.playerVars.start;
        } else {
            options.playerVars.start = options.start;
        }

        options.events = $.extend({}, defaults.events, options.events);
        options = $.extend({}, defaults, options);

        if (options.playerVars.loop) {
            options.playerVars.playlist = options.playerVars.playlist.split(',')
                .filter(function (value) {
                    return ($.trim(value) !== '');
                })
                .concat([options.videoId])
                .join(',');
        }

        // set up css prereq's, inject tubular container and set up wrapper defaults
        $('html,body').css({'width': '100%', 'height': '100%'});
        $body.prepend($tubularContainer.hide());
        $node.css({position: 'relative', 'z-index': options.wrapperZIndex});

        // set up iframe player, use global scope so YT api can talk
        window.player;
        window.onYouTubeIframeAPIReady = function() {
            player = new YT.Player('tubular-player', {
                width: options.width,
                height: Math.ceil(options.width / options.ratio),
                videoId: options.videoId,
                playerVars: options.playerVars,
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange,
                    'onPlaybackQualityChange': onPlayerPlaybackQualityChange,
                    'onPlaybackRateChange': onPlayerPlaybackRateChange,
                    'onError': onPlayerError,
                    'onApiChange': onPlayerApiChange
                }
            });
        }

        window.onPlayerReady = function(e) {
            resize();

            if (options.mute) e.target.mute();
            e.target.seekTo(options.start);
            e.target.playVideo();

            if ($.isFunction(options.events.onReady)) {
                options.events.onReady.apply(this, arguments);
            }
        }

        window.onPlayerStateChange = function(state) {
            if (state.data === YT.PlayerState.BUFFERING) {
                $tubularContainer.show();
            }

            if (state.data === 0 && options.repeat) { // video ended and repeat option is set true
                player.seekTo(options.start); // restart
            }

            if ($.isFunction(options.events.onStateChange)) {
                options.events.onStateChange.apply(this, arguments);
            }
        }

        window.onPlayerPlaybackQualityChange = function(e) {
            if ($.isFunction(options.events.onPlaybackQualityChange)) {
                options.events.onPlaybackQualityChange.apply(this, arguments);
            }
        }

        window.onPlayerPlaybackRateChange = function(e) {
            if ($.isFunction(options.events.onPlaybackRateChange)) {
                options.events.onPlaybackRateChange.apply(this, arguments);
            }
        }

        window.onPlayerError = function(e) {
            if ($.isFunction(options.events.onError)) {
                options.events.onError.apply(this, arguments);
            }
        }

        window.onPlayerApiChange = function(e) {
            if ($.isFunction(options.events.onApiChange)) {
                options.events.onApiChange.apply(this, arguments);
            }
        }

        // resize handler updates width, height and offset of player after resize/init
        var resize = function() {
            var width = $(window).width(),
                pWidth, // player width, to be defined
                height = $(window).height(),
                pHeight, // player height, tbd
                $tubularPlayer = $('#tubular-player');

            // when screen aspect ratio differs from video, video must center and underlay one dimension

            if (width / options.ratio < height) { // if new video height < window height (gap underneath)
                pWidth = Math.ceil(height * options.ratio); // get new player width
                $tubularPlayer.width(pWidth).height(height).css({left: (width - pWidth) / 2, top: 0}); // player width is greater, offset left; reset top
            } else { // new video width < window width (gap to right)
                pHeight = Math.ceil(width / options.ratio); // get new player height
                $tubularPlayer.width(width).height(pHeight).css({left: 0, top: (height - pHeight) / 2}); // player height is greater, offset top; reset left
            }

        }

        // events
        $(window).on('resize.tubular', function() {
            resize();
        })

        $('body').on('click','.' + options.playButtonClass, function(e) { // play button
            e.preventDefault();
            player.playVideo();
        }).on('click', '.' + options.pauseButtonClass, function(e) { // pause button
            e.preventDefault();
            player.pauseVideo();
        }).on('click', '.' + options.muteButtonClass, function(e) { // mute button
            e.preventDefault();
            (player.isMuted()) ? player.unMute() : player.mute();
        }).on('click', '.' + options.volumeDownClass, function(e) { // volume down button
            e.preventDefault();
            var currentVolume = player.getVolume();
            if (currentVolume < options.increaseVolumeBy) currentVolume = options.increaseVolumeBy;
            player.setVolume(currentVolume - options.increaseVolumeBy);
        }).on('click', '.' + options.volumeUpClass, function(e) { // volume up button
            e.preventDefault();
            if (player.isMuted()) player.unMute(); // if mute is on, unmute
            var currentVolume = player.getVolume();
            if (currentVolume > 100 - options.increaseVolumeBy) currentVolume = 100 - options.increaseVolumeBy;
            player.setVolume(currentVolume + options.increaseVolumeBy);
        })
    }

    // load yt iframe js api

    var tag = document.createElement('script');
    tag.src = "//www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // create plugin

    $.fn.tubular = function (options) {
        return this.each(function () {
            if (!$.data(this, 'tubular_instantiated')) { // let's only run one
                $.data(this, 'tubular_instantiated', 
                tubular(this, options));
            }
        });
    }

})(jQuery, window);
