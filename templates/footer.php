<?php namespace PH7App; ?>

<?php if (Core\Route::isHomepage()): ?>
      <p>MyNewDream is the <strong>simplest web app</strong> that gives a friendly, understandable and <strong>accurate itinerary</strong> that guides you in <strong>starting your new life</strong> (without procrastinating).</p>

    <p>
        The <strong>New Life Itinerary</strong> that you will receive is <strong>made by an expat specialist</strong> (<strong>a human</strong> helped by artificial intelligence tools).<br />
      The Itinerary contains training links to reach your goals (if needed), job positions, best destination(s), best moments for leaving, flight information, visa process (if needed) and tips for your trip and your new life (depending of the situation and your destination).
    </p>
  <?php endif ?>
  </section>

  <footer class="page-footer light-orange">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text"><span class="underline">MyNewDream</span>.eu</h5>
          <p class="grey-text text-lighten-4">
              <a href="<?= site_url() ?>">MyNewDream</a> gives a full TODO-list and Itinerary for a new amazing life elsewhere. It is designed for European people from 18 to 30 years old (mainly from Spain, France, Netherlands, Belgium, Germany and Italy) who want to move and try a new life abroad.
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
              <div class="col l5 s6">
                  With ♥ by <a class="orange-text text-lighten-3" href="http://ph7.me">Pierre-Henry</a>
              </div>
              <div class="col l4 s6">
                  Proud to be <a class="orange-text text-lighten-3" href="https://github.com/pH-7/MyDreamLife.eu">open source</a>
              </div>
              <div class="col l1 s4">
                  <a class="orange-text text-lighten-3" href="<?= site_url('posts') ?>">Posts</a>
              </div>
              <div class="col l1 s4">
                  <a class="orange-text text-lighten-3" rel="nofollow noopener" target="_blank" href="<?php echo site_url('podcast') ?>" title="The Tropical MBA Podcast">Podcast</a>
              </div>
              <div class="col l1 s4">
                  <a class="orange-text text-lighten-3" rel="nofollow" href="mailto:hi@ph7.me?subject=Regarding MyNewDream">Contact</a>
              </div>
          </div>
      </div>
    </div>
  </footer>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="<?php echo site_url('node_modules/materialize-css/dist/js/materialize.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/cookie-bar/1/cookiebar-latest.js"></script>
</body>
</html>