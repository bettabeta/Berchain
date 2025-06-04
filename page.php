<?php get_header(); ?>
<div id="content" class="wrap page_id_<?php the_ID() ?>">
    <main>
        <div class="wysiwyg">
			<?php if ( have_posts() ): while ( have_posts() ): the_post();
				the_content();
			endwhile;endif;
			?>
        </div>
    </main>
</div>
<?php get_footer(); ?>
