<?php
get_header();

if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="single-event wrap" style="max-width: 1280px; margin: 3rem auto;">
  <article style="background:#fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
    <h1><?php the_title(); ?></h1>

    <?php if (has_post_thumbnail()) : ?>
      <div style="margin: 1.5rem 0;">
        <?php the_post_thumbnail('large', ['style' => 'border-radius:12px; max-width:100%; height:auto;']); ?>
      </div>
    <?php endif; ?>

    <div style="margin-bottom: 1.5rem;">
      <?php
        $event_start = get_field('event_start');
        $event_end = get_field('event_end');
        $location = get_field('event_location');
      ?>
      <?php if ($event_start): ?>
        <p><strong>Datum:</strong> <?php echo date_i18n("l, j. F Y, H:i", strtotime($event_start)); ?>
        <?php if ($event_end): ?>
         – <?php echo date_i18n("H:i", strtotime($event_end)); ?>
        <?php endif; ?>
        </p>
      <?php endif; ?>

      <?php if ($location): ?>
        <p>
          <strong>Ort:</strong> <?php echo esc_html($location); ?><br>
          <a target="_blank" style="color:#0055FE;text-decoration:underline;" href="https://www.google.com/maps/search/<?php echo urlencode($location); ?>">
            Open in Google Maps
          </a>
        </p>
      <?php endif; ?>
    </div>

    <div class="event-content" style="line-height:1.6;">
      <?php the_content(); ?>
    </div>
  </article>
</div>

<div class="related-events events-slider-wrap" style="background: #fff;">
  <div class="wrap" style="max-width: 1280px; margin: 0 auto;">
    <div class="title-wrap" style="margin-top: 3rem;">
      <div class="eventtitle"><h2>Weitere kommende Events</h2></div>
    </div>

    <div class="swiper upcoming-swiper slider-fade-right">
      <div class="swiper-wrapper">
        <?php
        $upcoming = new WP_Query(array(
          'post_type' => 'event',
          'posts_per_page' => 6,
          'post__not_in' => array(get_the_ID()),
          'meta_key' => 'event_start',
          'orderby' => 'meta_value',
          'order' => 'ASC',
          'meta_query' => array(
            array(
              'key' => 'event_start',
              'value' => current_time('Y-m-d H:i:s'),
              'compare' => '>=',
              'type' => 'DATETIME'
            )
          )
        ));
        if ($upcoming->have_posts()) :
          while ($upcoming->have_posts()) : $upcoming->the_post();
            $event_start = get_field('event_start');
            $location = get_field('event_location');
        ?>
        <div class="event-post swiper-slide">
          <a href="<?php the_permalink(); ?>" class="full-link" style="display:flex;flex-direction:column;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.05);text-decoration:none;color:inherit;height:100%;">
            <?php if (has_post_thumbnail()) {
              the_post_thumbnail('medium');
            } else { ?>
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/def.jpg" alt="">
            <?php } ?>
            <div class="info" style="padding:1rem;">
              <h3 style="font-size:1.1rem;margin:0 0 0.25rem;"><?php the_title(); ?></h3>
              <?php if ($event_start): ?>
                <div class="meta" style="font-size:0.85rem;color:#333;"><?php echo date_i18n("j. F Y, H:i", strtotime($event_start)); ?></div>
              <?php endif; ?>
              <?php if ($location): ?>
                <div class="meta" style="font-size:0.85rem;color:#333;"><?php echo esc_html($location); ?></div>
              <?php endif; ?>
            </div>
          </a>
        </div>
        <?php endwhile; endif; wp_reset_postdata(); ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</div>

<style>
/* Unified slide/card styling */
.event-post.swiper-slide {
  display: flex;
  flex-direction: column;
  overflow: hidden; /* prevent scrollbars */
}

.event-post .info {
  padding: 1rem;
  overflow: hidden; /* remove inner scrollbars */
  flex-grow: 1;
}

.event-post .info h3 {
  font-size: 1.1rem;
  margin: 0 0 0.2rem; /* tighter spacing */
}

.event-post .meta {
  font-size: 0.85rem;
  color: #333;
  margin: 0.1rem 0;
}

/* Image styling to fit container and avoid overflow */
.event-post img {
  width: 100%;
  height: auto;
  display: block;
  border-radius: 0;
}

/* Prevent any accidental scrollbars */
.swiper-slide,
.event-post,
.full-link {
  overflow: hidden !important;
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
  if (typeof Swiper !== 'undefined') {
    new Swiper('.upcoming-swiper', {
      slidesPerView: 'auto',
      spaceBetween: 24,
      pagination: {
        el: '.upcoming-swiper .swiper-pagination',
        clickable: true
      },
      breakpoints: {
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 3 }
      }
    });
  }
});
</script>

<?php endwhile; endif;
get_footer(); ?>
