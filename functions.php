<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Prime Location', 'prime-location' ) );
define( 'CHILD_THEME_URL', 'http://www.agentevolution.com/shop/prime-location/' );
define( 'CHILD_THEME_VERSION', '1.0.9' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'prime-location', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'prime-location' ) );

//* Add Theme Support
add_theme_support( 'equity-top-header-bar' );
add_theme_support( 'equity-after-entry-widget-area' );

//* Add rectangular size image for featured posts/pages
add_image_size( 'featured-post', '700', '370', true);

//* Create additional color style options
add_theme_support( 'equity-style-selector', array(
	'prime-location-green'   => __( 'Green', 'prime-location' ),
	'prime-location-red'     => __( 'Red', 'prime-location' ),
	'prime-location-blue'    => __( 'Blue', 'prime-location' ),
	'prime-location-purple'  => __( 'Purple', 'prime-location' ),
	'prime-location-magenta' => __( 'Magenta', 'prime-location' ),
	'prime-location-custom'  => __( 'Use Customizer', 'prime-location' ),
) );

//* Load fonts 
add_filter( 'equity_google_fonts', 'prime_location_fonts' );
function prime_location_fonts( $equity_google_fonts ) {
	$equity_google_fonts = 'Lato:400,700,400italic|Oswald:300';
	return $equity_google_fonts;
}

// Add class to body for easy theme identification.
add_filter( 'body_class', 'add_theme_body_class' );
function add_theme_body_class( $classes ) {
	$classes[] = 'home-theme--prime-location';
	return $classes;
}

//* Load backstretch.js
add_action( 'wp_enqueue_scripts', 'prime_location_register_scripts' );
function prime_location_register_scripts() {
	if ( is_home() ) {
		wp_enqueue_script( 'jquery-backstretch', get_stylesheet_directory_uri() . '/lib/js/jquery.backstretch.min.js', array('jquery'), '2.0.4', true);
	}

	//* Enable sticky header if checked in customizer
	if ( get_theme_mod('enable_sticky_header') == true  && !wp_is_mobile() ) {
		wp_enqueue_script( 'sticky-header', get_stylesheet_directory_uri() . '/lib/js/sticky-header.js', array('jquery'), '1.0', true);
	}

	// Fix for mobile nav menu behavior
	wp_enqueue_script( 'mobile-nav-menu-fix', get_stylesheet_directory_uri() . '/lib/js/mobile-nav-menu-fix.js', null, true);
}

/**
 * Menu_fix_css function.
 *
 * Corrects menu behavior on mobile devices.
 */
function menu_fix_css() {
	echo '<style type="text/css">@media only screen and (max-width: 640px){.top-bar-section ul .menu-item-has-children .mobile-nav-link-overlay{position:absolute;left:0;top:0;width:55%;height:100%;opacity:0;}}</style>';
}
add_action( 'wp_head', 'menu_fix_css' );

//* Output backstretch call with custom or default image to wp_footer
add_action('wp_footer', 'prime_location_backstretch_js', 9999);
function prime_location_backstretch_js() {

	if( !is_home() )
		return;

	$background_url = get_theme_mod('default_background_image', get_stylesheet_directory_uri() . '/images/bkg-default.jpg' );
	?>
		<script>jQuery.backstretch("<?php echo $background_url; ?>");</script>
	<?php
}

/**
 * Filter header right menu args to limit depth and add custom walker
 * @param array $args arguments for building the nav menu
 */
add_filter( 'wp_nav_menu_args', 'equity_child_header_menu_args', 10, 1 );
function equity_child_header_menu_args( $args ) {

	if ( 'header-right' == $args['theme_location'] ) {
		$args['depth'] = 3;
		//$args['walker'] = new Description_Plus_Icon_Walker;
	}

	return $args;
}

//* Remove default primary nav and add header right nav
add_theme_support( 'equity-menus', array( 'header-right' => __( 'Header Right', 'prime-location' ), 'top-header-right' => __( 'Top Header Right', 'prime-location' ) ) );

//* Redefine top header widget width
add_filter( 'top_header_left_widget_widths', 'prime_location_top_header_left_width');
function prime_location_top_header_left_width() {
	$top_header_left_widget_widths = 'small-12 medium-4 large-4';
	return $top_header_left_widget_widths;
}

//* Add sticky header wrap markup
add_action( 'equity_before_header', 'prime_location_sticky_header_open', 1 );
add_action( 'equity_after_header', 'prime_location_sticky_header_close' );
function prime_location_sticky_header_open() {
	echo '<div class="sticky-header">';
}
function prime_location_sticky_header_close() {
	echo '</div><!-- end .sticky-header -->';
}

// Filter post title output
add_filter( 'equity_post_title_output', 'prime_location_post_title_output', 15 );
function prime_location_post_title_output( $title ) {
	if ( is_singular() )
		$title = sprintf( '<h1 class="entry-title" itemprop="headline"><span>%s</span></h1>', apply_filters( 'equity_post_title_text', get_the_title() ) );

	return $title;
}

//* Filter listing scroller widget prev/next links
add_filter( 'listing_scroller_prev_link', 'child_listing_scroller_prev_link');
function child_listing_scroller_prev_link( $listing_scroller_prev_link_text ) {
	$listing_scroller_prev_link_text = __( '<i class=\"fas fa-caret-left\"></i><span>Prev</span>', 'prime-location' );
	return $listing_scroller_prev_link_text;
}
add_filter( 'listing_scroller_next_link', 'child_listing_scroller_next_link');
function child_listing_scroller_next_link( $listing_scroller_next_link_text ) {
	$listing_scroller_next_link_text = __( '<i class=\"fas fa-caret-right\"></i><span>Next</span>', 'prime-location' );
	return $listing_scroller_next_link_text;
}
//* Filter IDX listing carousel widget prev/next links
add_filter( 'idx_listing_carousel_prev_link', 'child_idx_listing_carousel_prev_link');
function child_idx_listing_carousel_prev_link( $idx_listing_carousel_prev_link_text ) {
	$idx_listing_carousel_prev_link_text = __( '<i class=\"fas fa-caret-left\"></i><span>Prev</span>', 'prime-location' );
	return $idx_listing_carousel_prev_link_text;
}
add_filter( 'idx_listing_carousel_next_link', 'child_idx_listing_carousel_next_link');
function child_idx_listing_carousel_next_link( $idx_listing_carousel_next_link_text ) {
	$idx_listing_carousel_next_link_text = __( '<i class=\"fas fa-caret-right\"></i><span>Next</span>', 'prime-location' );
	return $idx_listing_carousel_next_link_text;
}
//* Filter Equity page carousel widget prev/next links
add_filter( 'equity_page_carousel_prev_link', 'child_equity_page_carousel_prev_link');
function child_equity_page_carousel_prev_link( $equity_page_carousel_prev_link_text ) {
	$equity_page_carousel_prev_link_text = __( '<i class=\"fas fa-caret-left\"></i><span>Prev</span>', 'prime-location' );
	return $equity_page_carousel_prev_link_text;
}
add_filter( 'equity_page_carousel_next_link', 'child_equity_page_carousel_next_link');
function child_equity_page_carousel_next_link( $equity_page_carousel_next_link_text ) {
	$equity_page_carousel_next_link_text = __( '<i class=\"fas fa-caret-right\"></i><span>Next</span>', 'prime-location' );
	return $equity_page_carousel_next_link_text;
}

//* Set default footer widgets to 4
if ( get_theme_mod( 'footer_widgets' ) == '' ) {
	set_theme_mod( 'footer_widgets', 4 );
}

//* Register widget areas
equity_register_widget_area(
	array(
		'id'          => 'home-lead',
		'name'        => __( 'Home Lead', 'prime-location' ),
		'description' => __( 'This is the Lead section of the Home page. Recommended to use an IDX Map Search widget or Slider. If using IDX Map Search be sure to copy all the required additional scripts.', 'prime-location' ),
	)
);
equity_register_widget_area(
	array(
		'id'           => 'home-top',
		'name'         => __( 'Home Top', 'prime-location' ),
		'description'  => __( 'This is the Top section of the Home page below the map/slider. Recommended to use icon boxes in columns followed by the Equity - IDX Property Carousel.', 'prime-location' ),
		'before_title' => '<h4 class="widget-title widgettitle"><span>',
		'after_title'  => '</span></h4>'
	)
);
equity_register_widget_area(
	array(
		'id'          => 'home-middle',
		'name'        => __( 'Home Middle', 'prime-location' ),
		'description' => __( 'This is the Middle section of the Home page. The content here displays against the homepage background image. Recommended to add a testimonial shortcode in a text widget.', 'prime-location' ),
	)
);
equity_register_widget_area(
	array(
		'id'          => 'home-bottom',
		'name'        => __( 'Home Bottom', 'prime-location' ),
		'description' => __( 'This is the Bottom section of the Home page. Recommended to use the Equity - Featured Page Carousel or other widget.', 'prime-location' ),
		'before_title'  => '<h4 class="widget-title widgettitle"><span>',
		'after_title'   => '</span></h4>'
	)
);

//* Default widget content
if ( ! is_active_sidebar( 'top-header-left' ) ) {
	add_action('equity_top_header_left', 'top_header_left_default_widget');
}
function top_header_left_default_widget() {
	the_widget( 'WP_Widget_Text', array( 'text' => '[agent_phone] [agent_email]') );
}

//* Home page - define home page widget areas for welcome screen display check
add_filter('equity_theme_widget_areas', 'prime_location_home_widget_areas');
function prime_location_home_widget_areas($active_widget_areas) {
	$active_widget_areas = array( 'home-top' );
	return $active_widget_areas;
}

//* Home page - markup and default widgets
function equity_child_home() {
	?>

	<div class="home-lead">
		<div class="row">
			<div class="columns small-12">
			<?php equity_widget_area( 'home-lead' ); ?>
			</div><!-- end .columns .small-12 -->
		</div><!-- .end .row -->
	</div><!-- end .home-lead -->

	<div class="home-top">
		<div class="row">
			<div class="columns small-12">
			<?php
				if ( ! is_active_sidebar( 'home-top' ) ) {
					the_widget( 'WP_Widget_Text', array( 'title' => 'Home Top', 'text' => 'Add icon boxes for calls to action, featured properties, or other widgets.'), array( 'before_widget' => '<aside class="widget-area">', 'after_widget' => '</aside>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>' ) );
					
				} else {
					equity_widget_area( 'home-top' );
				}
			?>
			</div><!-- end .columns .small-12 -->
		</div><!-- .end .row -->
	</div><!-- end .home-top -->

	<div class="home-middle bg-alt">
		<div class="row">
			<div class="columns small-12">
			<?php equity_widget_area( 'home-middle' ); ?>
			</div><!-- end .columns .small-12 -->
		</div><!-- .end .row -->
	</div><!-- end .home-middle -->

	<div class="home-bottom">
		<div class="row">
			<div class="columns small-12">
			<?php equity_widget_area( 'home-bottom' ); ?>
			</div><!-- end .columns .small-12 -->
		</div><!-- .end .row -->
	</div><!-- end .home-bottom -->

<?php
}

//* Includes

# Theme Customizatons
require_once get_stylesheet_directory() . '/lib/customizer.php';