<div id="jp_gui_container" class="jp-video jp-video-360p">
    <div data-video="<?= $this->src; ?>" data-poster="" data-gui="#jp_gui_container" data-width='670' data-height="320"></div>
    <div class="jp-type-single">
        <div class="jp-jplayer"></div>
        <div class="jp-gui">
            <div class="jp-video-play">
                <a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>
            </div>
            <div class="jp-interface">
                <div class="jp-progress">
                    <div class="jp-seek-bar">
                        <div class="jp-play-bar"></div>
                    </div>
                </div>
                <div class="jp-current-time"></div>
                <div class="jp-duration"></div>
                <div class="jp-title">
                    <ul>
                        <li><?= $this->title ?></li>
                    </ul>
                </div>
                <div class="jp-controls-holder">
                    <ul class="jp-controls">
                        <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                        <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                        <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
                        <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                        <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                        <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max
                                volume</a></li>
                    </ul>
                    <div class="jp-volume-bar">
                        <div class="jp-volume-bar-value"></div>
                    </div>

                    <ul class="jp-toggles">
                        <li><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen">full
                                screen</a></li>
                        <li><a href="javascript:;" class="jp-restore-screen" tabindex="1"
                               title="restore screen">restore screen</a></li>
                        <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
                        <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat
                                off</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="jp-no-solution">
            <span>Update Required</span>
            To play the media you will need to either update your browser to a recent version or update your <a
                href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("[data-video]").each(function() {
            var container = $(this);
            container.jPlayer({
                swfPath: "<?= $this->assets . '/plugins/jplayer/'; ?>",
                solution: "flash, html", // Flash with an HTML5 fallback.
                supplied: "m4v",
                preload: 'auto',  // HTML5 Spec values: none, metadata, auto.
                cssSelectorAncestor: container.data('gui'),
                cssSelector: { // * denotes properties that should only be required when video media type required. _cssSelector() would require changes to enable splitting these into Audio and Video defaults.
                    videoPlay: ".jp-video-play", // *
                    play: ".jp-play",
                    pause: ".jp-pause",
                    stop: ".jp-stop",
                    seekBar: ".jp-seek-bar",
                    playBar: ".jp-play-bar",
                    mute: ".jp-mute",
                    unmute: ".jp-unmute",
                    volumeBar: ".jp-volume-bar",
                    volumeBarValue: ".jp-volume-bar-value",
                    volumeMax: ".jp-volume-max",
                    currentTime: ".jp-current-time",
                    duration: ".jp-duration",
                    fullScreen: ".jp-full-screen", // *
                    restoreScreen: ".jp-restore-screen", // *
                    repeat: ".jp-repeat",
                    repeatOff: ".jp-repeat-off",
                    gui: ".jp-gui", // The interface used with autohide feature.
                    noSolution: ".jp-no-solution" // For error feedback when jPlayer cannot find a solution.
                },
                optionsVideo: {
                    size: {
                        width: "480px",
                        height: "270px",
                        cssClass: "jp-video-270p"
                    },
                    sizeFull: {
                        width: "100%",
                        height: "100%",
                        cssClass: "jp-video-full"
                    }
                },
                emulateHtml: false, // Emulates the HTML5 Media element on the jPlayer element.
                errorAlerts: false,
                warningAlerts: false,
                ready: function () {
                    $(this).jPlayer("setMedia", {
                        m4v: $(this).data('video'),
                        poster: $(this).data('poster')
                    });
                },
                size: {
                    width: "670px",
                    height: "360px"
                }

            });
        });

    });
</script>