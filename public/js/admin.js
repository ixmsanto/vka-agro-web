/* VKA Agro — admin behaviour.
   Field edits autosave (debounced). Images upload by click or drag-and-drop,
   mirroring the design's <image-slot>. Everything degrades to plain form posts
   if this file fails to load. */
(function () {
  'use strict';

  var token = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';

  /* ---------------- toast ---------------- */

  var toastEl = null;
  var toastTimer = null;

  function toast(message, isError) {
    toastEl = toastEl || document.getElementById('a-toast');
    if (!toastEl) return;

    toastEl.textContent = message;
    toastEl.classList.toggle('is-error', !!isError);

    // Restart the CSS animation.
    toastEl.classList.remove('is-visible');
    void toastEl.offsetWidth;
    toastEl.classList.add('is-visible');

    clearTimeout(toastTimer);
    toastTimer = setTimeout(function () { toastEl.classList.remove('is-visible'); }, 1800);
  }

  /* ---------------- autosave ---------------- */

  function payloadFor(el) {
    var field = el.getAttribute('data-field');
    var value = el.value;

    if (el.getAttribute('data-save-style') === 'named') {
      var body = {};
      body[field] = value;
      return body;
    }

    return { field: field, value: value };
  }

  function save(el) {
    var url = el.getAttribute('data-autosave-url');
    var method = (el.getAttribute('data-save-method') || 'PATCH').toUpperCase();

    return fetch(url, {
      method: method,
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': token,
        'X-Requested-With': 'XMLHttpRequest',
      },
      credentials: 'same-origin',
      body: JSON.stringify(payloadFor(el)),
    }).then(function (res) {
      if (res.ok) { toast('All changes saved'); return; }

      if (res.status === 422) {
        return res.json().then(function (data) {
          var first = data && data.errors && Object.keys(data.errors)[0];
          toast(first ? data.errors[first][0] : 'That value was rejected.', true);
        });
      }

      if (res.status === 401 || res.status === 419) {
        toast('Session expired — reloading…', true);
        setTimeout(function () { location.reload(); }, 1200);
        return;
      }

      toast('Could not save (HTTP ' + res.status + ')', true);
    }).catch(function () {
      toast('Could not save — check your connection.', true);
    });
  }

  function initAutosave() {
    var timers = new WeakMap();

    document.querySelectorAll('[data-autosave-url]').forEach(function (el) {
      var immediate = el.tagName === 'SELECT';

      el.addEventListener(immediate ? 'change' : 'input', function () {
        clearTimeout(timers.get(el));
        timers.set(el, setTimeout(function () {
          timers.delete(el);
          save(el);
        }, immediate ? 0 : 550));
      });

      // Don't lose a pending edit when the field loses focus.
      el.addEventListener('blur', function () {
        if (!timers.get(el)) return;
        clearTimeout(timers.get(el));
        timers.delete(el);
        save(el);
      });
    });
  }

  /* ---------------- image / video slots ---------------- */

  function upload(slot, file) {
    var url = slot.getAttribute('data-upload-url');
    var field = slot.getAttribute('data-upload-field') || 'image';

    var body = new FormData();
    body.append(field, file);
    body.append('_token', token);

    slot.classList.remove('is-dragging');
    toast('Uploading…');

    fetch(url, {
      method: 'POST',
      headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest' },
      credentials: 'same-origin',
      body: body,
    }).then(function (res) {
      if (res.ok || res.redirected) { location.reload(); return; }

      if (res.status === 422) {
        return res.json().then(function (data) {
          var first = data && data.errors && Object.keys(data.errors)[0];
          toast(first ? data.errors[first][0] : 'That file was rejected.', true);
        });
      }

      toast('Upload failed (HTTP ' + res.status + ')', true);
    }).catch(function () {
      toast('Upload failed — check your connection.', true);
    });
  }

  function initSlots() {
    document.querySelectorAll('.a-slot[data-upload-url]').forEach(function (slot) {
      var input = slot.querySelector('input[type=file]');

      slot.addEventListener('click', function (e) {
        if (e.target.closest('.a-slot__clear')) return;
        if (input) input.click();
      });

      if (input) {
        input.addEventListener('change', function () {
          if (input.files && input.files[0]) upload(slot, input.files[0]);
        });
      }

      ['dragenter', 'dragover'].forEach(function (type) {
        slot.addEventListener(type, function (e) {
          e.preventDefault();
          slot.classList.add('is-dragging');
        });
      });

      ['dragleave', 'dragend'].forEach(function (type) {
        slot.addEventListener(type, function () { slot.classList.remove('is-dragging'); });
      });

      slot.addEventListener('drop', function (e) {
        e.preventDefault();
        var file = e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files[0];
        if (file) upload(slot, file);
      });
    });
  }

  /* ---------------- destructive confirms ---------------- */

  function initConfirms() {
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
      form.addEventListener('submit', function (e) {
        if (!window.confirm(form.getAttribute('data-confirm'))) e.preventDefault();
      });
    });
  }

  function ready(fn) {
    if (document.readyState !== 'loading') fn();
    else document.addEventListener('DOMContentLoaded', fn);
  }

  ready(function () {
    initAutosave();
    initSlots();
    initConfirms();

    var flash = document.getElementById('a-flash');
    if (flash && flash.dataset.message) toast(flash.dataset.message);
  });
})();
