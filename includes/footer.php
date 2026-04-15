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
      <!-- Contact -->
      <div>
        <p class="footer__heading">Contact</p>
        <div class="footer__contact-item">📞 <span>+91 98765 43210</span></div>
        <div class="footer__contact-item">✉️ <span>info@sharmaassociates.in</span></div>
        <div class="footer__contact-item">📍 <span>Connaught Place, New Delhi – 110001</span></div>
      </div>
    </div>
    <div class="footer__bottom">
      <p>&copy; <?= $year ?> <span>Sharma &amp; Associates</span>. All rights reserved.</p>
      <p>Designed with ♥ for our clients.</p>
    </div>
  </div>
</footer>
<script src="/assets/js/main.js"></script>
</body>
</html>
