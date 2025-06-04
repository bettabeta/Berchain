<?php 
/* Template Name: Berlin's Blockchain */
get_header(); 
?>
    <?php if (get_field('top_text')): ?>
    <div class="top-text">
        <div class="wrap">
            <?php echo get_field('top_text'); ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="berlin-blockchain wrap1720">
<?php if (get_field('box_info')): ?>
    <div class="box-blockchain">
        <div class="box-content wrap1720">
            <?php echo get_field('box_info'); ?>
        </div>
        <?php if( have_rows('sponsor_logos') ): ?>
            <div class="wrap1720">
                <div class="sponsors-section">
                    <h4 class="text-center">Sponsored by</h4>
                    <div class="sponsor-logos">
                        <?php while( have_rows('sponsor_logos') ): the_row(); 
                            $logo = get_sub_field('logo');
                            $name = get_sub_field('name');
                            $link = get_sub_field('link');
                        ?>
                            <div class="sponsor-logo">
                                <?php if($link): ?>
                                    <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener">
                                <?php endif; ?>
                                    <img src="<?php echo esc_url($logo['url']); ?>" 
                                         alt="<?php echo esc_attr($name); ?>"
                                         width="<?php echo esc_attr($logo['width']); ?>"
                                         height="<?php echo esc_attr($logo['height']); ?>">
                                <?php if($link): ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php get_template_part('components/join', 'section') ?>
<?php get_footer(); ?> 