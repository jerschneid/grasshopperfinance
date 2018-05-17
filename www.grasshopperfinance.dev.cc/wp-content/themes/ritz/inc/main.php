<?php
/**
 * Load files.
 *
 * @package Ritz
 */

// Load default values.
require_once trailingslashit( get_template_directory() ) . '/inc/defaults.php';

// Custom template tags for this theme.
require_once trailingslashit( get_template_directory() ) . '/inc/template-tags.php';

// Custom functions that act independently of the theme templates.
require_once trailingslashit( get_template_directory() ) . '/inc/extras.php';

// Load Jetpack compatibility file.
require_once trailingslashit( get_template_directory() ) . '/inc/jetpack.php';

// Customizer additions.
require_once trailingslashit( get_template_directory() ) . '/inc/customizer.php';

// Load hooks.
require_once trailingslashit( get_template_directory() ) . '/inc/hooks.php';

// Load widgets.
require_once trailingslashit( get_template_directory() ) . '/inc/widgets/widgets.php';