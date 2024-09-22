<?php
function my_simple_theme_setup() {
    add_theme_support( 'title-tag' );

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'my-simple-theme' ),
    ) );
}
add_action( 'after_setup_theme', 'my_simple_theme_setup' );

// Enqueue styles and scripts
function my_barebones_theme_enqueue_scripts() {
    wp_enqueue_style( 'my-barebones-theme-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'my_barebones_theme_enqueue_scripts' );
?>
