/* ============================================================
   CA Firm CRM — Main JavaScript
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {

  /* ── Mobile Nav Toggle (Public) ──────────────────────────── */
  const toggle = document.getElementById('navToggle');
  const nav = document.getElementById('navMenu');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      this.classList.toggle('open');
      nav.classList.toggle('open');
    });
    // Close on link click
    nav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        toggle.classList.remove('open');
        nav.classList.remove('open');
      });
    });
  }

  /* ── Admin Sidebar Toggle (Mobile) ──────────────────────── */
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('adminSidebar');
  const sidebarOverlay = document.getElementById('sidebarOverlay');
  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', function () {
      sidebar.classList.toggle('open');
      if (sidebarOverlay) sidebarOverlay.classList.toggle('visible');
    });
    if (sidebarOverlay) {
      sidebarOverlay.addEventListener('click', function () {
        sidebar.classList.remove('open');
        this.classList.remove('visible');
      });
    }
  }

  /* ── Auto-dismiss Flash Messages ────────────────────────── */
  document.querySelectorAll('.flash, .admin-flash').forEach(function (el) {
    setTimeout(function () {
      el.style.transition = 'opacity .4s ease, transform .4s ease';
      el.style.opacity = '0';
      el.style.transform = 'translateY(-8px)';
      setTimeout(function () { el.remove(); }, 450);
    }, 4500);
  });
  // Manual close button
  document.querySelectorAll('.flash__close').forEach(function (btn) {
    btn.addEventListener('click', function () {
      this.closest('.flash').remove();
    });
  });

  /* ── Client-side Form Validation (Public Inquiry Form) ───── */
  const inquiryForm = document.getElementById('inquiryForm');
  if (inquiryForm) {
    inquiryForm.addEventListener('submit', function (e) {
      let valid = true;
      inquiryForm.querySelectorAll('[required]').forEach(function (field) {
        field.classList.remove('is-invalid');
        if (!field.value.trim()) {
          field.classList.add('is-invalid');
          valid = false;
        }
      });
      // Email check
      const emailField = inquiryForm.querySelector('[name="email"]');
      if (emailField && emailField.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailField.value)) {
        emailField.classList.add('is-invalid');
        valid = false;
      }
      // Mobile check (10-digit Indian number)
      const mobileField = inquiryForm.querySelector('[name="mobile"]');
      if (mobileField && mobileField.value && !/^[6-9]\d{9}$/.test(mobileField.value)) {
        mobileField.classList.add('is-invalid');
        valid = false;
      }
      // Message minimum 10 characters
      const msgField = inquiryForm.querySelector('[name="message"]');
      if (msgField && msgField.value.trim().length < 10) {
        msgField.classList.add('is-invalid');
        valid = false;
      }
      if (!valid) e.preventDefault();
    });
    // Live clear invalid on input
    inquiryForm.querySelectorAll('.form-control').forEach(function (field) {
      field.addEventListener('input', function () { this.classList.remove('is-invalid'); });
    });
  }

  /* ── Smooth scroll for anchor links ────────────────────── */
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        const offset = 72;
        const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
        window.scrollTo({ top: top, behavior: 'smooth' });
      }
    });
  });

  /* ── Topbar — live date/time ────────────────────────────── */
  const dateEl = document.getElementById('topbarDate');
  if (dateEl) {
    function updateDate() {
      const now = new Date();
      dateEl.textContent = now.toLocaleDateString('en-IN', {
        weekday: 'short', day: 'numeric', month: 'short', year: 'numeric'
      });
    }
    updateDate();
    setInterval(updateDate, 60000);
  }

  /* ── Lucide Icon Initialization ──────────────────────────── */
  if (typeof lucide !== 'undefined') {
    lucide.createIcons();
  }

});
