<?php
/**
 * Template Name: News Archive Page
 * 
 * Custom page template for displaying all news/posts
 *
 * @package Gavrylivka_School
 */

get_header();
?>

<main id="primary" class="site-main archive-main">
    <header class="page-header">
        <h1 class="page-title">Всі новини</h1>
        <div class="archive-description">
            <p>Останні новини та події нашої школи</p>
        </div>
    </header><!-- .page-header -->

    <?php
    // Custom query to get all posts
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    
    $news_query = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => 12,
        'paged' => $paged,
        'post_status' => 'publish'
    ));

    if ($news_query->have_posts()) : ?>
        <div class="news-grid">
            <?php
            while ($news_query->have_posts()) :
                $news_query->the_post();
                get_template_part('template-parts/content', 'archive');
            endwhile;
            ?>
        </div><!-- .news-grid -->

        <?php
        // Pagination
        $total_pages = $news_query->max_num_pages;
        if ($total_pages > 1) {
            echo '<nav class="posts-navigation">';
            echo '<div class="nav-links">';
            
            if ($paged > 1) {
                echo '<a href="' . get_pagenum_link($paged - 1) . '" class="nav-previous">← Попередня</a>';
            }
            
            if ($paged < $total_pages) {
                echo '<a href="' . get_pagenum_link($paged + 1) . '" class="nav-next">Наступна →</a>';
            }
            
            echo '</div>';
            echo '</nav>';
        }
        
        wp_reset_postdata();
    else :
        echo '<div class="no-posts-found">';
        echo '<h2>Новин поки немає</h2>';
        echo '<p>Перші новини з\'являться найближчим часом</p>';
        echo '</div>';
    endif;
    ?>
</main><!-- #main -->

<?php
get_footer();
?>
