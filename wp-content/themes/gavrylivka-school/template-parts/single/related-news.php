<?php
/**
 * Template part for displaying related news on single post pages
 *
 * @package Gavrylivka_School
 */

// Get current post ID to exclude it from related posts
$current_post_id = get_the_ID();

// Query for latest posts excluding current post
$related_posts = new WP_Query(array(
    'post_type' => 'post',
    'posts_per_page' => 10,
    'post_status' => 'publish',
    'post__not_in' => array($current_post_id),
    'orderby' => 'date',
    'order' => 'DESC'
));

if ($related_posts->have_posts()) : ?>
    <section class="related-news-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Цікаві новини</h2>
                <p class="section-subtitle">Останні події нашої школи</p>
            </div>
            
            <div class="related-news-slider">
                <div class="swiper-container related-news-swiper">
                    <div class="swiper-wrapper">
                        <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                            <div class="swiper-slide">
                                <article class="related-news-card">
                                    <div class="related-news-image">
                                        <a href="<?php echo esc_url(get_permalink()); ?>">
                                            <?php echo gavrylivka_school_get_news_thumbnail('news-thumbnail', 'related-news-thumbnail'); ?>
                                        </a>
                                    </div>
                                    
                                    <div class="related-news-content">
                                        <div class="related-news-meta">
                                            <time datetime="<?php echo get_the_date('c'); ?>" class="related-news-date">
                                                <?php echo get_the_date(); ?>
                                            </time>
                                        </div>
                                        
                                        <h3 class="related-news-title">
                                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>
                                        
                                        <div class="related-news-excerpt">
                                            <?php
                                            if (has_excerpt()) {
                                                echo wp_trim_words(get_the_excerpt(), 15, '...');
                                            } else {
                                                echo wp_trim_words(get_the_content(), 15, '...');
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    
                    <!-- Navigation buttons -->
                    <div class="swiper-button-next related-news-next"></div>
                    <div class="swiper-button-prev related-news-prev"></div>
                    
                    <!-- Pagination -->
                    <div class="swiper-pagination related-news-pagination"></div>
                </div>
            </div>
        </div>
    </section>
    
    <?php wp_reset_postdata(); ?>
<?php endif; ?>
