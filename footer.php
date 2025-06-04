<footer>
  <div class="wrap-large wrapper-footer">
    <div class="wrap footer-content">

      <!-- Linkes Logo + Copyright -->
      <div class="first-column">
        <a href="<?php echo site_url(); ?>/" id="logo-footer">
          <?php $logo = get_field('logo', 'option'); ?>
          <?php if ($logo): ?>
            <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt'] ?: 'Logo'); ?>">
          <?php endif; ?>
        </a>

        <div class="copyright">
          &copy; <?php echo date("Y"); ?> BerChain. All Rights Reserved
        </div>

        <!-- Linke Footer-Navigation (Imprint etc.) -->
        <?php
        wp_nav_menu(array(
          'theme_location' => 'second_menu',
          'container' => false,
          'depth' => 1
        ));
        ?>
      </div>

      <!-- Optional: Social Icons -->
      <div class="s-link">
        <?php get_template_part('components/social', 'icons'); ?>
      </div>

    </div>
  </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
