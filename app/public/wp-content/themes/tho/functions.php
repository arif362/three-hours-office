<?php
/*
* Tho functions and definitions
*/

// Theme title
add_theme_support( 'title-tag' );


// Theme styles and scripts files calling
function tho_css_js_file_calling() {
    wp_enqueue_style( 'tho-style', get_stylesheet_uri() );
    wp_register_style( 'tailwind', get_template_directory_uri() . '/css/tailwind.css', array(), false, true );
    wp_enqueue_style( 'custom', get_template_directory_uri() . '/css/custom.css', array(), false, true  );
    wp_enqueue_style( 'tailwind');
    wp_enqueue_style( 'custom');
    wp_enqueue_script( 'tho-script', get_template_directory_uri() . '/js/script.js', array(), false, true );

    // jQuery
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'tailwind',  get_template_directory_uri() . '/js/tailwind.js', array(), false, true );
    wp_enqueue_script( 'main',  get_template_directory_uri() . '/js/main.js', array(), false, true );

}
add_action( 'wp_enqueue_scripts', 'tho_css_js_file_calling' );