<?php
/**
 * admin/includes/admin_footer.php
 * Closes the main content, layout divs, and body/html.
 */
?>
    </main><!-- /.page-content -->
  </div><!-- /.main-content -->
</div><!-- /.admin-layout -->

<script src="/assets/js/main.js"></script>
<script>
  // Sidebar mobile toggle via JS
  (function () {
    var toggle  = document.getElementById('sidebarToggle');
    var sidebar = document.getElementById('adminSidebar');
    var overlay = document.getElementById('sidebarOverlay');
    if (!toggle) return;
    toggle.addEventListener('click', function () {
      var open = sidebar.classList.toggle('open');
      this.setAttribute('aria-expanded', open);
      overlay.style.display = open ? 'block' : 'none';
    });
  })();
</script>
</body>
</html>
