$(function() {

$('#loading').hide();
$('#a-registro').show();
$('#a-descarga').show();
$('#a-login').show();
$('#a-cerrar').hide();

$( window ).load( function() {

					$( '.sldr' ).each( function() {
						var th = $( this );
						th.sldr({
							focalClass    : 'focalPoint',
							offset        : th.width()/2,
							sldrWidth     : 'auto',
							nextSlide     : th.nextAll( '.sldr-nav.next:first' ),
							previousSlide : th.nextAll( '.sldr-nav.prev:first' ),
							selectors     : th.nextAll( '.selectors:first' ).find( 'li' ),
							toggle        : th.nextAll( '.captions:first' ).find( 'div' ),
							sldrInit      : sliderInit,
							sldrStart     : slideStart,
							sldrComplete  : slideComplete,
							sldrLoaded    : sliderLoaded,
							sldrAuto      : true,
							sldrTime      : 3000,
							hasChange     : true
						});
					});

				});
				function sliderInit( args ) {

				}

				/**
				 * When individual slides are loaded
				 * @param {object} args the slides, callback, and config of the slider
				 * @return null
				 */
				function slideLoaded( args ) {

				}

				/**
				 * When the full slider is loaded, after the DOM is manipulated
				 * @param {object} args the slides, callback, and config of the slider
				 * @return null
				 */
				function sliderLoaded( args ) {

				}

				/**
				 * Before the slides change focal points
				 * @param {object} args the slides, callback, and config of the slider
				 * @return null
				 */
				function slideStart( args ) {

				}

				/**
				 * After the slides are done changing focal points
				 * @param {object} args the slides, callback, and config of the slider
				 * @return null
				 */
				function slideComplete( args ) {

				}
});