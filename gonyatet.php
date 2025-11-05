<?php
/**
 * Plugin Name: Gonyatet
 * Description: A simple plugin that add note in the editor.
 * Version: 1.0
 * Author: Moch. Nasikhun Amin
 * Author URI: https://gonyatet.com
 * Text Domain: gonyatet
 */

// This line is a security check. It prevents direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Shortcode handler function for [note]
 *
 * @param array $atts Attributes passed to the shortcode (e.g., [note type="warning"]).
 * @param string $content The content between the opening and closing tags.
 * @return string The HTML output for the note.
 */
// ------------------------------------------
// 1. DEFINE THE SHORTCODE HANDLER FUNCTION
// ------------------------------------------
function my_first_plugin_note_shortcode( $atts, $content = '' ) {
    // 1. Define default attributes
    $atts = shortcode_atts(
        array(
            'title' => 'Note:', // Default title
            'type'  => 'info',  // Default type for styling (info, warning, important)
        ),
        $atts,
        'note' // The name of the shortcode
    );

    // 2. Prepare CSS class based on the type attribute
    $note_class = 'my-plugin-note-box ' . sanitize_html_class( $atts['type'] );

    // 3. Construct the HTML output
    $output = '<div class="' . esc_attr( $note_class ) . '">';
    $output .= '<strong>' . esc_html( $atts['title'] ) . '</strong>';
    $output .= do_shortcode( $content ); // Process any shortcodes inside the note content
    $output .= '</div>';

    return $output;
}

// ------------------------------------------
// 2. REGISTER THE SHORTCODE
// ------------------------------------------
add_shortcode( 'note', 'my_first_plugin_note_shortcode' );


/**
 * Enqueue the custom CSS file for the note shortcode.
 */
function my_first_plugin_enqueue_styles() {
    wp_enqueue_style(
        'my-plugin-note-style', // Unique handle
        plugins_url( 'css/note-style.css', __FILE__ ) // Path to the CSS file
    );
}
add_action( 'wp_enqueue_scripts', 'my_first_plugin_enqueue_styles' );