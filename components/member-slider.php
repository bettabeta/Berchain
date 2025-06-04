<?php if ($variable = get_field('members_items', '176')) : ?>
<div class="members-slider">  <!-- Zurück zu members-slider -->
    <div class="wrap1720">
        <div class="content-box">
            <?php if (get_field('members_info')) : ?>
            <div class="members-info" data-aos-duration="2000" data-aos="fade-right">  <!-- Zurück zu members-info -->
                <?php echo get_field('members_info') ?>
            </div>
            <?php endif; ?>
            <div class="swiper" data-aos="zoom-out" data-aos-duration="2000">
                <div class="swiper-wrapper">
                    <?php foreach ($variable as $item) { 
                        if (!empty($item['image']) && !empty($item['link'])) : ?>
                        <div class="swiper-slide">
                            <div class="item logo-item-v">
                                <a class="link-logo" href="<?php echo esc_url($item['link']); ?>">
                                    <figure class="image">
                                        <img src="<?php echo esc_url($item['image']['url']); ?>" 
                                             alt="<?php echo esc_attr($item['image']['alt']); ?>">
                                    </figure>
                                </a>
                            </div>    
                        </div>                
                        <?php endif;
                    } ?>
                </div>
            </div>        
        </div>
    </div>
</div>
<?php endif; ?>