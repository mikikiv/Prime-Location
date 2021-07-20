jQuery(document).foundation( {
	equalizer : {
	// Specify if Equalizer should make elements equal height once they become stacked.
	equalize_on_stack: false
	}
});

jQuery(function( $ ){

	// Enable responsive menu icon for mobile
	$("ul.menu-header-right").addClass("responsive-menu").before('<i id="responsive-menu-icon" class="fas fa-bars"></i>');

	$("#responsive-menu-icon").click(function(){
		$("ul.menu-header-right").slideToggle();
	});

	$(window).resize(function(){
		if(window.innerWidth > 979) {
			$("ul.menu-header-right").removeAttr("style");
		}
	});

});