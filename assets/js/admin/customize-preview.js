/**
 * Theme Customizer postMessage handler.
 */
(function( $ ) {
	'use strict';

	var $window = $( window ),
	    $document = $( document ),
	    $body = $( 'body' );

	var sukiCustomizer = {

		/**
		 * PostMessage: Output CSS.
		 */
		postMessage_css : function( key, rules, newValue ) {
			var styleID = 'suki-customize-preview-css-' + key,
			    $style = $( '#' + styleID ),
			    css = '',
			    cssArray = {};

			// Create <style> tag if doesn't exist.
			if ( 0 === $style.length ) {
				$style = $( document.createElement( 'style' ) );
				$style.attr( 'id', styleID );
				$style.attr( 'type', 'text/css' );

				// Append <style> tag to <head>.
				$style.appendTo( $( 'head' ) );
			}

			_.each( rules, function( rule ) {
				var value = newValue,
				    formattedValue;

				if ( rule['function'] && rule['function']['name'] ) {

					switch ( rule['function']['name'] ) {

						case 'explode_value':
							if ( undefined === rule['function']['args'][0] ) break;

							var index = rule['function']['args'][0];

							if ( isNaN( index ) ) break;

							var array = value.split( ' ' );

							value = undefined !== array[ index ] ? array[ index ] : '';
							break;

						case 'scale_dimensions':
							if ( undefined === rule['function']['args'][0] ) break;

							var scale = rule['function']['args'][0];

							if ( isNaN( scale ) ) break;

							var parts = value.split( ' ' ),
							    newParts = [];
							_.each( parts, function( part, i ) {
								var number = parseFloat( part ),
								    unit = part.replace( number, '' );

								newParts[ i ] = ( number * scale ).toString() + unit;
							});

							// Build new value.
							value = newParts.join( ' ' );
							break;
					}
				}
				
				if ( undefined == rule['element'] || undefined == rule['property'] ) return;
				rule['media'] = rule['media'] || 'global';
				rule['pattern'] = rule['pattern'] || '$';

				// Check if "key" attribute is defined and value is an assosiative array.
				if ( 'object' == typeof value ) {
					if ( undefined !== rule['key'] && undefined !== value[ rule['key'] ] ) {
						// Fetch the property value using the key from setting value.
						formattedValue = rule['pattern'].replace( '$', value[ rule['key'] ] );
					} else {
						var concat_value = [];
						_.each( value, function( valueItem, key ) {
							concat_value.push( rule['pattern'].replace( '$', valueItem ) );
						});
						formattedValue = concat_value.join( ' ' );
					}
				} else {
					// Define new value based on the specified pattern.
					formattedValue = rule['pattern'].replace( '$', value );
				}

				// Define properties.
				if ( undefined == cssArray[ rule['media'] ] ) cssArray[ rule['media'] ] = {};
				if ( undefined == cssArray[ rule['media'] ][ rule['element' ] ] ) cssArray[ rule['media'] ][ rule['element' ] ] = {};

				// Save the value into a formatted array.
				cssArray[ rule['media'] ][ rule['element'] ][ rule['property'] ] = formattedValue;
			});

			// Loop into the sorted array to build CSS string.
			_.each( cssArray, function( elements, media ) {
				if ( 'global' !== media ) css += media + '{';
				_.each( elements, function( properties, element ) {
					css += element + '{';
					_.each( properties, function( value, property ) {
						css += property + ':' + value + ';';
					});
					css += '}';
				});
				if ( 'global' !== media ) css += '}';
			});

			// Add CSS string to <style> tag.
			$style.html( css );
		},

		/**
		 * PostMessage: Change class.
		 */
		postMessage_class : function( key, rules, newValue ) {
			_.each( rules, function( rule ) {
				var value = newValue;

				if ( 'boolean' == typeof( value ) ) {
					value = value ? 1 : 0;
				}

				if ( undefined == rule['element'] ) return;
				rule['pattern'] = rule['pattern'] || '$';

				var elements = document.querySelectorAll( rule['element'] ),
				    regex = new RegExp( rule['pattern'].replace( '$', '[\\w\\-]+' ), 'i' ),
				    formattedValue = rule['pattern'].replace( '$', value );

				// Change class on all targeted elements.
				elements.forEach(function( element ) {
					if ( element.className.match( regex ) ) {
						element.className = element.className.replace( regex, formattedValue );
					} else {
						element.className += ' ' + formattedValue;
					}
				});
			});
		},

		/**
		 * PostMessage: Change HTML.
		 */
		postMessage_html : function( key, rules, newValue ) {
			_.each( rules, function( rule ) {
				var value = newValue;

				if ( undefined == rule['element'] ) return;
				rule['pattern'] = rule['pattern'] || '$';

				var elements = document.querySelectorAll( rule['element'] ),
				    formattedValue = rule['pattern'].replace( '$', value );

				// Change innerHTML on all targeted elements.
				elements.forEach(function( element ) {
					if ( undefined !== rule['property'] ) {
						element.setAttribute( rule['property'], formattedValue );
					} else {
						element.innerHTML = formattedValue;
					}
				});
			});
		},

		/**
		 * PostMessage: Embed font to page and set font-family CSS.
		 */
		postMessage_font : function( key, rules, newValue ) {
			var fontSource = 'custom_fonts',
			    fontName = newValue,
			    fontStack = newValue;

			// If value is not '' and has valid format, process it.
			if ( -1 < newValue.indexOf( '|' ) ) {
				// Try to convert value into "font provider" and "font name".
				var chunks = newValue.split( '|' );

				// If valid format, replace the variable values.
				if ( 2 === chunks.length && undefined !== sukiCustomizerPreviewData.fonts[ chunks[0] ] ) {
					fontSource = chunks[0],
					fontName = chunks[1],
					fontStack = sukiCustomizerPreviewData.fonts[ fontSource ][ fontName ] || '';
				}
			}

			// Change CSS value.
			sukiCustomizer.postMessage_css( key, rules, fontStack );

			// If value is from Google Fonts, update the embed link.
			if ( 'google_fonts' === fontSource ) {
				// Get the <link> tag.		
				var googleFontsLinkID = 'suki-customize-preview-google-fonts-css-' + key,
				    $googleFontsLink = $( '#' + googleFontsLinkID );

				// Create <link> tag if doesn't exist.
				if ( 0 === $googleFontsLink.length ) {
					$googleFontsLink = $( document.createElement( 'link' ) );
					$googleFontsLink.attr( 'id', googleFontsLinkID );
					$googleFontsLink.attr( 'rel', 'stylesheet' );
					$googleFontsLink.attr( 'href', '' );
					$googleFontsLink.attr( 'type', 'text/css' );
					$googleFontsLink.attr( 'media', 'all' );

					// Append <link> tag to <head>.
					$googleFontsLink.appendTo( $( 'head' ) );
				}

				var fontFamily = fontName.replace( ' ', '+' ),
				    variants = '100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i',
				    subsets = wp.customize( 'google_fonts_subsets' ).get(),
				    href = '//fonts.googleapis.com/css?family=' + fontFamily + ':' + variants + '&subset=' + subsets.join( ',' );

				// Set new href on preview's Google Fonts CSS.
				$googleFontsLink.attr( 'href', href );
			}
		},

	};
	
	if ( undefined !== sukiCustomizerPreviewData ) {
		if ( undefined !== sukiCustomizerPreviewData.postMessages ) {
			_.each( sukiCustomizerPreviewData.postMessages, function( postMessages, key ) {
				var sortedPostMessages = {};

				_.each( postMessages, function( rule ) {
					var type = rule['type'];

					if ( undefined == sortedPostMessages[ type ] ) sortedPostMessages[ type ] = [];

					sortedPostMessages[ type ].push( rule );
				});

				wp.customize( key, function( setting ) {
					setting.bind(function( value ) {
						_.each( sortedPostMessages, function( rule, type ) {
							var functionName = 'postMessage_'.concat( type );
							sukiCustomizer[ functionName ]( key, rule, value );
						});
					});
				});
			});
		}
	}

})( jQuery );