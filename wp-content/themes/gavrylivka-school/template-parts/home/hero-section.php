<?php
/**
 * Hero Section Component for Home Page
 * Главная баннерная секция с слайдером - полностью на ACF
 *
 * ACF Fields Required:
 * - hero_title (Text) - Заголовок секции
 * - hero_subtitle (Textarea) - Подзаголовок секции
 * - hero_primary_button_text (Text) - Текст главной кнопки
 * - hero_primary_button_link (URL/Text) - Ссылка главной кнопки
 * - hero_secondary_button_text (Text) - Текст второй кнопки
 * - hero_secondary_button_link (URL/Text) - Ссылка второй кнопки
 * - hero_gallery (Gallery) - Галерея изображений для слайдера
 * 
 * Настройки автоплея и скорости зафиксированы в коде (автоплей: включен, 3.5 сек)
 *
 * @package Gavrylivka_School
 */

// Получаем ACF поля для hero секции
$hero_title = get_field('hero_title') ?: 'Gavrylivka School';
$hero_subtitle = get_field('hero_subtitle') ?: 'Сучасна освіта для майбутнього вашої дитини';
$hero_primary_button_text = get_field('hero_primary_button_text') ?: 'Дізнатися більше';
$hero_primary_button_link = get_field('hero_primary_button_link') ?: '#about';
$hero_secondary_button_text = get_field('hero_secondary_button_text') ?: 'Зв\'язатися з нами';
$hero_secondary_button_link = get_field('hero_secondary_button_link') ?: 'tel:+380671234567';

// Получаем галерею изображений из ACF
$hero_gallery = get_field('hero_gallery');
$banner_images = array();

// Настройки слайдера (фиксированные)
$slider_autoplay = true;
$slider_speed = 3500;

if ($hero_gallery && is_array($hero_gallery)) {
	$banner_images = $hero_gallery;
} else {
	// Fallback - получаем три изображения из старых полей
	for ($i = 1; $i <= 3; $i++) {
		$image = get_field('main_banner_' . $i);
		if ($image) {
			$banner_images[] = $image;
		}
	}
}
?>

<!-- Hero Section -->
<section class="hero-section">
	<div class="hero-container">
		<div class="hero-content">
			<h1 class="hero-title">
				<?php echo esc_html($hero_title); ?>
			</h1>
			<p class="hero-subtitle">
				<?php echo esc_html($hero_subtitle); ?>
			</p>
			<div class="hero-buttons">
				<a href="<?php echo esc_url($hero_primary_button_link); ?>" class="btn btn-primary">
					<?php echo esc_html($hero_primary_button_text); ?>
				</a>
				<a href="<?php echo esc_url($hero_secondary_button_link); ?>" class="btn btn-secondary">
					<?php echo esc_html($hero_secondary_button_text); ?>
				</a>
			</div>
		</div>
		<div class="hero-image">
			<?php if (!empty($banner_images)) : ?>
				<div class="hero-slider">
					<div class="slider-container">
						<?php foreach ($banner_images as $index => $image) : ?>
							<div class="slide <?php echo $index === 0 ? 'active' : ''; ?>" data-slide="<?php echo $index; ?>">
								<img src="<?php echo esc_url($image['url']); ?>"
									 alt="<?php echo esc_attr($image['alt'] ?: 'Фото школи ' . ($index + 1)); ?>"
									 loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>">
							</div>
						<?php endforeach; ?>
					</div>

                    <?php if (count($banner_images) > 1) : ?>
                        <!-- Segmented Progress Bar -->
						<div class="slider-progress">
							<?php foreach ($banner_images as $index => $image) : ?>
								<div class="progress-segment" data-slide="<?php echo $index; ?>">
									<div class="segment-fill"></div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php else : ?>
				<!-- Fallback: Beautiful School Illustration -->
				<div class="hero-illustration">
					<svg width="500" height="400" viewBox="0 0 500 400" fill="none" xmlns="http://www.w3.org/2000/svg">
						<!-- Sky Background -->
						<rect width="500" height="400" fill="url(#skyGradient)"/>

						<!-- Sun -->
						<circle cx="420" cy="80" r="30" fill="#FCD34D"/>
						<g stroke="#FCD34D" stroke-width="3" stroke-linecap="round">
							<path d="M420 30v-10M450 80h10M420 130v10M390 80h-10"/>
							<path d="M440 60l7-7M440 100l7 7M400 100l-7 7M400 60l-7-7"/>
						</g>

						<!-- Clouds -->
						<g fill="#ffffff" opacity="0.8">
							<ellipse cx="100" cy="60" rx="25" ry="15"/>
							<ellipse cx="115" cy="60" rx="30" ry="18"/>
							<ellipse cx="130" cy="60" rx="20" ry="12"/>

							<ellipse cx="350" cy="50" rx="20" ry="12"/>
							<ellipse cx="365" cy="50" rx="25" ry="15"/>
							<ellipse cx="380" cy="50" rx="18" ry="10"/>
						</g>

						<!-- School Building -->
						<g>
							<!-- Main Building -->
							<rect x="150" y="200" width="200" height="150" fill="#E5E7EB"/>
							<rect x="150" y="200" width="200" height="150" stroke="#D1D5DB" stroke-width="2"/>

							<!-- Roof -->
							<polygon points="140,200 250,120 360,200" fill="#EF4444"/>
							<polygon points="140,200 250,120 360,200" stroke="#DC2626" stroke-width="2" fill="none"/>

							<!-- Roof Detail -->
							<rect x="240" y="130" width="20" height="30" fill="#991B1B"/>

							<!-- Main Door -->
							<rect x="230" y="280" width="40" height="70" fill="#8B5CF6"/>
							<rect x="230" y="280" width="40" height="70" stroke="#7C3AED" stroke-width="2" fill="none"/>
							<circle cx="260" cy="315" r="2" fill="#FCD34D"/>

							<!-- Windows -->
							<rect x="170" y="230" width="30" height="30" fill="#60A5FA"/>
							<rect x="170" y="230" width="30" height="30" stroke="#3B82F6" stroke-width="2" fill="none"/>
							<path d="M185 230v30M170 245h30" stroke="#3B82F6" stroke-width="1"/>

							<rect x="300" y="230" width="30" height="30" fill="#60A5FA"/>
							<rect x="300" y="230" width="30" height="30" stroke="#3B82F6" stroke-width="2" fill="none"/>
							<path d="M315 230v30M300 245h30" stroke="#3B82F6" stroke-width="1"/>

							<rect x="170" y="290" width="30" height="30" fill="#60A5FA"/>
							<rect x="170" y="290" width="30" height="30" stroke="#3B82F6" stroke-width="2" fill="none"/>
							<path d="M185 290v30M170 305h30" stroke="#3B82F6" stroke-width="1"/>

							<rect x="300" y="290" width="30" height="30" fill="#60A5FA"/>
							<rect x="300" y="290" width="30" height="30" stroke="#3B82F6" stroke-width="2" fill="none"/>
							<path d="M315 290v30M300 305h30" stroke="#3B82F6" stroke-width="1"/>
						</g>

						<!-- Trees -->
						<g>
							<!-- Left Tree -->
							<rect x="75" y="300" width="15" height="50" fill="#8B5CF6"/>
							<circle cx="82" cy="310" r="25" fill="#10B981"/>

							<!-- Right Tree -->
							<rect x="410" y="290" width="15" height="60" fill="#8B5CF6"/>
							<circle cx="417" cy="300" r="30" fill="#10B981"/>
						</g>

						<!-- Ground -->
						<rect x="0" y="350" width="500" height="50" fill="#22C55E"/>

						<!-- Path -->
						<path d="M250 350 Q250 370 250 400" stroke="#9CA3AF" stroke-width="30" fill="none"/>

						<!-- Flowers -->
						<g>
							<circle cx="120" cy="340" r="3" fill="#F59E0B"/>
							<circle cx="130" cy="345" r="3" fill="#EF4444"/>
							<circle cx="110" cy="348" r="3" fill="#8B5CF6"/>

							<circle cx="380" cy="342" r="3" fill="#F59E0B"/>
							<circle cx="390" cy="347" r="3" fill="#EF4444"/>
							<circle cx="370" cy="350" r="3" fill="#8B5CF6"/>
						</g>

						<!-- Kids playing -->
						<g>
							<!-- Kid 1 -->
							<circle cx="320" cy="325" r="8" fill="#FDE68A"/>
							<rect x="315" y="333" width="10" height="15" fill="#3B82F6" rx="2"/>
							<rect x="317" y="348" width="6" height="8" fill="#1F2937" rx="1"/>

							<!-- Kid 2 -->
							<circle cx="180" cy="330" r="8" fill="#FDE68A"/>
							<rect x="175" y="338" width="10" height="15" fill="#EF4444" rx="2"/>
							<rect x="177" y="353" width="6" height="8" fill="#1F2937" rx="1"/>
						</g>

						<!-- Gradient Definitions -->
						<defs>
							<linearGradient id="skyGradient" x1="0%" y1="0%" x2="0%" y2="100%">
								<stop offset="0%" style="stop-color:#DBEAFE;stop-opacity:1" />
								<stop offset="100%" style="stop-color:#93C5FD;stop-opacity:1" />
							</linearGradient>
						</defs>
					</svg>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
