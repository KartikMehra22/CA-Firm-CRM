<?php
/**
 * Public site footer.
 */
$year = date('Y');
?>
<footer class="footer" role="contentinfo">
  <div class="container">
    <div class="footer__grid">
      <!-- Brand -->
      <div>
        <p class="footer__brand-name">Sharma &amp; Associates</p>
        <p class="footer__brand-desc">
          A full-service Chartered Accountancy firm providing trusted financial
          guidance to individuals and businesses since 2005.
        </p>
      </div>
      <!-- Quick Links -->
      <div>
        <p class="footer__heading">Quick Links</p>
        <ul class="footer__links">
          <li><a href="/#home"     class="footer__link">Home</a></li>
          <li><a href="/#services" class="footer__link">Our Services</a></li>
          <li><a href="/#about"    class="footer__link">About Us</a></li>
          <li><a href="/#contact"  class="footer__link">Contact Us</a></li>
        </ul>
      </div>
      <div class="footer__section">
      <h3 class="footer__title">Quick Contact</h3>
      <div class="footer__contact">
        <div class="footer__contact-item"><i data-lucide="phone"></i> <span>+91 98765 43210</span></div>
        <div class="footer__contact-item"><i data-lucide="mail"></i> <span>info@sharmaassociates.in</span></div>
        <div class="footer__contact-item"><i data-lucide="map-pin"></i> <span>Connaught Place, New Delhi – 110001</span></div>
      </div>
    </div>
    <div class="footer__bottom-text">
      <p>&copy; <?= date('Y') ?> Sharma &amp; Associates. All rights reserved.</p>
      <p>Designed with <i data-lucide="heart" style="color:#ef4444;fill:#ef4444;width:0.9em;height:0.9em;"></i> for our clients.</p>
    </div>
  </div>
</footer>
<script src="/assets/js/main.js"></script>
</body>
</html>
