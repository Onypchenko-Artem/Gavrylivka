<?php
/**
 * Template Name: Agenda
 * Description: Custom template for displaying schedule table from CSV file.
 *
 * @package Gavrylivka_School
 */

get_header();
?>

	<?php gavrylivka_school_breadcrumbs(); ?>

	<main id="primary" class="site-main agenda-page">
		<?php
		while ( have_posts() ) :
			the_post();
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'agenda-article' ); ?>>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header>

			<div class="entry-content">
				<?php
				// Output the content so editors can add intro text
				the_content();
				
				// Define days of the week
				$days = array(
					'monday'    => 'Понеділок',
					'tuesday'   => 'Вівторок',
					'wednesday' => 'Середа',
					'thursday'  => 'Четвер',
					'friday'    => 'П\'ятниця',
				);
				
				// Check if we have any files
				$has_files = false;
				foreach ( $days as $day_key => $day_name ) {
					if ( get_field( 'agenda_' . $day_key ) ) {
						$has_files = true;
						break;
					}
				}
				
				if ( $has_files && function_exists( 'gavrylivka_school_parse_csv_to_table' ) ) :
				?>
				
				<div class="agenda-tabs-wrapper">
					<!-- Tabs navigation -->
					<div class="agenda-tabs-nav">
						<?php
						$first = true;
						foreach ( $days as $day_key => $day_name ) :
							$csv_file = get_field( 'agenda_' . $day_key );
							if ( $csv_file ) :
								$active_class = $first ? ' active' : '';
								$first = false;
						?>
							<button class="agenda-tab-btn<?php echo $active_class; ?>" data-tab="day-<?php echo esc_attr( $day_key ); ?>">
								<?php echo esc_html( $day_name ); ?>
							</button>
						<?php
							endif;
						endforeach;
						?>
					</div>
					
					<!-- Tabs content -->
					<div class="agenda-tabs-content">
						<?php
						$first = true;
						foreach ( $days as $day_key => $day_name ) :
							$csv_file = get_field( 'agenda_' . $day_key );
							if ( $csv_file ) :
								$csv_path = get_attached_file( $csv_file['ID'] );
								$active_class = $first ? ' active' : '';
								$first = false;
						?>
							<div class="agenda-tab-pane<?php echo $active_class; ?>" id="day-<?php echo esc_attr( $day_key ); ?>">
								<?php
								if ( $csv_path && file_exists( $csv_path ) ) {
									echo gavrylivka_school_parse_csv_to_table( $csv_path ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								} elseif ( current_user_can( 'edit_posts' ) ) {
									echo '<div class="no-csv-message"><p>Файл для ' . esc_html( $day_name ) . ' не знайдено на сервері.</p></div>';
								}
								?>
							</div>
						<?php
							endif;
						endforeach;
						?>
					</div>
				</div>
				
				<?php
				elseif ( current_user_can( 'edit_posts' ) ) :
				?>
					<div class="no-csv-message">
						<p><?php esc_html_e( 'Будь ласка, завантажте CSV файли для днів тижня у редакторі сторінки.', 'gavrylivka-school' ); ?></p>
					</div>
				<?php
				endif;
				?>
			</div>
		</article>

		<?php
		endwhile;
		?>
	</main>

<?php
get_footer();

