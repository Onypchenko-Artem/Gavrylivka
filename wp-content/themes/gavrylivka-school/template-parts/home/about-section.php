<?php
/**
 * About Section Component for Home Page
 * Секция "О школе" с карточками преимуществ
 *
 * @package Gavrylivka_School
 */

// Get ACF fields with fallback to defaults
$about_title = get_field('about_title') ?: 'Про нашу школу';
$about_subtitle = get_field('about_subtitle') ?: 'Ми створюємо комфортне середовище для навчання та розвитку кожної дитини';

// Item 1
$item_1_icon = get_field('about_item_1_icon');
$item_1_title = get_field('about_item_1_title') ?: 'Сучасні методики';
$item_1_text = get_field('about_item_1_text') ?: 'Використовуємо найновіші педагогічні підходи та технології для ефективного навчання';

// Item 2
$item_2_icon = get_field('about_item_2_icon');
$item_2_title = get_field('about_item_2_title') ?: 'Індивідуальний підхід';
$item_2_text = get_field('about_item_2_text') ?: 'Кожна дитина унікальна, тому ми розробляємо персональні програми розвитку';

// Item 3
$item_3_icon = get_field('about_item_3_icon');
$item_3_title = get_field('about_item_3_title') ?: 'Досвідчені вчителі';
$item_3_text = get_field('about_item_3_text') ?: 'Наша команда – це кваліфіковані педагоги з багаторічним досвідом роботи';

// Function to get icon - either from uploaded SVG or default
function gavrylivka_get_about_icon($icon_data, $default_icon = 'cube') {
	// If ACF file is uploaded, use it
	if ($icon_data && is_array($icon_data)) {
		// Try to get file path
		$file_path = isset($icon_data['path']) ? $icon_data['path'] : '';
		
		// If no path, try to construct it from URL
		if (empty($file_path) && isset($icon_data['url'])) {
			$upload_dir = wp_upload_dir();
			$file_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $icon_data['url']);
		}
		
		// Load SVG content from file
		if ($file_path && file_exists($file_path)) {
			$svg_content = file_get_contents($file_path);
			if ($svg_content) {
				return $svg_content;
			}
		}
	}
	
	// Default icons as fallback
	$default_icons = array(
		'cube' => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
			<rect width="48" height="48" rx="12" fill="#dbeafe"/>
			<path d="M24 16l6 4v8l-6 4-6-4v-8l6-4z" stroke="#2563eb" stroke-width="2" fill="none"/>
			<path d="M18 20l6 4 6-4" stroke="#2563eb" stroke-width="2"/>
			<path d="M24 24v8" stroke="#2563eb" stroke-width="2"/>
		</svg>',
		'clock' => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
			<rect width="48" height="48" rx="12" fill="#dcfce7"/>
			<path d="M24 14a10 10 0 100 20 10 10 0 000-20z" stroke="#16a34a" stroke-width="2" fill="none"/>
			<path d="M24 18v8l4 2" stroke="#16a34a" stroke-width="2"/>
		</svg>',
		'calendar' => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
			<rect width="48" height="48" rx="12" fill="#fef3c7"/>
			<path d="M16 20h16v12H16V20z" stroke="#d97706" stroke-width="2" fill="none"/>
			<path d="M20 16v4m8-4v4" stroke="#d97706" stroke-width="2"/>
			<path d="M20 24h2m4 0h2m-8 4h8" stroke="#d97706" stroke-width="2"/>
		</svg>'
	);
	
	return isset($default_icons[$default_icon]) ? $default_icons[$default_icon] : $default_icons['cube'];
}
?>

<!-- About Section -->
<section id="about" class="about-section">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title"><?php echo esc_html($about_title); ?></h2>
			<p class="section-subtitle"><?php echo esc_html($about_subtitle); ?></p>
		</div>
		
		<div class="about-grid">
			<div class="about-item">
				<div class="about-icon">
					<?php echo gavrylivka_get_about_icon($item_1_icon, 'cube'); ?>
				</div>
				<h3><?php echo esc_html($item_1_title); ?></h3>
				<p><?php echo esc_html($item_1_text); ?></p>
			</div>

			<div class="about-item">
				<div class="about-icon">
					<?php echo gavrylivka_get_about_icon($item_2_icon, 'clock'); ?>
				</div>
				<h3><?php echo esc_html($item_2_title); ?></h3>
				<p><?php echo esc_html($item_2_text); ?></p>
			</div>

			<div class="about-item">
				<div class="about-icon">
					<?php echo gavrylivka_get_about_icon($item_3_icon, 'calendar'); ?>
				</div>
				<h3><?php echo esc_html($item_3_title); ?></h3>
				<p><?php echo esc_html($item_3_text); ?></p>
			</div>
		</div>
	</div>
</section>
