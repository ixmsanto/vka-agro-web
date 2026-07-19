{{-- Page loader.

     Everything it needs is inline: the markup, its styles and the script that
     dismisses it. site.css is a separate request, so a loader that waited for
     it would flash unstyled at exactly the moment it is meant to be covering
     for — which is the whole reason it exists.

     It removes itself three ways, in order of preference:
       1. site.js calls vkaHideLoader() once the page has loaded,
       2. the inline script below does the same on window.load,
       3. failing both, the CSS animation on #vka-loader fires at 6s and hides
          it regardless. A loader that can trap a visitor behind a blank screen
          because one script threw is worse than no loader at all. --}}

<div id="vka-loader" role="status" aria-live="polite" aria-label="Loading VKAAgroproducts">
    <div id="vka-loader-inner">
        {{-- The emblem arrives a piece at a time: palm, then the V, then the
             coconut, then the drop. They are four separate images stacked on
             one square, each cut out of the artwork by colour and position (see
             the splitter that generated them), so every piece animates on its
             own instead of a flat picture fading in.

             Files rather than inlined base64. Inlining looked tempting — no
             extra requests — but it is re-sent with every HTML response and
             still cannot paint until the parser has streamed past it. Measured
             on a 200kbps link a single mark appeared at 4.6s inlined against
             0.76s as a preloaded file, because a preload fetches alongside the
             HTML rather than waiting inside it. All four together are 16.8KB
             and cache from the second visit. --}}
        <div id="vka-loader-mark">
            <img class="l-palm" src="{{ asset('mark-palm.png') }}?v={{ $assetVersion }}" alt="" width="120" height="120" fetchpriority="high" decoding="async">
            <img class="l-swoosh" src="{{ asset('mark-swoosh.png') }}?v={{ $assetVersion }}" alt="" width="120" height="120" fetchpriority="high" decoding="async">
            <img class="l-ring" src="{{ asset('mark-ring.png') }}?v={{ $assetVersion }}" alt="" width="120" height="120" fetchpriority="high" decoding="async">
            <img class="l-drop" src="{{ asset('mark-drop.png') }}?v={{ $assetVersion }}" alt="" width="120" height="120" fetchpriority="high" decoding="async">
        </div>

        <div id="vka-loader-bar"><span></span></div>
    </div>
</div>

<style>
    #vka-loader {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        background:
            radial-gradient(900px 600px at 50% 38%, rgba(99, 190, 70, 0.10), transparent 60%),
            linear-gradient(180deg, #FCFBF7 0%, #F3FAF0 100%);
        /* Failsafe. Duration 0s with a 6s delay means nothing happens until the
           delay elapses, so the class-based hide below stays in charge for the
           whole time a normal load takes. */
        animation: vkaLoaderFailsafe 0s linear 6s forwards;
    }

    @keyframes vkaLoaderFailsafe {
        to { opacity: 0; visibility: hidden; pointer-events: none; }
    }

    #vka-loader.is-done {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity .55s cubic-bezier(.22, .61, .36, 1), visibility 0s .55s;
    }

    #vka-loader-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 30px;
        padding: 0 24px;
        animation: vkaLoaderIn .7s cubic-bezier(.22, .61, .36, 1) both;
    }

    /* The mark settles in rather than appearing, and lifts away on exit. */
    @keyframes vkaLoaderIn {
        from { opacity: 0; transform: translateY(10px) scale(.97); }
        to { opacity: 1; transform: none; }
    }

    #vka-loader.is-done #vka-loader-inner {
        transform: scale(1.03);
        transition: transform .55s cubic-bezier(.22, .61, .36, 1);
    }

    #vka-loader-mark {
        position: relative;
        width: clamp(84px, 9vw, 104px);
        aspect-ratio: 1;
        /* Starts only once the pieces are assembled. */
        animation: vkaLoaderBreathe 2.6s ease-in-out 1.45s infinite;
    }

    #vka-loader-mark img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
    }

    @keyframes vkaLoaderBreathe {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.04); }
    }

    /* Each piece enters the way that piece would: the palm grows from its base,
       the V sweeps in from the left along its own curve, the coconut rolls into
       place, and the drop lands last. Total build ≈1.35s, which is what MIN_MS
       in the script below is set against — dismissing sooner would cut the
       sequence off halfway. */
    .l-palm {
        transform-origin: 52% 95%;
        animation: vkaPalmIn .58s cubic-bezier(.22, .9, .3, 1) .10s forwards;
    }

    .l-swoosh {
        transform-origin: 40% 90%;
        animation: vkaSwooshIn .52s cubic-bezier(.22, .9, .3, 1) .44s forwards;
    }

    .l-ring {
        transform-origin: 76% 64%;
        animation: vkaRingIn .54s cubic-bezier(.3, 1.35, .5, 1) .70s forwards;
    }

    .l-drop {
        transform-origin: 79% 76%;
        animation: vkaDropIn .42s cubic-bezier(.3, 1.6, .5, 1) .98s forwards;
    }

    @keyframes vkaPalmIn {
        from { opacity: 0; transform: translateY(14%) scale(.72); }
        to { opacity: 1; transform: none; }
    }

    @keyframes vkaSwooshIn {
        from { opacity: 0; transform: translateX(-16%) rotate(-14deg) scale(.8); }
        to { opacity: 1; transform: none; }
    }

    @keyframes vkaRingIn {
        from { opacity: 0; transform: translateX(16%) rotate(-55deg) scale(.55); }
        to { opacity: 1; transform: none; }
    }

    @keyframes vkaDropIn {
        from { opacity: 0; transform: translateY(-32%) scale(.3); }
        to { opacity: 1; transform: none; }
    }

    /* Indeterminate: it reports that work is happening, not how much, because
       nothing here can honestly measure progress. */
    #vka-loader-bar {
        position: relative;
        width: clamp(120px, 22vw, 190px);
        height: 3px;
        border-radius: 999px;
        background: rgba(33, 80, 60, 0.16);
        overflow: hidden;
    }

    #vka-loader-bar span {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        width: 42%;
        border-radius: inherit;
        background: linear-gradient(90deg, #63BE46, #2F8B3C);
        animation: vkaLoaderSweep 1.15s cubic-bezier(.55, 0, .45, 1) infinite;
    }

    @keyframes vkaLoaderSweep {
        0% { transform: translateX(-105%); }
        100% { transform: translateX(275%); }
    }

    @media (prefers-reduced-motion: reduce) {
        /* Hold nothing back: dismiss almost immediately and drop the motion.
           The delay is short rather than zero so the swap is not a flash. */
        #vka-loader { animation-delay: .4s; }
        #vka-loader-inner,
        #vka-loader-mark,
        #vka-loader-bar span { animation: none; }
        /* Assembled, not assembling: every piece is simply present. */
        #vka-loader-mark img { opacity: 1; animation: none; transform: none; }
        #vka-loader-bar span { transform: none; width: 100%; }
    }
</style>

<script>
    (function () {
        var el = document.getElementById('vka-loader');
        if (!el) return;

        var start = Date.now();
        // Long enough for the build sequence to finish (~1.35s) plus a beat.
        // Dismissing at the old 400ms meant a fast connection only ever saw the
        // palm appear before the whole thing faded.
        var MIN_MS = 1500;
        var MAX_MS = 3500;  // ahead of the 6s CSS failsafe

        // With reduced motion there is no sequence to wait for.
        if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            MIN_MS = 250;
        }
        var done = false;

        function hide() {
            if (done) return;
            done = true;

            setTimeout(function () {
                el.classList.add('is-done');
                // Out of the DOM once faded, so it can never intercept a click.
                setTimeout(function () {
                    if (el.parentNode) el.parentNode.removeChild(el);
                }, 700);
            }, Math.max(0, MIN_MS - (Date.now() - start)));
        }

        // Exposed so site.js can dismiss it as soon as its own setup is done.
        window.vkaHideLoader = hide;

        if (document.readyState === 'complete') hide();
        else window.addEventListener('load', hide);

        setTimeout(hide, MAX_MS);
    })();
</script>
