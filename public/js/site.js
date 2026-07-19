/* VKA Agro — public site behaviour.
   Ported from the design's DCLogic component: scroll reveals, mouse parallax,
   the sticky nav, the hero slideshow, the facility video and the measured
   layout that inline CSS can't express. No build step, no dependencies. */
(function () {
  'use strict';

  // Marks the document as scripted so [data-reveal] elements start hidden.
  // Set here rather than in <head> so a parse error leaves the page visible.
  document.documentElement.classList.add('js');

  var MOBILE = 1080;
  // cubic-bezier(.16,1,.3,1) has a very long, slow tail — most of the second is
  // spent creeping the last few pixels, which reads as sluggish rather than
  // smooth. This is a plain ease-out: it arrives and stops.
  var EASE = 'cubic-bezier(.22,.61,.36,1)';
  var STAGGER = 55;

  // Every motion module checks this. The CSS has its own reduced-motion block
  // for the poses elements are parked in; this is for the behaviour that only
  // exists in script and so has nothing for that block to override.
  var REDUCED = !!(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);

  function ready(fn) {
    if (document.readyState !== 'loading') fn();
    else document.addEventListener('DOMContentLoaded', fn);
  }

  // Fires fn when el first enters the viewport, or straight away if it is
  // already on screen. Falls back to running immediately without an observer.
  function whenSeen(el, fn, threshold) {
    if (!('IntersectionObserver' in window)) { fn(); return; }

    var r = el.getBoundingClientRect();
    if (r.top < (window.innerHeight || 0) && r.bottom > 0) {
      requestAnimationFrame(fn);
      return;
    }

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (!en.isIntersecting) return;
        io.unobserve(en.target);
        fn();
      });
    }, { threshold: threshold || 0.12, rootMargin: '0px 0px -50px 0px' });

    io.observe(el);
  }

  /* ---------------- reveal on scroll ----------------
     One observer, several poses. An element names the pose it starts from with
     data-fx (rise is the default) and its place in the stagger with the value
     of data-reveal; the CSS owns the starting poses, this owns the timing and
     the trip back to rest. */

  // Registers one [data-reveal] element with the scroll observer. Assigned by
  // initReveals so rows uncovered later by "view more" can still animate in.
  var addReveal = function () {};

  // Re-checks everything still waiting and reveals whatever has since come into
  // view. Assigned by initReveals; called again once images and fonts have
  // settled, because the layout they change is the layout addReveal measured.
  var sweepReveals = function () {};

  function initReveals() {
    var revealed = new WeakSet();
    var pending = [];
    var io = null;

    if ('IntersectionObserver' in window) {
      io = new IntersectionObserver(function (entries) {
        entries.forEach(function (en) {
          if (!en.isIntersecting) return;
          show(en.target);
          io.unobserve(en.target);
        });
      }, { threshold: 0.12, rootMargin: '0px 0px -50px 0px' });
    }

    function show(el) {
      // Both the observer and the on-load measurement can reach the same
      // element, and the second one through would restart its settle timer.
      if (revealed.has(el)) return;
      revealed.add(el);

      var fx = el.getAttribute('data-fx');
      var delay = (parseInt(el.getAttribute('data-reveal'), 10) || 0) * STAGGER;

      el.style.opacity = '1';
      el.style.transform = 'none';

      // Only ever cleared for the variant that starts blurred: the hero
      // slideshow declares a drop-shadow filter inline and also reveals, and
      // clearing it unconditionally would throw that shadow away.
      if (fx === 'blur') el.style.filter = 'none';

      // The picture inside a mask wipes up from its bottom edge and settles
      // back from its over-scale. It carries the stagger itself, since the
      // element around it has nothing left to animate.
      if (fx === 'mask') {
        var inner = el.querySelector('.vka-img, .vka-slot');
        if (inner) {
          inner.style.transitionDelay = delay + 'ms';
          inner.style.clipPath = 'inset(0 0 0 0)';
          inner.style.transform = 'none';
        }
      }

      // Hand the element back to the stylesheet once it has arrived. Until
      // this runs the inline transition set below outranks every hover
      // transition the element has, so a card would ease its hover over .9s
      // instead of the .4s its own rule asks for.
      setTimeout(function () { el.style.transition = ''; }, delay + 1100);
    }

    addReveal = function (el) {
      if (revealed.has(el)) return;

      if (REDUCED) { revealed.add(el); return; }

      var delay = (parseInt(el.getAttribute('data-reveal'), 10) || 0) * STAGGER;
      el.style.transition =
        'opacity .6s ' + EASE + ' ' + delay + 'ms' +
        ', transform .6s ' + EASE + ' ' + delay + 'ms' +
        ', filter .6s ' + EASE + ' ' + delay + 'ms';

      if (!io) { show(el); return; }

      // Already above the fold on load? Reveal now instead of waiting for a
      // scroll. This measures a layout that images and fonts have not settled
      // yet, so anything judged out of view here is kept on the pending list
      // and measured again by sweepReveals once they have.
      pending.push(el);
      io.observe(el);

      var r = el.getBoundingClientRect();
      if (r.top < (window.innerHeight || 0) && r.bottom > 0) {
        requestAnimationFrame(function () { show(el); });
      }
    };

    // The observer is the normal path and handles everything scrolled into
    // view. This is the backstop for an element that was measured as off-screen
    // during load but ended up on-screen once the page settled — without it a
    // missed notification leaves that element at opacity 0 permanently.
    sweepReveals = function () {
      if (!pending.length) return;

      pending = pending.filter(function (el) {
        if (revealed.has(el)) return false;

        var r = el.getBoundingClientRect();
        if (r.top < (window.innerHeight || 0) && r.bottom > 0) {
          show(el);
          if (io) io.unobserve(el);
          return false;
        }

        return true;
      });
    };

    document.querySelectorAll('[data-reveal]').forEach(addReveal);
  }

  /* ---------------- word-by-word headings ----------------
     Each word gets a clipping window it rises through, so the line assembles
     itself instead of fading in whole. The split walks text nodes rather than
     rewriting innerHTML, which keeps the italic accent span and the <br>s in
     the markup intact. */

  function splitWords(root) {
    var walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, null, false);
    var nodes = [];
    var n;

    while ((n = walker.nextNode())) nodes.push(n);

    nodes.forEach(function (textNode) {
      if (!textNode.nodeValue.trim()) return;

      var frag = document.createDocumentFragment();

      // Capturing split: the whitespace runs come back too, so the gaps
      // between words survive as real text nodes and can still line-break.
      textNode.nodeValue.split(/(\s+)/).forEach(function (part) {
        if (!part) return;

        if (!part.trim()) {
          frag.appendChild(document.createTextNode(part));
          return;
        }

        var outer = document.createElement('span');
        outer.className = 'vka-w';

        var inner = document.createElement('span');
        inner.className = 'vka-wi';
        inner.textContent = part;

        outer.appendChild(inner);
        frag.appendChild(outer);
      });

      textNode.parentNode.replaceChild(frag, textNode);
    });

    return root.querySelectorAll('.vka-wi');
  }

  function initSplit() {
    var heads = document.querySelectorAll('[data-split]');
    if (!heads.length) return;

    // Leave the heading as authored; the CSS reveals it.
    if (REDUCED) return;

    heads.forEach(function (head) {
      var base = (parseInt(head.getAttribute('data-split'), 10) || 0) * STAGGER;

      splitWords(head).forEach(function (word, i) {
        word.style.transitionDelay = (base + i * 32) + 'ms';
      });

      head.classList.add('is-split');

      whenSeen(head, function () { head.classList.add('is-in'); }, 0.2);
    });
  }

  /* ---------------- counters ----------------
     The element's own text is the target, so the markup stays readable and a
     visitor without script (or with reduced motion) sees the final figure. */

  function initCounters() {
    if (REDUCED) return;

    document.querySelectorAll('[data-count]').forEach(function (el) {
      // A leading symbol, the figure, then whatever trails it: "50k+" counts
      // to 50 and keeps the "k+", "ISO" has no figure at all and is skipped.
      var parts = /^(\D*)([\d.]+)(.*)$/.exec(el.textContent.trim());
      if (!parts) return;

      var pre = parts[1];
      var target = parseFloat(parts[2]);
      var post = parts[3];
      var decimals = (parts[2].split('.')[1] || '').length;

      if (!isFinite(target)) return;

      el.textContent = pre + (0).toFixed(decimals) + post;

      whenSeen(el, function () {
        var start = null;
        var duration = 1300;

        function frame(now) {
          if (start === null) start = now;

          var p = Math.min((now - start) / duration, 1);
          // Ease-out quart: most of the distance early, a long settle.
          var eased = 1 - Math.pow(1 - p, 4);

          el.textContent = pre + (target * eased).toFixed(decimals) + post;
          if (p < 1) requestAnimationFrame(frame);
        }

        requestAnimationFrame(frame);
      }, 0.4);
    });
  }

  /* ---------------- magnetic buttons ----------------
     The offset goes into custom properties rather than straight into
     `transform`, so the hover lift in the stylesheet can compose with it. */

  function initMagnetic() {
    if (REDUCED) return;

    // Deliberately not the back-to-top button: its transform is written
    // inline by applyTopBtn, which would win over the class rule anyway.
    document.querySelectorAll('.vka-btn-primary, .vka-btn-ghost, .vka-btn-send').forEach(function (el) {
      el.classList.add('vka-mag');

      var box = null;
      var mx = 0, my = 0;
      var queued = false;

      function write() {
        queued = false;
        el.style.setProperty('--mx', mx.toFixed(1) + 'px');
        el.style.setProperty('--my', my.toFixed(1) + 'px');
      }

      el.addEventListener('mouseenter', function () {
        // Measured once on entry rather than per event: the button cannot move
        // while the pointer is inside it, and getBoundingClientRect() forces a
        // layout every time it is called.
        box = el.getBoundingClientRect();
      });

      el.addEventListener('mousemove', function (e) {
        if (window.innerWidth < MOBILE || !box) return;

        mx = (e.clientX - (box.left + box.width / 2)) * 0.22;
        my = (e.clientY - (box.top + box.height / 2)) * 0.3;

        // A mouse can fire far more often than the screen refreshes; without
        // this the style write (and the paint behind it) runs several times per
        // frame for nothing.
        if (queued) return;
        queued = true;
        requestAnimationFrame(write);
      }, { passive: true });

      el.addEventListener('mouseleave', function () {
        box = null;
        el.style.setProperty('--mx', '0px');
        el.style.setProperty('--my', '0px');
      });
    });
  }

  /* ---------------- card tilt ---------------- */

  function initTilt() {
    if (REDUCED) return;

    document.querySelectorAll('[data-tilt]').forEach(function (el) {
      el.classList.add('vka-tilt');

      var max = parseFloat(el.getAttribute('data-tilt')) || 6;
      var box = null;
      var px = 0.5, py = 0.5;
      var queued = false;

      function write() {
        queued = false;
        el.style.setProperty('--px', (px * 100).toFixed(1) + '%');
        el.style.setProperty('--py', (py * 100).toFixed(1) + '%');
        el.style.transform =
          'perspective(1000px) rotateX(' + ((0.5 - py) * max).toFixed(2) + 'deg)' +
          ' rotateY(' + ((px - 0.5) * max).toFixed(2) + 'deg) translateY(-6px)';
      }

      el.addEventListener('mouseenter', function () {
        box = el.getBoundingClientRect();
        el.classList.add('is-tilting');
      });

      el.addEventListener('mousemove', function (e) {
        if (window.innerWidth < MOBILE || !box) return;

        px = (e.clientX - box.left) / box.width;
        py = (e.clientY - box.top) / box.height;

        if (queued) return;
        queued = true;
        requestAnimationFrame(write);
      }, { passive: true });

      el.addEventListener('mouseleave', function () {
        box = null;
        el.classList.remove('is-tilting');
        // 'none', not '': these cards also carry data-reveal, and clearing the
        // property outright would hand them back to the rule that parks an
        // unrevealed element down the page.
        el.style.transform = 'none';
      });
    });
  }

  /* ---------------- nav scroll spy ----------------
     One bar slides between the links rather than each link owning its own
     underline, so moving between sections reads as a single continuous
     movement. */

  // Assigned by initNavSpy so the one shared scroll handler can drive it.
  var spy = function () {};
  var navSpyMeasure = function () {};

  function initNavSpy() {
    var wrap = document.getElementById('vka-navlinks');
    if (!wrap) return;

    var links = Array.prototype.slice.call(wrap.querySelectorAll('[data-navlink]'));
    if (!links.length) return;

    var sections = links.map(function (a) {
      return document.querySelector(a.getAttribute('href'));
    });

    var indicator = document.createElement('span');
    indicator.id = 'vka-nav-ind';
    wrap.appendChild(indicator);

    var active = -1;

    // Geometry is cached rather than read per scroll event. Reading offsetTop
    // forces the browser to flush layout, and doing that once per section on
    // every scroll tick was the single most expensive thing on this page.
    var tops = [];
    var linkBoxes = [];

    function measure() {
      sections.forEach(function (section, i) {
        tops[i] = section ? section.getBoundingClientRect().top + window.scrollY : Infinity;
      });

      links.forEach(function (a, i) {
        linkBoxes[i] = { left: a.offsetLeft, width: a.offsetWidth };
      });

      place();
    }

    function place() {
      var box = linkBoxes[active];
      if (!box) { indicator.style.opacity = '0'; return; }

      indicator.style.opacity = '1';
      indicator.style.width = box.width + 'px';
      indicator.style.transform = 'translateX(' + box.left + 'px)';
    }

    function select(i) {
      if (i === active) return;
      active = i;

      links.forEach(function (a, n) {
        a.style.color = n === i ? '#123C2D' : '#5E6862';
        a.style.fontWeight = n === i ? '700' : '500';
      });

      place();
    }

    // The section counts as current once its top has passed a line a third of
    // the way down the viewport — near enough to the reading position that the
    // indicator changes when the heading does.
    spy = function () {
      var line = window.scrollY + window.innerHeight * 0.32;
      var found = 0;

      for (var i = 0; i < tops.length; i++) {
        if (tops[i] <= line) found = i;
      }

      select(found);
    };

    measure();
    spy();

    // Anything that can move a section re-measures; scrolling never does.
    window.addEventListener('resize', measure);
    window.addEventListener('load', measure);
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(measure);
    navSpyMeasure = measure;
  }

  /* ---------------- idle the off-screen animations ----------------
     The ornamental marks, the pulse dots and the floating pieces all loop
     forever. The browser keeps every one of them ticking whether or not it is
     on screen, and most of them are not for most of the visit. */

  function initIdleAnimations() {
    if (REDUCED || !('IntersectionObserver' in window)) return;

    var nodes = document.querySelectorAll('.vka-deco, .vka-pulse-dot, .vka-float, .vka-float-slow');
    if (!nodes.length) return;

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        en.target.classList.toggle('is-idle', !en.isIntersecting);
      });
    }, { rootMargin: '150px 0px' });

    // Parked up front, so nothing below the fold animates before it is reached;
    // the observer's first callback releases whatever is already in view.
    nodes.forEach(function (el) {
      el.classList.add('is-idle');
      io.observe(el);
    });
  }

  /* ---------------- scroll progress ---------------- */

  function initProgress() {
    if (REDUCED) return function () {};

    var bar = document.createElement('div');
    bar.id = 'vka-progress';
    document.body.appendChild(bar);

    return function () {
      var scrollable = document.documentElement.scrollHeight - window.innerHeight;
      var p = scrollable > 0 ? window.scrollY / scrollable : 0;
      bar.style.transform = 'scaleX(' + Math.min(Math.max(p, 0), 1).toFixed(4) + ')';
    };
  }

  /* ---------------- progressive lists ("view more") ----------------
     Everything is in the markup; items past the first batch are hidden by CSS
     until asked for, so a long list costs nothing extra to load and search
     engines still see the lot. A button reveals the group it names, which lets
     the products and the gallery each run their own independently. */

  function initMore() {
    document.querySelectorAll('[data-more]').forEach(function (btn) {
      var group = btn.getAttribute('data-more');
      var step = parseInt(btn.getAttribute('data-step'), 10) || 3;
      var count = btn.querySelector('[data-more-count]');
      var hidden = '[data-more-item="' + group + '"]';

      btn.addEventListener('click', function () {
        var batch = Array.prototype.slice.call(document.querySelectorAll(hidden), 0, step);

        batch.forEach(function (el) {
          el.removeAttribute('data-more-item');
          // A gallery tile was parked while it had no height; now it can be
          // measured, drop it into whichever column is currently shortest.
          if (el.hasAttribute('data-gtile')) placeTile(el);
          // Only now can it be measured, so hand it to the reveal observer.
          // The gallery marks up the tile itself; the products their children.
          if (el.hasAttribute('data-reveal')) addReveal(el);
          el.querySelectorAll('[data-reveal]').forEach(addReveal);
        });

        var left = document.querySelectorAll(hidden).length;
        if (!left) btn.parentElement.style.display = 'none';
        else if (count) count.textContent = '(' + left + ')';
      });
    });
  }

  /* ---------------- sticky nav + back-to-top ---------------- */

  // Both of these run once a frame while scrolling, but the state they express
  // only flips twice on the whole page. Writing the styles unconditionally
  // meant re-declaring a backdrop-filter on every frame of every scroll — one
  // of the more expensive properties to hand the compositor. The guards below
  // reduce that to two writes per page load.
  var navScrolled = null;
  var topShown = null;

  function applyNav() {
    var nav = document.getElementById('vka-nav');
    if (!nav) return;

    var scrolled = window.scrollY > 40;
    if (scrolled === navScrolled) return;
    navScrolled = scrolled;

    nav.style.background = scrolled ? 'rgba(252,251,247,0.9)' : 'transparent';
    nav.style.borderBottomColor = scrolled ? '#EEF3EC' : 'transparent';
    nav.style.backdropFilter = scrolled ? 'blur(16px)' : 'blur(0px)';
    nav.style.webkitBackdropFilter = scrolled ? 'blur(16px)' : 'blur(0px)';
    nav.style.boxShadow = scrolled ? '0 8px 30px rgba(33,80,60,0.08)' : 'none';

    var bar = document.getElementById('vka-topbar');
    if (bar) {
      bar.style.maxHeight = scrolled ? '0px' : '44px';
      bar.style.opacity = scrolled ? '0' : '1';
    }
  }

  function applyTopBtn() {
    var btn = document.getElementById('vka-top');
    if (!btn) return;

    var show = window.scrollY > 520;
    if (show === topShown) return;
    topShown = show;

    btn.style.opacity = show ? '1' : '0';
    btn.style.transform = show ? 'translateY(0) scale(1)' : 'translateY(16px) scale(0.8)';
    btn.style.pointerEvents = show ? 'auto' : 'none';
  }

  /* ---------------- mouse parallax ---------------- */

  function initParallax() {
    var nodes = document.querySelectorAll('[data-parallax]');
    if (!nodes.length) return;
    if (REDUCED) return;

    var raf = null, px = 0, py = 0;

    // The transition and the depth are set once. Reassigning `transition` on
    // every frame — as this did — restarts the same half-second ease each time,
    // so the element is permanently easing towards a target that has already
    // moved and never actually tracks the pointer. One declaration up front
    // lets the transition do its job between frames instead.
    var depths = [];
    nodes.forEach(function (el, i) {
      depths[i] = parseFloat(el.getAttribute('data-depth')) || 1;
      el.style.transition = 'transform .45s cubic-bezier(.22,.61,.36,1)';
      el.style.willChange = 'transform';
    });

    window.addEventListener('mousemove', function (e) {
      if (window.innerWidth < MOBILE) return;
      px = (e.clientX / window.innerWidth) - 0.5;
      py = (e.clientY / window.innerHeight) - 0.5;
      if (raf) return;

      raf = requestAnimationFrame(function () {
        raf = null;
        nodes.forEach(function (el, i) {
          var d = depths[i];
          el.style.transform = 'translate3d(' + (px * -18 * d).toFixed(2) + 'px,' + (py * -14 * d).toFixed(2) + 'px,0)';
        });
      });
    }, { passive: true });
  }

  /* ---------------- hero slideshow ---------------- */

  function initSlides() {
    var slides = document.querySelectorAll('[data-slide]');
    var dots = document.querySelectorAll('[data-dot]');
    if (slides.length < 2) return;

    var current = 0;
    var timer = null;

    function apply() {
      slides.forEach(function (el) {
        el.style.opacity = (parseInt(el.getAttribute('data-slide'), 10) === current) ? '1' : '0';
      });
      dots.forEach(function (el) {
        var on = parseInt(el.getAttribute('data-dot'), 10) === current;
        el.style.width = on ? '26px' : '9px';
        el.style.background = on ? '#2F8B3C' : 'rgba(33,80,60,0.25)';
        el.setAttribute('aria-current', on ? 'true' : 'false');
      });
    }

    function go(i) { current = i; apply(); }

    function restart() {
      if (timer) clearInterval(timer);
      timer = setInterval(function () { go((current + 1) % slides.length); }, 4600);
    }

    dots.forEach(function (d) {
      d.addEventListener('click', function () {
        go(parseInt(d.getAttribute('data-dot'), 10));
        restart();
      });
    });

    apply();
    restart();
  }

  /* ---------------- facility video ---------------- */

  function initVideo() {
    var v = document.getElementById('vka-video');
    var play = document.getElementById('vka-video-play');
    var poster = document.getElementById('vka-video-poster');
    if (!v || !play) return;

    if (poster) poster.style.transition = 'opacity .5s ease';
    play.style.transition = (play.style.transition || '') + ', opacity .5s ease';

    function hidePoster() {
      if (poster) { poster.style.opacity = '0'; poster.style.pointerEvents = 'none'; }
      play.style.opacity = '0';
      play.style.pointerEvents = 'none';
    }

    function showPoster() {
      if (poster) { poster.style.opacity = '1'; poster.style.pointerEvents = ''; }
      play.style.opacity = '1';
      play.style.pointerEvents = '';
    }

    // Resume where the visitor left off.
    var saved = parseFloat(safeGet('vkaVideoTime') || '0');
    if (saved > 0) {
      v.addEventListener('loadedmetadata', function () {
        try { v.currentTime = saved; } catch (e) { /* seek unsupported */ }
      }, { once: true });
    }

    play.addEventListener('click', function () {
      if (!v.src && !v.currentSrc) return;
      v.controls = true;
      hidePoster();
      var p = v.play();
      if (p && p.catch) p.catch(function () { showPoster(); });
    });

    v.addEventListener('timeupdate', function () {
      if (!v.seeking) safeSet('vkaVideoTime', String(v.currentTime));
    });
    v.addEventListener('pause', function () { if (!v.ended) showPoster(); });
    v.addEventListener('play', hidePoster);
  }

  function safeGet(k) { try { return localStorage.getItem(k); } catch (e) { return null; } }
  function safeSet(k, val) { try { localStorage.setItem(k, val); } catch (e) { /* private mode */ } }

  /* ---------------- gallery hover zoom ---------------- */

  function initGallery() {
    document.querySelectorAll('[data-gtile]').forEach(function (tile) {
      var img = tile.querySelector('[data-gimg]');
      if (!img) return;
      tile.addEventListener('mouseenter', function () { img.style.transform = 'scale(1.07)'; });
      tile.addEventListener('mouseleave', function () { img.style.transform = 'scale(1)'; });
    });
  }

  /* ---------------- masonry gallery ----------------
     The columns are built here rather than with CSS multi-column, which
     balances for the shortest total height and so leaves the last column
     empty when there are only a few tall pictures. Filling the shortest
     column each time uses every one of them, and lets "view more" append a
     tile without disturbing anything already placed. */

  function galleryCols() {
    var w = window.innerWidth;
    return w >= 1024 ? 4 : (w >= 620 ? 3 : 2);
  }

  function shortestCol(grid) {
    var cols = grid.querySelectorAll('[data-gcol]');
    var best = cols[0];

    for (var i = 1; i < cols.length; i++) {
      if (cols[i].offsetHeight < best.offsetHeight) best = cols[i];
    }

    return best;
  }

  // Exported for initMore: a tile revealed later joins the shortest column.
  function placeTile(tile) {
    var grid = document.querySelector('[data-gallery][data-built]');
    if (grid) shortestCol(grid).appendChild(tile);
  }

  function buildGallery() {
    var grid = document.querySelector('[data-gallery]');
    if (!grid) return;

    var want = galleryCols();
    if (parseInt(grid.getAttribute('data-built'), 10) === want) return;

    // Hold the tiles in document order before the old columns are torn down.
    var tiles = Array.prototype.slice.call(grid.querySelectorAll('[data-gtile]'));
    grid.textContent = '';
    grid.setAttribute('data-built', want);

    for (var i = 0; i < want; i++) {
      var col = document.createElement('div');
      col.setAttribute('data-gcol', '');
      grid.appendChild(col);
    }

    tiles.forEach(function (tile) {
      // A still-hidden tile measures zero, so park it and let the reveal
      // place it properly once it has a height to balance against.
      if (tile.hasAttribute('data-more-item')) grid.lastChild.appendChild(tile);
      else shortestCol(grid).appendChild(tile);
    });
  }

  /* ---------------- mobile drawer ---------------- */

  function initDrawer() {
    var btn = document.getElementById('vka-burger');
    var drawer = document.getElementById('vka-drawer');
    if (!btn || !drawer) return;

    function close() {
      drawer.classList.remove('is-open');
      btn.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
    }

    btn.addEventListener('click', function () {
      var open = drawer.classList.toggle('is-open');
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      document.body.style.overflow = open ? 'hidden' : '';
    });

    drawer.querySelectorAll('a').forEach(function (a) { a.addEventListener('click', close); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });
    window.addEventListener('resize', function () { if (window.innerWidth >= MOBILE) close(); });
  }

  /* ---------------- measured layout ----------------
     The feature card straddles the hero/video boundary and its overlap depends
     on its own reflowing height, so it has to be measured rather than declared.
     The bento gallery, alternating product rows and footer grid ride along. */

  function applyResponsive() {
    var w = window.innerWidth;
    var wrap = document.querySelector('[data-feat-wrap]');
    var grid = document.querySelector('[data-feat-grid]');
    var items = Array.prototype.slice.call(document.querySelectorAll('[data-feat]'));
    var hero = document.getElementById('hero');
    var video = document.getElementById('video');

    // Alternating product rows are pure CSS now — see [data-prow] in site.css.

    buildGallery();

    // Footer grid: 4-col -> 2-col -> 1-col.
    var fgrid = document.querySelector('[data-fgrid]');
    if (fgrid) {
      fgrid.style.gridTemplateColumns = w >= 900 ? '1.5fr 1fr 1fr 1.3fr' : (w >= 560 ? '1fr 1fr' : '1fr');
    }

    if (!wrap || !grid || !hero || !items.length) return;

    var cols = w >= MOBILE ? 4 : (w >= 620 ? 2 : 1);
    var overlap = w >= MOBILE ? 0.46 : (w >= 620 ? 0.30 : 0.12);
    grid.style.gridTemplateColumns = 'repeat(' + cols + ',1fr)';

    // Dividers: right border within a row, bottom border between rows.
    var rows = Math.ceil(items.length / cols);
    items.forEach(function (el, i) {
      var col = i % cols;
      var row = Math.floor(i / cols);
      el.style.borderRight = (col < cols - 1) ? '1px solid #EEF3EC' : 'none';
      el.style.borderBottom = (row < rows - 1) ? '1px solid #EEF3EC' : 'none';
    });

    // Measure only after the column change has applied.
    var cardH = grid.offsetHeight;
    var protrude = overlap * cardH;
    wrap.style.transform = 'translateY(' + Math.round(protrude) + 'px)';
    hero.style.paddingBottom = Math.round(cardH * (1 - overlap) + Math.min(w * 0.06, 60)) + 'px';
    if (video) video.style.paddingTop = Math.round(protrude + Math.max(w * 0.04, 28)) + 'px';
  }

  /* ---------------- boot ---------------- */

  ready(function () {
    // Before initReveals: a heading that splits is one the reveal observer
    // must not also fade in as a block.
    initSplit();

    initReveals();
    initCounters();
    initParallax();
    initMagnetic();
    initTilt();
    initSlides();
    initVideo();
    initGallery();
    initDrawer();
    initMore();
    initNavSpy();
    initIdleAnimations();
    applyNav();
    applyTopBtn();
    applyResponsive();

    var applyProgress = initProgress();
    applyProgress();

    var top = document.getElementById('vka-top');
    if (top) top.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });

    // One scroll listener, one style write per frame. Previously two separate
    // listeners each ran on every scroll event — which fires far more often
    // than the screen refreshes — and between them read layout and wrote styles
    // several times per frame, forcing repeated layout flushes mid-scroll.
    var scrollQueued = false;

    function onScrollFrame() {
      scrollQueued = false;
      applyNav();
      applyTopBtn();
      applyProgress();
      spy();
    }

    window.addEventListener('scroll', function () {
      if (scrollQueued) return;
      scrollQueued = true;
      requestAnimationFrame(onScrollFrame);
    }, { passive: true });
    window.addEventListener('resize', applyResponsive);

    // Re-measure once fonts and images have settled. The reveal sweep rides
    // along: these are exactly the moments the layout it measured has moved.
    function settle() { applyResponsive(); sweepReveals(); }

    setTimeout(settle, 350);
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(settle);
    window.addEventListener('load', settle);
  });
})();
