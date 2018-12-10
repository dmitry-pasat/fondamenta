<?php
/*
 * Template Name: Page with All Widgets
 * Description: Only for theme demo.
 *
 * @package kidz
 */

ideapark_mod_set_temp( 'home_sidebar', 'right' );
ideapark_mod_set_temp( 'post_hide_sidebar', false );
ideapark_mod_set_temp( 'main_sidebar', 'all-sidebar' );
ideapark_mod_set_temp( 'footer_sidebar', 'footer-all-sidebar' );

get_template_part( 'page' );
