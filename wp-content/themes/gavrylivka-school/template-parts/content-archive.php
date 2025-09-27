<?php
/**
 * Template part for displaying posts in archive/grid layout
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Gavrylivka_School
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('news-card'); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="news-card-image">
			<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
				<?php the_post_thumbnail('medium', array('class' => 'news-thumbnail')); ?>
			</a>
		</div>
	<?php endif; ?>
	
	<div class="news-card-content">
		<header class="news-card-header">
			<?php
			the_title( '<h2 class="news-card-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			?>
			
			<div class="news-card-meta">
				<span class="news-date">
					<?php echo get_the_date(); ?>
				</span>
			</div>
		</header><!-- .news-card-header -->

		<div class="news-card-excerpt">
			<?php
			if ( has_excerpt() ) {
				the_excerpt();
			} else {
				echo '<p>' . wp_trim_words( get_the_content(), 20, '...' ) . '</p>';
			}
			?>
		</div><!-- .news-card-excerpt -->
		
		<footer class="news-card-footer">
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="read-more-btn">
				<?php esc_html_e( 'Читати далі', 'gavrylivka-school' ); ?>
			</a>
		</footer><!-- .news-card-footer -->
	</div><!-- .news-card-content -->
</article><!-- #post-<?php the_ID(); ?> -->
