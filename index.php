<?php
// Read back form data saved by submit_inquiry.php on validation failure
// Lets us repopulate the form so the user doesn't lose what they typed
if (session_status() === PHP_SESSION_NONE)
  session_start();
$fd = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_data']);

$page_title = 'Sharma &amp; Associates | Chartered Accountants &amp; Tax Consultants';
require_once 'includes/header.php';
?>

<!-- ══ HERO ══════════════════════════════════════════════ -->
<section class="hero" id="home">
  <div class="container hero__inner">
    <div class="hero__content">
      <p class="hero__label">Trusted Since 2005</p>
      <h1 class="hero__title">
        Your Trusted<br>
        <span>Financial &amp; Tax</span><br>
        Advisors
      </h1>
      <p class="hero__desc">
        Sharma &amp; Associates delivers expert Chartered Accountancy services — from
        Income Tax and GST to Audit and Business Advisory — helping you stay
        compliant and financially secure.
      </p>
      <div class="hero__actions">
        <a href="#contact" class="btn btn--gold">📋 Get Free Consultation</a>
        <a href="#services" class="btn btn--outline">Explore Services</a>
      </div>
    </div>

    <div class="hero__card" aria-hidden="true">
      <div class="hero__stats">
        <div>
          <p class="hero__stat-num">20+</p>
          <p class="hero__stat-label">Years of Experience</p>
        </div>
        <div>
          <p class="hero__stat-num">1,500+</p>
          <p class="hero__stat-label">Clients Served</p>
        </div>
        <div>
          <p class="hero__stat-num">₹200Cr+</p>
          <p class="hero__stat-label">Tax Filed</p>
        </div>
      </div>
      <div class="hero__divider"></div>
      <p class="hero__trust">Trusted by businesses across India</p>
      <div style="display:flex; gap:.5rem; flex-wrap:wrap;">
        <span
          style="background:rgba(255,255,255,.12);color:rgba(255,255,255,.7);font-size:.75rem;padding:.3rem .7rem;border-radius:20px;">✓
          GST Compliant</span>
        <span
          style="background:rgba(255,255,255,.12);color:rgba(255,255,255,.7);font-size:.75rem;padding:.3rem .7rem;border-radius:20px;">✓
          ICAI Registered</span>
        <span
          style="background:rgba(255,255,255,.12);color:rgba(255,255,255,.7);font-size:.75rem;padding:.3rem .7rem;border-radius:20px;">✓
          ISO Certified</span>
      </div>
    </div>
  </div>
</section>

<!-- ══ SERVICES ══════════════════════════════════════════ -->
<section class="services section-pad" id="services">
  <div class="container text-center">
    <span class="section-label">What We Do</span>
    <h2 class="section-title">Our Expert Services</h2>
    <p class="section-sub">Comprehensive financial services tailored for individuals, startups &amp; enterprises.</p>
  </div>

  <div class="container">
    <div class="services__grid">

      <article class="service-card">
        <div class="service-card__icon" style="background:linear-gradient(135deg,#e3f2fd,#bbdefb)">📊</div>
        <h3 class="service-card__title">Income Tax Filing</h3>
        <p class="service-card__desc">Accurate and timely ITR preparation for individuals, firms, and corporates. We
          ensure maximum deductions and full compliance.</p>
        <a href="#contact" class="service-card__link">Get Started →</a>
      </article>

      <article class="service-card">
        <div class="service-card__icon" style="background:linear-gradient(135deg,#fff8e1,#ffe082)">🧾</div>
        <h3 class="service-card__title">GST Registration &amp; Returns</h3>
        <p class="service-card__desc">End-to-end GST solutions — registration, monthly/quarterly returns,
          reconciliation, and GST audit support.</p>
        <a href="#contact" class="service-card__link">Get Started →</a>
      </article>

      <article class="service-card">
        <div class="service-card__icon" style="background:linear-gradient(135deg,#e8f5e9,#a5d6a7)">🏢</div>
        <h3 class="service-card__title">Company Registration</h3>
        <p class="service-card__desc">Pvt Ltd, LLP, OPC — we handle end-to-end incorporation, MCA filings, and ROC
          compliance for your business.</p>
        <a href="#contact" class="service-card__link">Get Started →</a>
      </article>

      <article class="service-card">
        <div class="service-card__icon" style="background:linear-gradient(135deg,#fce4ec,#f48fb1)">🔍</div>
        <h3 class="service-card__title">Audit &amp; Assurance</h3>
        <p class="service-card__desc">Statutory, tax, internal and concurrent audits conducted with precision to
          maintain transparency and build stakeholder confidence.</p>
        <a href="#contact" class="service-card__link">Get Started →</a>
      </article>

      <article class="service-card">
        <div class="service-card__icon" style="background:linear-gradient(135deg,#f3e5f5,#ce93d8)">📈</div>
        <h3 class="service-card__title">Business Advisory</h3>
        <p class="service-card__desc">Strategic financial consulting — business valuation, investment planning,
          cash-flow management, and growth strategy.</p>
        <a href="#contact" class="service-card__link">Get Started →</a>
      </article>

      <article class="service-card">
        <div class="service-card__icon" style="background:linear-gradient(135deg,#e0f7fa,#80deea)">⚖️</div>
        <h3 class="service-card__title">Tax Planning &amp; Advisory</h3>
        <p class="service-card__desc">Proactive, legal tax optimisation strategies for HNIs and businesses to reduce tax
          burden while staying fully compliant.</p>
        <a href="#contact" class="service-card__link">Get Started →</a>
      </article>

    </div>
  </div>
</section>

<!-- ══ WHY US ══════════════════════════════════════════════ -->
<section class="why section-pad" id="about">
  <div class="container">
    <div class="why__grid">

      <div>
        <span class="section-label">Why Choose Us</span>
        <h2 class="section-title" style="margin-bottom:2rem;">20 Years of Excellence<br>in Financial Advisory</h2>
        <div class="why__list">
          <div class="why__item">
            <div class="why__dot" aria-hidden="true">✓</div>
            <div>
              <p class="why__item-title">Certified &amp; Experienced Team</p>
              <p class="why__item-desc">All our CAs are ICAI registered with 10+ years of hands-on client experience
                across industries.</p>
            </div>
          </div>
          <div class="why__item">
            <div class="why__dot" aria-hidden="true">🔒</div>
            <div>
              <p class="why__item-title">Confidentiality Assured</p>
              <p class="why__item-desc">Your financial data is always handled with strict confidentiality protocols and
                NDAs.</p>
            </div>
          </div>
          <div class="why__item">
            <div class="why__dot" aria-hidden="true">⚡</div>
            <div>
              <p class="why__item-title">Fast &amp; Deadline-Driven</p>
              <p class="why__item-desc">We track every deadline and deliver on time — no penalties, no last-minute
                stress for our clients.</p>
            </div>
          </div>
          <div class="why__item">
            <div class="why__dot" aria-hidden="true">💬</div>
            <div>
              <p class="why__item-title">Dedicated Relationship Manager</p>
              <p class="why__item-desc">Every client gets a dedicated CA as a single point of contact for all their
                financial needs.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="why__image">
        <div class="why__image-placeholder" style="position:relative;">
          <div style="font-size:4rem;margin-bottom:1rem;">🏛️</div>
          <p style="font-family:'Playfair Display',serif;font-size:1.5rem;margin-bottom:.75rem;">Trusted by 1,500+
            Clients</p>
          <p style="color:rgba(255,255,255,.6);font-size:.875rem;line-height:1.6;">From individual taxpayers to Fortune
            500 subsidiaries — we've built lasting partnerships across India.</p>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-top:2rem;">
            <div style="background:rgba(255,255,255,.1);border-radius:10px;padding:1rem;text-align:center;">
              <p style="font-size:1.6rem;font-weight:700;color:#c9a84c;">98%</p>
              <p style="font-size:.78rem;color:rgba(255,255,255,.6);">Client Retention Rate</p>
            </div>
            <div style="background:rgba(255,255,255,.1);border-radius:10px;padding:1rem;text-align:center;">
              <p style="font-size:1.6rem;font-weight:700;color:#c9a84c;">100%</p>
              <p style="font-size:.78rem;color:rgba(255,255,255,.6);">On-time Filing Record</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ══ INQUIRY FORM ══════════════════════════════════════ -->
<section class="inquiry-section section-pad" id="contact">
  <div class="container text-center" style="position:relative;z-index:1;">
    <span class="section-label text-gold">Free Consultation</span>
    <h2 class="section-title" style="color:#fff;">Get in Touch With Our Experts</h2>
    <p class="section-sub">Fill in the form below and our team will reach out within 24 hours.</p>

    <form class="inquiry-form" id="inquiryForm" method="POST" action="/submit_inquiry.php" novalidate>

      <!-- Honeypot: hidden from real users via CSS/aria, bots fill it automatically -->
      <input type="text" name="website" value="" style="position:absolute;left:-9999px;opacity:0;height:0;width:0;"
        tabindex="-1" autocomplete="off" aria-hidden="true">
      <div class="form-grid">

        <div class="form-group">
          <label class="form-label" for="full_name">Full Name <span style="color:#ef5350">*</span></label>
          <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Rajesh Kumar"
            maxlength="255" required autocomplete="name" value="<?= htmlspecialchars($fd['full_name'] ?? '') ?>">
          <span class="form-feedback">Please enter your full name.</span>
        </div>

        <div class="form-group">
          <label class="form-label" for="email">Email Address <span style="color:#ef5350">*</span></label>
          <input type="email" id="email" name="email" class="form-control" placeholder="rajesh@example.com"
            maxlength="255" required autocomplete="email" value="<?= htmlspecialchars($fd['email'] ?? '') ?>">
          <span class="form-feedback">Please enter a valid email address.</span>
        </div>

        <div class="form-group">
          <label class="form-label" for="mobile">Mobile Number <span style="color:#ef5350">*</span></label>
          <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="9876543210"
            pattern="[6-9][0-9]{9}" maxlength="10" required autocomplete="tel"
            value="<?= htmlspecialchars($fd['mobile'] ?? '') ?>">
          <span class="form-feedback">Enter a valid 10-digit Indian mobile number.</span>
        </div>

        <div class="form-group">
          <label class="form-label" for="city">City <span style="color:#ef5350">*</span></label>
          <input type="text" id="city" name="city" class="form-control" placeholder="New Delhi" maxlength="100" required
            autocomplete="address-level2" value="<?= htmlspecialchars($fd['city'] ?? '') ?>">
          <span class="form-feedback">Please enter your city.</span>
        </div>

        <div class="form-group form-group--full">
          <label class="form-label" for="service">Service Required <span style="color:#ef5350">*</span></label>
          <?php $sel = $fd['service'] ?? ''; ?>
          <select id="service" name="service" class="form-control" required>
            <option value="" disabled <?= $sel === '' ? 'selected' : '' ?>>— Select a service —</option>
            <option value="Income Tax Filing" <?= $sel === 'Income Tax Filing' ? 'selected' : '' ?>>Income Tax Filing
            </option>
            <option value="GST Registration & Returns" <?= $sel === 'GST Registration & Returns' ? 'selected' : '' ?>>GST
              Registration &amp; Returns</option>
            <option value="Company Registration" <?= $sel === 'Company Registration' ? 'selected' : '' ?>>Company
              Registration</option>
            <option value="Audit & Assurance" <?= $sel === 'Audit & Assurance' ? 'selected' : '' ?>>Audit &amp; Assurance
            </option>
            <option value="Business Advisory" <?= $sel === 'Business Advisory' ? 'selected' : '' ?>>Business Advisory
            </option>
            <option value="Tax Planning & Advisory" <?= $sel === 'Tax Planning & Advisory' ? 'selected' : '' ?>>Tax
              Planning &amp; Advisory</option>
            <option value="Other" <?= $sel === 'Other' ? 'selected' : '' ?>>Other</option>
          </select>
          <span class="form-feedback">Please select a service.</span>
        </div>

        <div class="form-group form-group--full">
          <label class="form-label" for="message">Your Message <span style="color:#ef5350">*</span></label>
          <textarea id="message" name="message" class="form-control"
            placeholder="Briefly describe your requirement so we can prepare better..." rows="4" maxlength="2000"
            required><?= htmlspecialchars($fd['message'] ?? '') ?></textarea>
          <span class="form-feedback">Message must be at least 10 characters.</span>
        </div>

      </div>

      <div class="form-submit">
        <button type="submit" class="btn btn--navy" id="submitBtn">
          Submit Inquiry ➜
        </button>
      </div>
    </form>
  </div>
</section>

<!-- ══ TESTIMONIALS ════════════════════════════ -->
<section class="services section-pad" style="background:var(--white);" id="testimonials">
  <div class="container text-center">
    <span class="section-label">Client Words</span>
    <h2 class="section-title">What Our Clients Say</h2>
    <p class="section-sub">Over 1,500 clients trust us for their financial needs every year.</p>
  </div>
  <div class="container">
    <div class="services__grid" style="margin-top:2.5rem;">

      <article class="service-card" style="text-align:left;">
        <div style="display:flex;gap:.25rem;margin-bottom:1rem;color:#f59e0b;font-size:1rem;">★★★★★</div>
        <p style="font-size:.9rem;color:var(--text-muted);line-height:1.7;margin-bottom:1.25rem;">
          &ldquo;Sharma &amp; Associates handled our GST registration and monthly returns seamlessly.
          Extremely professional and always available for queries.&rdquo;
        </p>
        <div style="display:flex;align-items:center;gap:.75rem;">
          <div
            style="width:40px;height:40px;border-radius:50%;background:var(--navy);color:var(--gold);display:grid;place-items:center;font-weight:700;flex-shrink:0;">
            RK</div>
          <div>
            <p style="font-weight:600;font-size:.9rem;">Rajesh Kumar</p>
            <p style="font-size:.78rem;color:var(--text-muted);">Director, Kumar Exports Pvt. Ltd.</p>
          </div>
        </div>
      </article>

      <article class="service-card" style="text-align:left;">
        <div style="display:flex;gap:.25rem;margin-bottom:1rem;color:#f59e0b;font-size:1rem;">★★★★★</div>
        <p style="font-size:.9rem;color:var(--text-muted);line-height:1.7;margin-bottom:1.25rem;">
          &ldquo;Filed my ITR for the last 5 years with them. They always find deductions I wasn\'t even
          aware of. Saved me lakhs in taxes legally.&rdquo;
        </p>
        <div style="display:flex;align-items:center;gap:.75rem;">
          <div
            style="width:40px;height:40px;border-radius:50%;background:var(--navy);color:var(--gold);display:grid;place-items:center;font-weight:700;flex-shrink:0;">
            PS</div>
          <div>
            <p style="font-weight:600;font-size:.9rem;">Priya Sharma</p>
            <p style="font-size:.78rem;color:var(--text-muted);">Software Engineer &amp; HNI Taxpayer</p>
          </div>
        </div>
      </article>

      <article class="service-card" style="text-align:left;">
        <div style="display:flex;gap:.25rem;margin-bottom:1rem;color:#f59e0b;font-size:1rem;">★★★★★</div>
        <p style="font-size:.9rem;color:var(--text-muted);line-height:1.7;margin-bottom:1.25rem;">
          &ldquo;Got our startup incorporated in just 4 days. The team handled all MCA filings and
          compliance from day one. Highly recommended for new businesses.&rdquo;
        </p>
        <div style="display:flex;align-items:center;gap:.75rem;">
          <div
            style="width:40px;height:40px;border-radius:50%;background:var(--navy);color:var(--gold);display:grid;place-items:center;font-weight:700;flex-shrink:0;">
            AM</div>
          <div>
            <p style="font-weight:600;font-size:.9rem;">Arjun Mehta</p>
            <p style="font-size:.78rem;color:var(--text-muted);">Co-Founder, FinVista Technologies</p>
          </div>
        </div>
      </article>

    </div>
  </div>
</section>



<!-- Animated counter script for hero numbers -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var counters = document.querySelectorAll('.hero__stat-num');
    if (!counters.length) return;

    var targets = [20, 1500, 200]; // matching the hero stats order
    var suffixes = ['+', '+', 'Cr+'];
    var prefixes = ['', '', '₹'];
    var started = false;

    function animateCounter(el, target, prefix, suffix, duration) {
      var start = 0;
      var step = target / (duration / 16);
      var timer = setInterval(function () {
        start += step;
        if (start >= target) {
          el.textContent = prefix + target.toLocaleString('en-IN') + suffix;
          clearInterval(timer);
        } else {
          el.textContent = prefix + Math.floor(start).toLocaleString('en-IN') + suffix;
        }
      }, 16);
    }

    // Only start when the hero section is in view
    var hero = document.querySelector('.hero');
    if (!hero || !window.IntersectionObserver) {
      // Fallback: just set the text directly
      counters.forEach(function (el, i) {
        el.textContent = prefixes[i] + targets[i].toLocaleString('en-IN') + suffixes[i];
      });
      return;
    }

    var observer = new IntersectionObserver(function (entries) {
      if (entries[0].isIntersecting && !started) {
        started = true;
        counters.forEach(function (el, i) {
          animateCounter(el, targets[i], prefixes[i], suffixes[i], 1800);
        });
      }
    }, { threshold: 0.3 });

    observer.observe(hero);
  });
</script>

<?php require_once 'includes/footer.php'; ?>