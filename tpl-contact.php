<?php get_header(); /* Template Name:Contact us*/?>
<div class="contact-us">
    <div class="wrap wrapper-flex">
        <?php if ( have_rows('list_email') ) : ?>
            <div class="email">
                <h4>Email</h4>
                <ul>

                    <?php while( have_rows('list_email') ) : the_row(); ?>
                        <li>
                            <?php echo get_sub_field('text_before_link'); ?>
                            <?php $link = get_sub_field('email'); ?>
                            <?php
                            if( $link ):
                            $link_url = $link['url'];
                            $link_title = $link['title'];
                            $link_target = $link['target'] ? $link['target'] : '_self';?>
                            <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php if ( have_rows('list_post') ) : ?>
            <div class="post">
                <h4>Post</h4>
                <?php while( have_rows('list_post') ) : the_row(); ?>
                    <?php $link = get_sub_field('post'); ?>
                    <?php
                      if( $link ):
                      $link_url = $link['url'];
                      $link_title = $link['title'];
                      $link_target = $link['target'] ? $link['target'] : '_self';?>
                      <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
        <?php if ( have_rows('social_links') ) : ?>
            <div class="social-link">
                <h4>Social Media</h4>
                <div class="s-link">
                    <?php while( have_rows('social_links') ) : the_row(); ?>
                        <a href="<?php echo esc_url(get_sub_field('url')); ?>" target="_blank" title="<?php echo esc_attr(get_sub_field('title') ?: 'Social Link'); ?>">
                          <i class="<?php echo esc_attr(get_sub_field('class_icon')); ?>"></i>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php get_template_part('components/join', 'section') ?>
<?php get_footer(); ?>