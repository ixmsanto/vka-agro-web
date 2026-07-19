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

  function ready(fn) {
    if (document.readyState !== 'loading') fn();
    else document.addEventListener('DOMContentLoaded', fn);
  }

  /* ---------------- reveal on scroll ---------------- */

  // Registers one [data-reveal] element with the scroll observer. Assigned by
  // initReveals so rows uncovered later by "view more" can still animate in.
  var addReveal = function () {};

  function initReveals() {
    var revealed = new WeakSet();
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
      el.style.opacity = '1';
      el.style.transform = 'none';
      revealed.add(el);
    }

    addReveal = function (el) {
      if (revealed.has(el)) return;

      var delay = (parseInt(el.getAttribute('data-reveal'), 10) || 0) * 90;
      var ease = 'cubic-bezier(.16,1,.3,1)';
      el.style.transition = 'opacity .9s ' + ease + ' ' + delay + 'ms, transform .9s ' + ease + ' ' + delay + 'ms';

      if (!io) { show(el); return; }

      // Already above the fold on load? Reveal now instead of waiting for a scroll.
      var r = el.getBoundingClientRect();
      if (r.top < (window.innerHeight || 0) && r.bottom > 0) {
        requestAnimationFrame(function () { show(el); });
      } else {
        io.observe(el);
      }
    };

    document.querySelectorAll('[data-reveal]').forEach(addReveal);
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

  function applyNav() {
    var nav = document.getElementById('vka-nav');
    if (!nav) return;

    var scrolled = window.scrollY > 40;
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
    btn.style.opacity = show ? '1' : '0';
    btn.style.transform = show ? 'translateY(0) scale(1)' : 'translateY(16px) scale(0.8)';
    btn.style.pointerEvents = show ? 'auto' : 'none';
  }

  /* ---------------- mouse parallax ---------------- */

  function initParallax() {
    var nodes = document.querySelectorAll('[data-parallax]');
    if (!nodes.length) return;
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    var raf = null, px = 0, py = 0;

    window.addEventListener('mousemove', function (e) {
      if (window.innerWidth < MOBILE) return;
      px = (e.clientX / window.innerWidth) - 0.5;
      py = (e.clientY / window.innerHeight) - 0.5;
      if (raf) return;

      raf = requestAnimationFrame(function () {
        raf = null;
        nodes.forEach(function (el) {
          var d = parseFloat(el.getAttribute('data-depth')) || 1;
          el.style.transition = 'transform .5s cubic-bezier(.16,1,.3,1)';
          el.style.transform = 'translate(' + (px * -18 * d) + 'px,' + (py * -14 * d) + 'px)';
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
    initReveals();
    initParallax();
    initSlides();
    initVideo();
    initGallery();
    initDrawer();
    initMore();
    applyNav();
    applyTopBtn();
    applyResponsive();

    var top = document.getElementById('vka-top');
    if (top) top.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });

    window.addEventListener('scroll', function () { applyNav(); applyTopBtn(); }, { passive: true });
    window.addEventListener('resize', applyResponsive);

    // Re-measure once fonts and images have settled.
    setTimeout(applyResponsive, 350);
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(applyResponsive);
    window.addEventListener('load', applyResponsive);
  });
})();
