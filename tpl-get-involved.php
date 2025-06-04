<?php get_header(); /* Template Name:Get Involved*/?>
<div class="get-involved">
	<?php if (get_field('top_info') || get_field('top_left_info') || get_field('top_right_image')) : ?>
	<div class="top-content">
		<div class="wrap">
			<?php if (get_field('top_info')) : ?>
			<div class="text">
				<?php echo get_field('top_info'); ?>
			</div>
			<?php endif; ?>
			<?php if (get_field('top_left_info') || get_field('top_right_image')) : ?>
			<div class="item flex">
				<div class="left">
					<?php echo get_field('top_left_info'); ?>
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
				<figure class="right">
					<img src="<?php echo image_src( get_field('top_right_image'), 'large', false, false ); ?>" alt="Image">
				</figure>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>
	<?php if ($variable = get_field('members_items')) : ?>
		<div class="members-logo">
			<div class="wrap1720">
				<div class="content-box">
					<?php if (get_field('members_text')) : ?>
					<div class="top-text">
						<?php echo get_field('members_text'); ?>
					</div>
					<?php endif; ?>
					<div class="items">
						<?php foreach ($variable as $item) { ?>
							<div class="item logo-item-v">
								<a class="link-logo" href="<?php echo esc_attr( $item['link'] ); ?>">
									<figure class="image">
										<img src="<?php echo image_src( $item['image'], 'medium', false, false ); ?>" alt="Image">
									</figure>
								</a>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php if (get_field('become_a_member_top') || get_field('become_a_member_box')) : ?>
		<div class="become-member">
			<div class="wrap">
				<?php if (get_field('become_a_member_top')) : ?>
				<div class="top-info">
					<?php echo get_field('become_a_member_top'); ?>
				</div>
				<?php endif; ?>
				<?php if ($variable = get_field('become_a_member_box')) : ?>
					<div class="items flex">
						<?php foreach ($variable as $item) { ?>
							<div class="item">
								<?php echo $item['info']; ?>
							</div>
						<?php } ?>
					</div>
				<?php endif; ?>
				<?php
		        $link = get_field('become_a_member_button');
		        if( $link ):
		            $link_url = $link['url'];
		            $link_title = $link['title'];
		            $link_target = $link['target'] ? $link['target'] : '_self';
		            ?>
		            <div class="button">
		            	<a class="btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
		            </div>
		        <?php endif; ?>
			</div>
		</div>
	<?php endif; ?>
	<?php if ($variable = get_field('box_list')) : ?>
		<div class="list-box">
			<div class="wrap1720">
				<div class="content-box">
					<div class="items flex">
					<?php foreach ($variable as $item) { ?>
						<div class="item">
							<figure class="image">
								<img src="<?php echo image_src( $item['icon'], 'medium', false, false ); ?>" alt="Image">
							</figure>
							<div class="info">
								<?php echo $item['info']; ?>
							</div>
						</div>
					<?php } ?>
					</div>
					<?php
			        $link = get_field('box_list_button');
			        if( $link ):
			            $link_url = $link['url'];
			            $link_title = $link['title'];
			            $link_target = $link['target'] ? $link['target'] : '_self';
			            ?>
			            <div class="button">
			            	<a class="btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
			            </div>
			        <?php endif; ?>
		        </div>
			</div>
		</div>
	<?php endif; ?>
	<?php if (get_field('members_items') || get_field('berchain_image') || get_field('berchain_info')) : ?>
		<div class="members-slider">
			<div class="wrap1720">
				<div class="content-box">
					<?php if (get_field('berchain_info') || get_field('berchain_image')) : ?>
					<div class="image-info flex">
						<div class="info-left">
							<?php echo get_field('berchain_info'); ?>
						</div>
						<figure class="image-right">
							<img src="<?php echo image_src( get_field('berchain_image'), 'large', false, false ); ?>" alt="Image">
						</figure>
					</div>
					<?php endif; ?>
					<?php if ($variable = get_field('members_items')) : ?>
						<div class="swiper">
							<div class="swiper-wrapper">
								<?php foreach ($variable as $item) { ?>
			                        <div class="swiper-slide">
			                            <div class="item logo-item-v">
			                            	<a class="link-logo" href="<?php echo esc_attr( $item['link'] ); ?>">
												<figure class="image">
													<img src="<?php echo image_src( $item['image'], 'medium', false, false ); ?>" alt="Image">
												</figure>
											</a>
			                            </div>	
			                        </div>                
			                    <?php } ?>
							</div>
						</div>		
					<?php endif; ?>
					<div class="buttons">
						<?php
	                    $link = get_field('slack_link', 'options');
	                    if( $link ):
	                        $link_url = $link['url'];
	                        $link_title = $link['title'];
	                        $link_target = $link['target'] ? $link['target'] : '_self';
	                        ?>
	                        <a class="btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><i class="fa-brands fa-slack"></i> <?php echo esc_html( $link_title ); ?></a>
	                    <?php endif; ?>
						<?php
				        $link = get_field('berchain_button');
				        if( $link ):
				            $link_url = $link['url'];
				            $link_title = $link['title'];
				            $link_target = $link['target'] ? $link['target'] : '_self';
				            ?>
				            <a class="btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
				        <?php endif; ?>
                    </div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>	
<?php get_footer(); ?>