<?php

/*
 * Template Name: Full Width
 * Description: A Page Template with no sidebar.
 *
 * @package kidz
 */

ideapark_mod_set_temp( 'home_sidebar', 'disable' );
ideapark_mod_set_temp( 'post_hide_sidebar', true );

get_template_part( 'page' );
