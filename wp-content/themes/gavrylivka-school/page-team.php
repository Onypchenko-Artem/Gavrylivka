<?php
/**
 * Template Name: Team
 * Description: Custom template for displaying team members.
 *
 * @package Gavrylivka_School
 */

get_header();
?>

	<?php gavrylivka_school_breadcrumbs(); ?>

	<main id="primary" class="site-main team-page">
		<?php
		while ( have_posts() ) :
			the_post();
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class('team-article'); ?>>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header>

			<div class="entry-content">
				<?php
				// Output the content so editors can add intro text
				the_content();
				?>

				<?php
				// Check if any team member is filled
				$has_team_data = false;
				for ( $i = 1; $i <= 6; $i++ ) {
					if ( get_field( 'member_' . $i . '_name' ) ) {
						$has_team_data = true;
						break;
					}
				}
				
				if ( $has_team_data ) :
					// Get section title
					$section_title = get_field('admin_section_title');
					if ( empty( $section_title ) ) {
						$section_title = 'Адміністрація';
					}
				?>
				<section class="team-section">
					<h2 class="team-section-title"><?php echo esc_html( $section_title ); ?></h2>
					
					<div class="team-grid">
						<?php
						// Loop through 6 possible members
						for ( $i = 1; $i <= 6; $i++ ) :
							$photo = get_field( 'member_' . $i . '_photo' );
							$name = get_field( 'member_' . $i . '_name' );
							$position = get_field( 'member_' . $i . '_position' );
							$description = get_field( 'member_' . $i . '_description' );
							$email = get_field( 'member_' . $i . '_email' );
							$phone = get_field( 'member_' . $i . '_phone' );
							
							// Only show if name is filled
							if ( $name ) :
						?>
						<div class="team-member">
							<div class="team-member-photo">
								<?php if ( $photo ) : ?>
									<img src="<?php echo esc_url( $photo['sizes']['medium_large'] ); ?>" alt="<?php echo esc_attr( $name ); ?>" />
								<?php else : ?>
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/default-avatar.svg' ); ?>" alt="<?php echo esc_attr( $name ); ?>" />
								<?php endif; ?>
							</div>
							<div class="team-member-info">
								<h3 class="team-member-name"><?php echo esc_html( $name ); ?></h3>
								
								<?php if ( $position ) : ?>
									<p class="team-member-position"><?php echo esc_html( $position ); ?></p>
								<?php endif; ?>
								
								<?php if ( $description ) : ?>
									<p class="team-member-description"><?php echo esc_html( $description ); ?></p>
								<?php endif; ?>
								
								<?php if ( $email || $phone ) : ?>
									<div class="team-member-contacts">
										<?php if ( $email ) : ?>
											<a href="mailto:<?php echo esc_attr( $email ); ?>" class="team-contact-link">
												<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
													<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
													<polyline points="22,6 12,13 2,6"></polyline>
												</svg>
												<?php echo esc_html( $email ); ?>
											</a>
										<?php endif; ?>
										
										<?php if ( $phone ) : ?>
											<a href="tel:<?php echo esc_attr( preg_replace('/[^0-9+]/', '', $phone) ); ?>" class="team-contact-link">
												<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
													<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
												</svg>
												<?php echo esc_html( $phone ); ?>
											</a>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<?php
							endif; // if name
						endfor; // for loop
						?>
					</div>
				</section>

				<?php
				// Check if any teacher is filled
				$has_teacher_data = false;
				for ( $i = 1; $i <= 25; $i++ ) {
					if ( get_field( 'teacher_' . $i . '_name' ) ) {
						$has_teacher_data = true;
						break;
					}
				}
				
				if ( $has_teacher_data ) :
					// Get teachers section title
					$teachers_section_title = get_field('teachers_section_title');
					if ( empty( $teachers_section_title ) ) {
						$teachers_section_title = 'Педагогічний колектив';
					}
				?>
				<section class="team-section">
					<h2 class="team-section-title"><?php echo esc_html( $teachers_section_title ); ?></h2>
					
					<div class="team-grid">
						<?php
						// Loop through 25 possible teachers
						for ( $i = 1; $i <= 25; $i++ ) :
							$photo = get_field( 'teacher_' . $i . '_photo' );
							$name = get_field( 'teacher_' . $i . '_name' );
							$position = get_field( 'teacher_' . $i . '_position' );
							$description = get_field( 'teacher_' . $i . '_description' );
							
							// Only show if name is filled
							if ( $name ) :
						?>
						<div class="team-member">
							<div class="team-member-photo">
								<?php if ( $photo ) : ?>
									<img src="<?php echo esc_url( $photo['sizes']['medium_large'] ); ?>" alt="<?php echo esc_attr( $name ); ?>" />
								<?php else : ?>
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/default-avatar.svg' ); ?>" alt="<?php echo esc_attr( $name ); ?>" />
								<?php endif; ?>
							</div>
							<div class="team-member-info">
								<h3 class="team-member-name"><?php echo esc_html( $name ); ?></h3>
								
								<?php if ( $position ) : ?>
									<p class="team-member-position"><?php echo esc_html( $position ); ?></p>
								<?php endif; ?>
								
								<?php if ( $description ) : ?>
									<p class="team-member-description"><?php echo esc_html( $description ); ?></p>
								<?php endif; ?>
							</div>
						</div>
						<?php
							endif; // if name
						endfor; // for loop
						?>
					</div>
				</section>
				<?php endif; // if has_teacher_data ?>
                <?php endif; // if has_team_data ?>
			</div>
		</article>

		<?php
		endwhile; // End of the loop.
		?>
	</main>

<?php
get_footer();
?>

