(function () {
  'use strict';

  /* ── Mobile Nav ───────────────────────────────────────────── */
  const navToggle = document.getElementById('nav-toggle');
  const mainNav   = document.getElementById('main-nav');

  if (navToggle && mainNav) {
    navToggle.addEventListener('click', function () {
      const open = mainNav.classList.toggle('open');
      navToggle.classList.toggle('open', open);
      navToggle.setAttribute('aria-expanded', String(open));
      document.body.style.overflow = open ? 'hidden' : '';
    });

    // Close on outside click
    document.addEventListener('click', function (e) {
      if (!mainNav.contains(e.target) && !navToggle.contains(e.target)) {
        mainNav.classList.remove('open');
        navToggle.classList.remove('open');
        navToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      }
    });
  }

  /* ── Search Toggle ────────────────────────────────────────── */
  const searchToggle = document.getElementById('search-toggle');
  const searchClose  = document.getElementById('search-close');
  const searchBar    = document.getElementById('search-bar');

  if (searchToggle && searchBar) {
    searchToggle.addEventListener('click', function () {
      searchBar.hidden = !searchBar.hidden;
      if (!searchBar.hidden) {
        const input = searchBar.querySelector('input[type="search"]');
        if (input) input.focus();
      }
    });
  }

  if (searchClose && searchBar) {
    searchClose.addEventListener('click', function () {
      searchBar.hidden = true;
    });
  }

  // Close search on Escape
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && searchBar && !searchBar.hidden) {
      searchBar.hidden = true;
    }
  });

  /* ── Sticky Header Shadow ─────────────────────────────────── */
  const header = document.getElementById('site-header');
  if (header) {
    const onScroll = function () {
      header.style.boxShadow = window.scrollY > 10
        ? '0 2px 20px rgba(0,0,0,.08)'
        : 'none';
    };
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /* ── Scroll-reveal cards ──────────────────────────────────── */
  if ('IntersectionObserver' in window) {
    const cards = document.querySelectorAll('.ca-card, .feature-card, .testimonial-card, .category-chip');

    cards.forEach(function (el) {
      el.style.opacity  = '0';
      el.style.transform = 'translateY(20px)';
      el.style.transition = 'opacity .4s ease, transform .4s ease';
    });

    const observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.style.opacity   = '1';
          entry.target.style.transform = 'translateY(0)';
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    cards.forEach(function (el) { observer.observe(el); });
  }

  /* ── Smooth Scroll ────────────────────────────────────────── */
  document.querySelectorAll('a[href^="#"]').forEach(function (link) {
    link.addEventListener('click', function (e) {
      const target = document.querySelector(link.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  /* ── Contact Form Validation ──────────────────────────────── */
  const contactForm = document.querySelector('.ca-contact-form');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      const email = contactForm.querySelector('#contact_email');
      if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        e.preventDefault();
        email.focus();
        email.style.borderColor = '#EF4444';
        email.style.boxShadow   = '0 0 0 3px rgba(239,68,68,.15)';
      }
    });
  }

  /* ── Newsletter Form ──────────────────────────────────────── */
  document.querySelectorAll('.ca-newsletter-form, .footer-nl-form').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      const btn = form.querySelector('button[type="submit"]');
      if (btn) {
        btn.disabled     = true;
        btn.textContent  = '...';
      }
    });
  });

})();
