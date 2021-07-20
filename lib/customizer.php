<?php
/* Adds Customizer options for Prime Location
 */

class PRIME_LOCATION_Customizer extends EQUITY_Customizer_Base {

	/**
	 * Register theme specific customization options
	 */
	public function register( $wp_customize ) {

		$this->colors( $wp_customize );
		$this->background( $wp_customize );
		$this->misc( $wp_customize );
		
	}
	
	//* Colors
	private function colors( $wp_customize ) {
		$wp_customize->add_section(
			'colors',
			array(
				'title'    => __( 'Custom Colors', 'prime-location'),
				'priority' => 200,
			)
		);

		//* Setting key and default value array
		$settings = array(
			'primary_color'       => '',
			'primary_color_hover' => '',
			'primary_color_light' => '',
		);

		foreach ( $settings as $setting => $default ) {

			$wp_customize->add_setting(
				$setting,
				array(
					'default' => $default,
					// 'sanitize_callback' => 'sanitize_hex_color',
					'type'    => 'theme_mod'
				)
			);
		}

		//* Primary Color
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'primary_color',
				array(
					'label'       => __( 'Primary Color', 'prime-location' ),
					'description' => __( 'Used for links, buttons, headings.', 'prime-location' ),
					'section'     => 'colors',
					'settings'    => 'primary_color',
					'priority'    => 100
				)
			)
		);

		//* Primary Hover Color
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'primary_color_hover',
				array(
					'label'       => __( 'Primary Hover Color', 'prime-location' ),
					'description' => __( 'Used for hover states and borders - should be slightly darker (or lighter) than the primary color.', 'prime-location' ),
					'section'     => 'colors',
					'settings'    => 'primary_color_hover',
					'priority'    => 100
				)
			)
		);

		//* Primary Color light
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'primary_color_light',
				array(
					'label'       => __( 'Primary Color Light', 'prime-location' ),
					'description' => __( 'Used primarily for header menu borders and labels - should be lighter than the primary but in the same hue.', 'prime-location' ),
					'section'     => 'colors',
					'settings'    => 'primary_color_light',
					'priority'    => 100
				)
			)
		);

	}

	//* Home Background
	private function background( $wp_customize ) {
		$wp_customize->add_section(
			'background',
			array(
				'title'    => __( 'Home Background', 'prime-location'),
				'priority' => 201,
			)
		);

		//* Setting key and default value array
		$settings = array(
			'default_background_image' => get_stylesheet_directory_uri() . '/images/bkg-default.jpg',
		);

		foreach ( $settings as $setting => $default ) {

			$wp_customize->add_setting(
				$setting,
				array(
					'default' => $default,
					'type'    => 'theme_mod'
				)
			);
		}

		//* Default background image
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'default_background_image',
				array(
					'label'       => __( 'Default Background Image', 'open-floor-plan' ),
					'description' => __( 'Used only for the home page. <p style="font-style: normal;">Upload an image in <strong>.JPG</strong> format at least 1200x800 pixels.</p><p><strong><a href="http://www.smushit.com/ysmush.it/" target="_blank">Optimize</a></strong> your images!</p>', 'open-floor-plan' ),
					'section'     => 'background',
					'settings'    => 'default_background_image',
					'extensions'  => array( 'jpg' ),
					'priority'    => 100
				)
			)
		);
	}

	//* Misc
	private function misc( $wp_customize ) {

		//* Setting key and default value array
		$settings = array(
			'enable_sticky_header'    => false,
			'disable_site_description' => false,
		);

		foreach ( $settings as $setting => $default ) {

			$wp_customize->add_setting(
				$setting,
				array(
					'default' => $default,
					'type'    => 'theme_mod'
				)
			);
		}

		//* Enable header description
		$wp_customize->add_control(
			'disable_site_description',
			array(
				'label'    => __( 'Show site description?', 'prime-location' ),
				'section'  => 'title_tagline',
				'type'     => 'checkbox',
				'settings' => 'disable_site_description',
				'priority' => 300
			)
		);

		//* Enable sticky header checkbox
		$wp_customize->add_control(
			'enable_sticky_header',
			array(
				'label'    => __( 'Enable Sticky Header?', 'prime-location' ),
				'section'  => 'title_tagline',
				'type'     => 'checkbox',
				'settings' => 'enable_sticky_header',
				'priority' => 300
			)
		);
	}

	//* Render CSS
	public function render() {
		?>
		<!-- begin Child Customizer CSS -->
		<style type="text/css">


			<?php
			
			//* Site description
			if ( get_theme_mod('disable_site_description') ) 
				echo 'header.site-header .site-description {display: block;}';

			//* Primary color - link color
			self::generate_css( '
				a,
				.home-lead .leaflet-container a,
				.idx-content .IDX-wrapper-standard a,
				header .site-title a,
				header .site-title a:hover,
				.ae-iconbox i[class*="fa-"],
				.ae-iconbox a i[class*="fa-"],
				.showcase-property span.price,
				.widget .listing-wrap .listing-thumb-meta span,
				.equity-idx-carousel span.price,
				.home-top h4.widget-title,
				.home-bottom h4.widget-title,
				h1.entry-title
				', 'color', 'primary_color' );

			//* Icon boxes
			self::generate_css( '
				.ae-iconbox.type-2:hover i[class*="fa-"],
				.ae-iconbox.type-2:hover a i[class*="fa-"],
				.ae-iconbox.type-3:hover i[class*="fa-"],
				.ae-iconbox.type-3:hover a i[class*="fa-"]
				', 'color', 'primary_color', '', ' !important' );

			//* Primary color - backgrounds
			self::generate_css('
				.top-header,
				.button:not(.secondary),
				button:not(.secondary),
				input[type="button"],
				input[type="submit"],
				.idx-content .IDX-wrapper-standard .IDX-btn,
				.idx-content .IDX-wrapper-standard .IDX-btn-default,
				.idx-content .IDX-wrapper-standard .IDX-btn-primary,
				.IDX-wrapper-standard #IDX-newSearch,
				.IDX-wrapper-standard #IDX-saveProperty,
				.IDX-wrapper-standard .IDX-removeProperty,
				.IDX-wrapper-standard #IDX-saveSearch,
				.IDX-wrapper-standard #IDX-modifySearch,
				.IDX-wrapper-standard #IDX-submitBtn,
				.IDX-wrapper-standard #IDX-resetBtn,
				.IDX-wrapper-standard #IDX-refineSearchFormToggle,
				.IDX-wrapper-standard .IDX-panel-primary>.IDX-panel-heading,
				.IDX-wrapper-standard .IDX-navbar-default,
				.IDX-wrapper-standard .IDX-navigation,
				.home-lead .IDX-mapTab,
				.IDX-wrapper-standard .IDX-nav-pills>li.IDX-active>a,
				.IDX-wrapper-standard .IDX-nav-pills>li.IDX-active>a:focus,
				.IDX-wrapper-standard .IDX-nav-pills>li.IDX-active>a:hover,
				.IDX-wrapper-standard #IDX-mapHeader-Search,
				.ae-iconbox.type-2 i,
				.ae-iconbox.type-3 i,
				ul.pagination li.current a,
				ul.pagination li.current button,
				.bg-alt,
				.after-entry-widget-area,
				.contain-to-grid,
				.top-header,
				.top-bar,
				.top-bar.expanded .title-area,
				.top-bar-section ul li,
				.top-bar-section ul li.active > a,
				.top-bar-section .dropdown li label,
				.top-bar-section .dropdown li a,
				.top-bar-section .dropdown li:not(.has-form) a:not(.button),
				.top-bar-section li:not(.has-form) a:not(.button)
				',
				'background-color', 'primary_color', ''
			);

			self::generate_css('
				.bg-alt
				',
				'background-color', 'primary_color', ''
			);

			//* Primary color hover - hover color
			self::generate_css('
				a:hover,
				a:focus
				',
				'color', 'primary_color_hover'
			);

			//* Primary color hover - background color
			self::generate_css('
				.button:not(.secondary):hover,
				button:not(.secondary):hover,
				input[type="button"]:hover,
				input[type="submit"]:hover,
				.idx-content .IDX-wrapper-standard .IDX-btn:hover,
				.idx-content .IDX-wrapper-standard .IDX-btn-default:hover,
				.idx-content .IDX-wrapper-standard .IDX-btn-primary:hover,
				.IDX-wrapper-standard #IDX-newSearch:hover,
				.IDX-wrapper-standard #IDX-saveProperty:hover,
				.IDX-wrapper-standard .IDX-removeProperty:hover,
				.IDX-wrapper-standard #IDX-saveSearch:hover,
				.IDX-wrapper-standard #IDX-modifySearch:hover,
				.IDX-wrapper-standard #IDX-submitBtn:hover,
				.IDX-wrapper-standard #IDX-resetBtn:hover,
				.IDX-wrapper-standard #IDX-refineSearchFormToggle:hover,
				.IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-nav>.IDX-active>a,
				.IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-nav>.IDX-active>a:focus,
				.IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-nav>.IDX-active>a:hover,
				.IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-nav>li>a:focus,
				.IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-nav>li>a:hover,
				.IDX-wrapper-standard .IDX-searchNavItem a:hover,
				.bg-alt .button:hover,
				.bg-alt input[type="button"]:hover,
				.bg-alt input[type="submit"]:hover,
				.button:not(.secondary):focus,
				button:not(.secondary):focus,
				input[type="button"]:focus,
				input[type="submit"]:focus,
				ul.pagination li.current a:hover,
				ul.pagination li.current a:focus,
				ul.pagination li.current button:hover,
				ul.pagination li.current button:focus,
				.top-bar-section ul li.active > a,
				.top-bar-section li:not(.has-form):hover > a:not(.button),
				.top-bar-section .dropdown li:not(.has-form):hover > a:not(.button),
				.top-bar-section li.active:not(.has-form) a:not(.button):hover,
				.top-bar-section .dropdown li:not(.has-form):not(.active):hover > a:not(.button)
				',
				'background-color', 'primary_color_hover', '', ' !important'
			);

			//* Primary color hover - border color
			self::generate_css('
				.button,
				button,
				input[type="button"],
				input[type="submit"],
				.idx-content .IDX-wrapper-standard .IDX-panel-primary,
				.idx-content .IDX-wrapper-standard .IDX-panel-primary>.IDX-panel-heading,
				.idx-content .IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-collapse,
				.idx-content .IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-form,
				.idx-content .IDX-wrapper-standard .IDX-navbar-default
				',
				'border-color', 'primary_color'
			);

			//* Primary color light - color
			self::generate_css('
				.top-bar.expanded .toggle-topbar a,
				.top-bar-section .dropdown label
				',
				'color', 'primary_color_light'
			);

			//* Primary color light - border color
			self::generate_css('
				.top-bar-section .divider,
				.top-bar-section [role="separator"],
				.top-bar-section > ul > .divider,
				.top-bar-section > ul > [role="separator"] 
				',
				'border-color', 'primary_color_light'
			);

			?>
		</style>
		<!-- end Child Customizer CSS -->
		<?php
	}
	
}

add_action( 'init', 'prime_location_customizer_init' );
/**
 * Instantiate PRIME_LOCATION_Customizer
 * 
 * @since 1.0
 */
function prime_location_customizer_init() {
	new PRIME_LOCATION_Customizer;
}