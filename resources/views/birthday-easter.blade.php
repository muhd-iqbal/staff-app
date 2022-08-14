<style>
    .wrapper {
        overflow: hidden;
        max-width: 100%;
    }

    .frame-container {
        position: absolute;
        padding-bottom: 56.25%;
        /* 16:9 */
        padding-top: 25px;
        width: 300%;
        /* enlarge beyond browser width */
        left: -100%;
        /* center */
    }

    .frame-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
<div class="wrapper hidden md:block">
    <div class="frame-container">
        <iframe frameborder="0" height="100%" width="100%"
            {{-- src="https://www.youtubetrimmer.com/view/?v=6GTVDP4Lxps&start=0&end=53&loop=1"  --}}
            src="https://youtube.com/embed/6GTVDP4Lxps?controls=0&showinfo=0&rel=0&autoplay=1&loop=1&mute=1&rel=0&start=0&end=53"
            frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
        </iframe>
    </div>
</div>
