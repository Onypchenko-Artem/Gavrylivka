<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Gavrylivka_School
 */

?>

<footer id="colophon" class="site-footer">
    <div class="footer-main">
        <div class="footer-container">

            <!-- Footer Content -->
            <div class="footer-content">

                <!-- School Info -->
                <div class="footer-column footer-info">
                    <div class="footer-logo">
                        <?php
                        if (has_custom_logo()) :
                            the_custom_logo();
                        else :
                            ?>
                            <div class="logo-placeholder">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect width="40" height="40" rx="8" fill="#2563eb"/>
                                    <path d="M12 16h16v2H12v-2zm0 4h16v2H12v-2zm0 4h12v2H12v-2z" fill="white"/>
                                </svg>
                            </div>
                        <?php
                        endif;
                        ?>
                        <div class="footer-brand">
                            <h3><?php bloginfo('name'); ?></h3>
                            <?php
                            $description = get_bloginfo('description', 'display');
                            if ($description) :
                                ?>
                                <p><?php echo esc_html($description); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <p class="footer-description">
                        Сучасна освіта для майбутнього вашої дитини. Ми створюємо комфортне середовище для навчання та
                        розвитку кожної дитини.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="footer-column">
                    <h4 class="footer-title">Швидкі посилання</h4>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-menu',
                        'menu_class' => 'footer-menu',
                        'container' => false,
                        'fallback_cb' => 'gavrylivka_school_footer_menu_fallback',
                    ));
                    ?>
                </div>

                <!-- Contact Info -->
                <div class="footer-column">
                    <h4 class="footer-title">Контакти</h4>
                    <div class="footer-contacts">
                        <div class="footer-contact-item">
                            <span class="contact-icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/location.svg"
                                         alt="location">
                                </span>
                            <span>с. Гаврилівка, вул. Паркова, 90</span>
                        </div>
                        <div class="footer-contact-item">
								<span class="contact-icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/phone.svg"
                                         alt="phone">
                                </span>
                            <a href="tel:+380671234567">+38 (067) 123-45-67</a>
                        </div>
                        <div class="footer-contact-item">
                            <span class="contact-icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/mail.svg"
                                         alt="mail">
                                </span>
                            <a href="mailto:gavrilovkanvk2016@ukr.net">gavrilovkanvk2016@ukr.net</a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="footer-container">
            <div class="footer-bottom-content">
                <div class="footer-copyright">
                    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Всі права захищені.</p>
                </div>
                <div class="footer-credits">
                    <p>Розробка сайту: <a href="https://neosolve.com.ua/" target="_blank">NeoSolve</a></p>
                </div>
            </div>
        </div>
    </div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
