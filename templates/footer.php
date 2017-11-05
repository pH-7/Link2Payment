<?php namespace PH7App; ?>

<?php if (!Core\Route::isStripePage()): ?>
  </section>

  <footer class="page-footer light-orange">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">Link<span class="underline">2</span>Payment</h5>
          <p class="grey-text text-lighten-4">

          </p>
        </div>
        <div class="col l3 s12">
            <!-- Text Block -->
        </div>
        <div class="col l3 s12">
            <!-- Text Block -->
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
          <div class="row">
              <div class="col l9 s12">
                  Proud to be an <a class="orange-text text-lighten-3" href="https://github.com/pH-7/Link2Payment">open source</a> project
              </div>
              <div class="col l3 s12">
                  <a class="orange-text text-lighten-3" rel="nofollow" href="mailto:<?= getenv('ADMIN_EMAIL') ?>?subject=Regarding Link2Payment">Contact</a>
              </div>
          </div>
      </div>
    </div>
<?php endif ?>
  </footer>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="<?php echo site_url('node_modules/materialize-css/dist/js/materialize.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/cookie-bar/1/cookiebar-latest.js"></script>
    <script>
        $(document).ready(function() {
            $('select').material_select();

        });
    </script>
</body>
</html>