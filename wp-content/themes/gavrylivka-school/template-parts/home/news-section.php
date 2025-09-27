<?php
/**
 * News Section Component for Home Page
 * Секция новостей и событий
 *
 * @package Gavrylivka_School
 */
?>

<!-- News/Posts Section -->
<section class="news-section">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title">Новини та події</h2>
			<p class="section-subtitle">Слідкуйте за життям нашої школи</p>
		</div>

		<div class="posts-grid">
			<?php
			$recent_posts = new WP_Query(array(
				'posts_per_page' => 3,
				'post_status' => 'publish'
			));

			if ($recent_posts->have_posts()) :
				while ($recent_posts->have_posts()) : $recent_posts->the_post();
					?>
					<article class="post-card">
						<?php if (has_post_thumbnail()) : ?>
							<div class="post-thumbnail">
								<?php the_post_thumbnail('medium'); ?>
							</div>
						<?php endif; ?>
						
						<div class="post-content">
							<div class="post-meta">
								<time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
							</div>
							<h3 class="post-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
							<div class="post-excerpt">
								<?php the_excerpt(); ?>
							</div>
							<a href="<?php the_permalink(); ?>" class="read-more">Читати далі →</a>
						</div>
					</article>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<div class="no-posts">
					<p>Поки що немає новин. Слідкуйте за оновленнями!</p>
				</div>
				<?php
			endif;
			?>
		</div>

		<?php if ($recent_posts->have_posts()) : ?>
			<div class="section-footer">
				<a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn-outline">Всі новини</a>
			</div>
		<?php endif; ?>
	</div>
</section>
