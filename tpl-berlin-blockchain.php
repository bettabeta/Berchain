<?php
/* Template Name: tpl-berlin-blockchain */
get_header();
?>

<div class="berlin-blockchain">
    <div class="wrap">
        <div class="content">
            <h1>Berlin's Blockchain</h1>
            
            <p>Are you a part of Berlin's Blockchain Ecosystem? Add Your Startup and let the world know<br>
            about your innovation. Join us as we map the future of blockchain in Berlin!</p>

            <?php if( have_rows('sponsor_logos') ): ?>
                <div class="sponsors-section">
                    <h4>Sponsored by</h4>
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
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?> 