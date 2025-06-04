<?php /* Template Name: Mission */ ?>
<?php get_header(); ?>
<div id="content" class="wrap page_id_<?php the_ID() ?>">
    <div class="top-info wysiwyg">
        <?php if ( have_posts() ): while ( have_posts() ): the_post();
            the_content();
        endwhile;endif;
        ?>
    </div>
    <div class="left-right-content activities-content">
        <div class="wrap flex">
            <div class="col-6 md-12 md-bottom">
                <?php if (get_field('activities_content')) { ?>
                    <div class="info">
                        <?php echo get_field('activities_content'); ?>
                    </div>
                <?php } ?>
            </div>
            <div class="col-6 md-12">
                <?php if ( $image = get_field('activities_image') ) : ?>
                    <?php $size = "large"; ?>
                    <figure class='image'>
                        <img src="<?php echo $image['sizes'][ $size ] ?>"
                        width="<?php echo $image['sizes'][ $size . '-width' ]; ?>"
                        height="<?php echo $image['sizes'][ $size . '-height' ]; ?>"
                        alt="<?php echo $image['alt'] ? $image['alt'] : $image['title'] ?>">
                    </figure>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php if ($left_right_content_repeater = get_field('left_right_content_repeater')) { ?>
        <div class="left-right-content-repeater">
            <div class="wrap">
                <div class="title">
                    <?php echo get_field('left_right_content_repeater_title') ?>
                </div>
                <div class="items">
                    <?php foreach ($left_right_content_repeater as $item) { ?>
                        <div class="item flex v-center">
                            <div class="col-6 md-12 md-bottom">
                                <?php if ( $image = $item['image'] ) : ?>
                                    <?php $size = "medium"; ?>
                                    <figure class='image'>
                                        <img src="<?php echo $image['sizes'][ $size ] ?>"
                                        width="<?php echo $image['sizes'][ $size . '-width' ]; ?>"
                                        height="<?php echo $image['sizes'][ $size . '-height' ]; ?>"
                                        alt="<?php echo $image['alt'] ? $image['alt'] : $image['title'] ?>">
                                    </figure>
                                <?php endif; ?>
                            </div>
                            <div class="col-6 md-12">
                                <?php echo $item['info'] ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php get_template_part('components/posts'); ?>
</div>
<?php get_footer(); ?>
