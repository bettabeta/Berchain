<?php if (get_field('ecosystem_info') || get_field('ecosystem_items')) : ?>
<div class="ecosystem-section">
  <div class="wrap1720">
    <div class="ecosystem flex v-center">
      <div class="col-6 md-12 md-bottom">
        <div class="info"><?php echo get_field('ecosystem_info'); ?></div>
      </div>
      <div class="col-6 md-12">
        <?php if (
          $ecosystem_items = get_field('ecosystem_items')
        ) { ?>
          <div class="ecosystem-items">
            <?php $duration = 500;
            foreach ($ecosystem_items as $item) { ?>
              <div class="item" data-aos="zoom-in" data-aos-duration="<?php echo $duration += 500; ?>">
                <?php if ($item['number']) : ?>
                  <div class="number"><?php echo esc_html($item['number']); ?></div>
                <?php endif; ?>
                <div class="text"><?php echo $item['text']; ?></div>
                <div class="icon"><?php echo $item['icon']; ?></div>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>