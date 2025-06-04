<div class="news-blocks">
  <div class="wrap">
    <div class="top-news-block flex">
      <div class="text-news-block" data-aos="fade-right">
        <h2><?php echo wp_kses_post(get_field('title_news')); ?> </h2>
        <?php echo wp_kses_post(get_field('text_news')); ?>
      </div>
      <div class="swiper-arrow" data-aos="fade-left">
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>
    </div>
    <div class="swiper">
      <div class="swiper-wrapper">
        <?php $news = new WP_Query(
          array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'orderby' => 'date',
            'posts_per_page' => 10,
          )
        );
        $duration = 500;
        if ($news->have_posts()):
          while ($news->have_posts()):
            $news->the_post(); ?>
            <div class="news-post swiper-slide"  data-aos="fade-up" data-aos-duration="<?php echo $duration +=500;?>">
              <?php if (has_post_thumbnail()) { ?>
                <a class="thumb" href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail(); ?>
                  <span><?php echo get_the_date('Y-m-d'); ?></span>
                </a>
              <?php } else { ?>
                <a class="thumb" href="<?php the_permalink(); ?>">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/def.jpg" alt="">
                  <span><?php echo get_the_date('Y-m-d'); ?></span>
                </a>


              <?php } ?>
              <div class="info">
                <h3><a href="<?php the_permalink(); ?>" style="color:#222222 !important;"><?php the_title(); ?></a></h3>
                <p><?php echo wp_trim_words(get_the_content(), 28, '...'); ?></p>
                <div>
                  <a href="<?php the_permalink(); ?>" class="news-read-more" style="color:#222222;"><span style="color:#222222;">More</span>
                    <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M15.1995 6.50692C15.9822 7.28825 15.9822 8.55648 15.1995 9.33781L9.90063 14.6275C9.59186 14.9357 9.09174 14.9355 8.78324 14.627C8.47454 14.3183 8.47454 13.8178 8.78324 13.5091L12.9558 9.33657C13.7368 8.55553 13.7368 7.2892 12.9558 6.50815L8.78324 2.33562C8.47473 2.02711 8.47451 1.527 8.78275 1.21822C9.09118 0.909259 9.59167 0.908823 9.90063 1.21725L15.1995 6.50692ZM14.0732 6.50815C14.8542 7.28919 14.8542 8.55553 14.0732 9.33657L8.78299 14.6267L14.0811 9.33781C14.8638 8.55648 14.8638 7.28825 14.0811 6.50692L8.78299 1.21798L14.0732 6.50815Z"
                        fill="#0055FE" />
                      <rect x="3" y="7" width="8" height="2" rx="1" fill="#0055FE" />
                      <rect y="7" width="2" height="2" rx="1" fill="#0055FE" />
                    </svg>
                  </a>
                </div>
              </div>

            </div>

          <?php endwhile; endif;
        wp_reset_query(); ?>
      </div>
    </div>
    <a href="/news" class="btn">See all news</a>
  </div>
</div>