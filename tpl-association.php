<?php get_header(); /* Template Name: Association*/?>
<div class="association">
    <?php if ( get_field('mission') ) : ?>
        <div class="mission">
            <div class="wrap">
                <?php echo get_field('mission'); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if ( get_field('left_text') || get_field('list_mission') || get_field('left_image') ) : ?>
        <div class="list-mission">
            <div class="wrap-large wide-block">
                <div class="wrap flex">
                    <div class="left">
                        <?php if ( get_field('left_text') ) : ?>
                            <?php echo get_field('left_text'); ?>
                        <?php endif; ?>
                        
                        <?php $image = get_field('left_image'); ?>
                        <?php $size = 'large'; ?>
                        <figure class="image">
                            <img src="<?php echo $image['sizes'][ $size ] ?>"
                                 width="<?php echo $image['sizes'][ $size . '-width' ]; ?>"
                                 height="<?php echo $image['sizes'][ $size . '-height' ]; ?>"
                                 alt="<?php echo $image['alt'] ? $image['alt'] : $image['title'] ?>"/>
                        </figure>
    
                    </div>
                    <?php if ( get_field('left_image') ) : ?>
                        <div class="right">
                        <?php echo get_field('list_mission'); ?>
    
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ( get_field('title_action') ) : ?>
        <div class="our-actions">
            <div class="wrap">
                <h2><?php echo get_field('title_action'); ?></h2>
                <?php if ( have_rows('items') ) : ?>
                    <div class="items">
                        <?php while( have_rows('items') ) : the_row(); ?>
                            <div class="item">
                                <div class="left">
                                    <?php echo get_sub_field('text_list_action'); ?>
                                </div>
                                <div class="right">
                                    <?php $image = get_sub_field('image_action'); ?>
                                    <?php $size = 'large'; ?>
                                    <figure class="image">
                                        <img src="<?php echo $image['sizes'][ $size ] ?>"
                                            width="<?php echo $image['sizes'][ $size . '-width' ]; ?>"
                                            height="<?php echo $image['sizes'][ $size . '-height' ]; ?>"
                                            alt="<?php echo $image['alt'] ? $image['alt'] : $image['title'] ?>"/>
                                    </figure>
                                </div>
                            </div>
                
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if ( get_field('text_with_button') ) : ?>
        <div class="wrap-large wide-block join-slack-block">
            <div class="wrap wrapper-container">
                <?php echo get_field('text_with_button'); ?>
                <?php 
                $link = get_field('slack_link', 'options');
                if( $link ): 
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>
                    <a class="btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><i class="fa-brands fa-slack"></i> <?php echo esc_html( $link_title ); ?></a>
                <?php endif; ?>   
            </div>
            
        </div>
    <?php endif; ?>
    <?php if ( get_field('title_with_text') || get_field('text_before_team') ||  have_rows('team_list')) : ?>
        <div class="team">
            <div class="wrap">
                <?php if ( get_field('title_with_text') ) : ?>
                    <div class="title-text">
                        <?php echo get_field('title_with_text'); ?>
                    </div>
                <?php endif; ?>
                <?php if ( get_field('text_before_team') ) : ?>
                    <div class="text-before-team">
                        <?php echo get_field('text_before_team'); ?>
                    </div>
                <?php endif; ?>
                <?php if ( have_rows('team_list') ) : ?>
                    <div class="teams-items">
                        <?php while( have_rows('team_list') ) : the_row(); ?>
                            <a href=" <?php echo get_sub_field('link_contact'); ?>" target="_blank" class="card-person">
                               
                                <?php $image = get_sub_field('avatar'); ?>
                                <?php $size = 'large'; ?>
                                <figure class="image">
                                    <img src="<?php echo $image['sizes'][ $size ] ?>"
                                         width="<?php echo $image['sizes'][ $size . '-width' ]; ?>"
                                         height="<?php echo $image['sizes'][ $size . '-height' ]; ?>"
                                         alt="<?php echo $image['alt'] ? $image['alt'] : $image['title'] ?>"/>
                                </figure>
                                <div class="info">
                                    <h4><?php echo get_sub_field('last_name_name'); ?></h4>
                                    <h5><?php echo get_sub_field('job_name'); ?></h5>
                                </div>
                            </a>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (  get_field('title_w_c') ||  get_field('image_w_c') ||  have_rows('cards') ) : ?>
        <div class="governance">
            <div class="wrap-large wide-block">
                <div class="wrap flex">
                    <div class="left">
                        <?php if ( get_field('title_w_c') ) : ?>
                            <h2><?php echo get_field('title_w_c'); ?></h2>
                        <?php endif; ?>
                        <?php if ( get_field('image_w_c') ) : ?>
                            <?php $image = get_field('image_w_c'); ?>
                            <?php $size = 'large';?>
                            <figure class="image">
                                <img src="<?php echo $image['sizes'][ $size ] ?>"
                                     width="<?php echo $image['sizes'][ $size . '-width' ]; ?>"
                                     height="<?php echo $image['sizes'][ $size . '-height' ]; ?>"
                                     alt="<?php echo $image['alt'] ? $image['alt'] : $image['title'] ?>"/>
                            </figure>
                        <?php endif; ?>
                    </div>
                    <?php if ( get_field('cards') ) : ?>
                        <div class="right">
                            <?php if ( have_rows('cards') ) : ?>
                                <?php while( have_rows('cards') ) : the_row(); ?>
                                <?php if( get_sub_field('file') ): ?>
                                    <a class="item" href="<?php echo get_sub_field('file'); ?>" target="_blank">
                                        <p><?php echo get_sub_field('text_card'); ?> <i class="fa-solid fa-download"></i></p>
                                    </a>
                                <?php endif; ?>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php get_template_part('components/join', 'section') ?>
<?php get_footer(); ?>