<?php get_header(); ?>

<?php
// News page header setup
$news_header_img = get_field('news_header_image', 'option'); // Global news header image
$default_img = get_template_directory_uri() . '/img/def.jpg';
$bg_img = $news_header_img ? $news_header_img['url'] : $default_img;
?>

<div class="home-top-section" style="background: url('<?php echo esc_url($bg_img); ?>') center/cover no-repeat; min-height: 320px; display: flex; align-items: center; width: 100%; max-width: 1720px; margin: 0 auto; border-radius: 0 0 32px 32px;">
  <div class="wrap1720" style="background: rgba(0,0,0,0.55); border-radius: 0 0 32px 32px; padding: 2.5rem 2rem; width: 100%; max-width: 1200px; margin: 0 auto;">
    <h1 style="color: #fff; font-size: 3rem; margin: 0 0 1rem;">News</h1>
    <div style="color: #fff; font-size: 1.25rem;">Berlin based blockchain news - what is going on atm in Berlin.</div>
  </div>
</div>

<div id="content" class="wrap index-style">
    <?php $news_top_info = get_field("news_top_info", BLOG_ID);
    if ($news_top_info) { ?>
        <div class="news-top-info">
            <?php echo $news_top_info; ?>
        </div>
    <?php } ?>

    <main class="index-main">
        <div class="posts-news-wrapper">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="post-news">
                    <a href="<?php the_permalink(); ?>" class="thumb">
                        <time class="time-block"><span class="day"><?php echo get_the_date('j'); ?></span><span
                                    class="month"><?php echo get_the_date('M'); ?></span></time>
                        <?php echo has_post_thumbnail() ? get_the_post_thumbnail(get_the_ID(), 'large') : '<img src="' . get_template_directory_uri() . '/img/def.jpg" alt="Default Image">' ?>
                    </a>

                    <div class="info">
                        <span class="news-title"><a
                                    href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
                        <p><?php echo wp_trim_words(strip_shortcodes(get_the_content()), 20, " "); ?></p>
                    </div>
                </div>
            <?php endwhile; endif; ?>
        </div>

        <?php if (function_exists('wp_pagenavi')) {
            wp_pagenavi();
        } ?>
    </main>

    <?php $reel_info = get_field("reel_info", BLOG_ID);
    $reel_title = get_field("reel_title", BLOG_ID);
    if ($reel_info || $reel_title) { ?>
        <div class="reel-info-block-box">
            <?php if ($reel_title) { ?>
                <h2><?php echo $reel_title; ?></h2>
            <?php } ?>
            <?php if ($reel_info) { ?>
                <div class="reel-info-text">
                    <?php echo $reel_info; ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <?php $subscribe_info = get_field("subscribe_info", BLOG_ID);
    $subscribe_form = get_field("subscribe_form", BLOG_ID);
    if ($subscribe_info || $subscribe_form) { ?>
        <div class="subscribe-block-box flex">
            <?php if ($subscribe_info) { ?>
                <div class="subscribe-text-box">
                    <?php echo $subscribe_info; ?>
                </div>
            <?php } ?>
            <?php if ($subscribe_form) { ?>
                <div class="subscribe-form-box">
                    <?php echo $subscribe_form; ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<?php get_footer(); ?>
