function equalHeights() {
	// reset
	jQuery( "ul.products .product" ).css( "height", "auto" );
	//get elements
	var elements = [];
	jQuery( "ul.products .product" ).each( function () {
		elements.push( this )
	} );
	//equalize each emelemt separately
	var max_height = 0;
	jQuery( elements ).each( function () {
		max_height = max_height > jQuery( this ).height() ? max_height : jQuery( this ).height();
	} );
	jQuery( elements ).each( function () {
		jQuery( elements ).height( max_height );
	} );
};

jQuery( window ).load( function () {
	equalHeights();
} );

jQuery( window ).on( "resize", function () {
	equalHeights();
} );

// Overlay
jQuery( "ul.products li" ).hover( function () {
	var $this = jQuery( this ).addClass( 'product-hover' ),
		link = $this.find( 'a:first' ).attr( 'href' );//get link

	$this.append( '<a href="' + link + '" class="tve-product-details-btn">' + ThriveApp.translations.ProductDetails + '</a>' );

}, function () {
	jQuery( this ).removeClass( 'product-hover' ).find( '.tve-product-details-btn' ).remove();
} );
// checkout uncheck "Ship to different address?"
jQuery( '#ship-to-different-address-checkbox' ).attr( 'checked', false );