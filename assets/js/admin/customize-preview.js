/**
 * Theme Customizer postMessage handler.
 *
 * @param {jQuery} $
 */
( function( $ ) {
	'use strict';

	if ( undefined !== sukiCustomizerPreviewData ) {
		if ( undefined !== sukiCustomizerPreviewData.postMessages ) {
			let fonts = {};

			// Flatten fonts list.
			Object.keys( sukiCustomizerPreviewData.fonts ).forEach( function( groupLabel ) {
				const fontsInThisGroup = sukiCustomizerPreviewData.fonts[ groupLabel ];

				fonts = { ...fonts, ...fontsInThisGroup };
			} );

			/**
			 * PostMessage: Output CSS.
			 *
			 * @param {string} key
			 * @param {Array}  rules
			 * @param {string} newValue
			 */
			const postMessageCSS = function( key, rules, newValue ) {
				const styleID = 'suki-customize-preview-css-' + key;
				const cssArray = {};
				let $style = $( '#' + styleID );
				let css = '';

				if ( '' !== newValue ) {
					// Create <style> tag if doesn't exist.
					if ( 0 === $style.length ) {
						$style = $( document.createElement( 'style' ) );
						$style.attr( 'id', styleID );
						$style.attr( 'type', 'text/css' );

						// Append <style> tag to <head>.
						$style.appendTo( $( 'head' ) );
					}

					rules.forEach( function( rule ) {
						let value = newValue;
						let formattedValue;

						// Convert array value into string.
						if ( Array.isArray( value ) ) {
							let sanitizedValue = [];

							sanitizedValue = value.map( function( subvalue ) {
								return '' === subvalue ? 0 : subvalue;
							} );

							value = sanitizedValue.join( ' ' );
						}

						if ( rule.function && rule.function.name ) {
							switch ( rule.function.name ) {
								case 'explode_value':
									if ( undefined === rule.function.args[ 0 ] ) {
										break;
									}

									const index = rule.function.args[ 0 ];

									if ( isNaN( index ) ) {
										break;
									}

									const array = value.split( ' ' );

									value = undefined !== array[ index ] ? array[ index ] : '';
									break;

								case 'scale_dimensions':
									if ( undefined === rule.function.args[ 0 ] ) {
										break;
									}

									const scale = rule.function.args[ 0 ];

									if ( isNaN( scale ) ) {
										break;
									}

									const parts = value.split( ' ' );
									let newParts;

									parts.forEach( function( part, i ) {
										const number = parseFloat( part );
										const unit = part.replace( number, '' );

										newParts[ i ] = ( number * scale ).toString() + unit;
									} );

									// Build new value.
									value = newParts.join( ' ' );
									break;
							}
						}

						if ( undefined === rule.element || undefined === rule.property ) {
							return;
						}

						rule.media = rule.media || 'global';
						rule.pattern = rule.pattern || '$';

						// Check if "key" attribute is defined and value is an assosiative array.
						if ( 'object' === typeof value ) {
							if ( undefined !== rule.key && undefined !== value[ rule.key ] ) {
								// Fetch the property value using the key from setting value.
								formattedValue = rule.pattern.replace( '$', value[ rule.key ] );
							} else {
								let concatValue;
								value.forEach( function( valueItem ) {
									concatValue.push( rule.pattern.replace( '$', valueItem ) );
								} );
								formattedValue = concatValue.join( ' ' );
							}
						} else {
							// Define new value based on the specified pattern.
							formattedValue = rule.pattern.replace( '$', value );
						}

						// Define properties.
						if ( undefined === cssArray[ rule.media ] ) {
							cssArray[ rule.media ] = {};
						}
						if ( undefined === cssArray[ rule.media ][ rule.element ] ) {
							cssArray[ rule.media ][ rule.element ] = {};
						}

						// Save the value into a formatted array.
						cssArray[ rule.media ][ rule.element ][ rule.property ] = formattedValue;
					} );

					// Loop into the sorted array to build CSS string.
					Object.keys( cssArray ).forEach( function( media ) {
						const selectors = cssArray[ media ];

						if ( 'global' !== media ) {
							css += media + '{';
						}

						Object.keys( selectors ).forEach( function( selector ) {
							const properties = selectors[ selector ];

							css += selector + '{';

							Object.keys( properties ).forEach( function( property ) {
								const value = properties[ property ];

								css += property + ':' + value + ';';
							} );

							css += '}';
						} );

						if ( 'global' !== media ) {
							css += '}';
						}
					} );
				}

				// Add CSS string to <style> tag.
				$style.html( css );
			};

			/**
			 * PostMessage: Change class.
			 *
			 * @param {string} key
			 * @param {Array}  rules
			 * @param {string} newValue
			 */
			const postMessageClass = function( key, rules, newValue ) {
				rules.forEach( function( rule ) {
					let value = newValue;

					if ( 'boolean' === typeof ( value ) ) {
						value = value ? 1 : 0;
					}

					if ( undefined === rule.element ) {
						return;
					}

					rule.pattern = rule.pattern || '$';

					const elements = Array.prototype.slice.call( document.querySelectorAll( rule.element ) );
					const regex = new RegExp( rule.pattern.replace( '$', '[\\w\\-]+' ), 'i' );
					const formattedValue = rule.pattern.replace( '$', value );

					// Change class on all targeted elements.
					elements.forEach( function( element ) {
						if ( element.className.match( regex ) ) {
							element.className = element.className.replace( regex, formattedValue );
						} else {
							element.className += ' ' + formattedValue;
						}
					} );
				} );
			};

			/**
			 * PostMessage: Change HTML.
			 *
			 * @param {string} key
			 * @param {Array}  rules
			 * @param {string} newValue
			 */
			const postMessageHTML = function( key, rules, newValue ) {
				rules.forEach( function( rule ) {
					const value = newValue;

					if ( undefined === rule.element ) {
						return;
					}

					rule.pattern = rule.pattern || '$';

					const elements = Array.prototype.slice.call( document.querySelectorAll( rule.element ) );
					const formattedValue = rule.pattern.replace( '$', value );

					// Change innerHTML on all targeted elements.
					elements.forEach( function( element ) {
						if ( undefined !== rule.property ) {
							element.setAttribute( rule.property, formattedValue );
						} else {
							element.innerHTML = formattedValue;
						}
					} );
				} );
			};

			/**
			 * PostMessage: Embed font to page and set font-family CSS.
			 *
			 * @param {string} key
			 * @param {Array}  rules
			 * @param {string} newValue
			 */
			const postMessageFont = function( key, rules, newValue ) {
				// Fallback compatibility for prior v2.
				if ( -1 !== newValue.indexOf( '|' ) ) {
					newValue = newValue.replace( '/.*?\|/', '' );
				}

				const fontStack = fonts[ newValue ] || '';

				// Change CSS value.
				postMessageCSS( key, rules, fontStack );
			};

			Object.keys( sukiCustomizerPreviewData.postMessages ).forEach( function( key ) {
				const settingPostMessages = sukiCustomizerPreviewData.postMessages[ key ];
				const settingPostMessagesByType = {};

				settingPostMessages.forEach( function( rule ) {
					const type = rule.type;

					if ( undefined === settingPostMessagesByType[ type ] ) {
						settingPostMessagesByType[ type ] = [];
					}

					settingPostMessagesByType[ type ].push( rule );
				} );

				wp.customize( key, function( setting ) {
					// Bind setting value change.
					setting.bind( function( value ) {
						// Process each postMessages type (CSS, class, HTML, font).
						Object.keys( settingPostMessagesByType ).forEach( function( type ) {
							switch ( type ) {
								case 'css':
									postMessageCSS( key, settingPostMessagesByType[ type ], value );
									break;

								case 'class':
									postMessageClass( key, settingPostMessagesByType[ type ], value );
									break;

								case 'html':
									postMessageHTML( key, settingPostMessagesByType[ type ], value );
									break;

								case 'font':
									postMessageFont( key, settingPostMessagesByType[ type ], value );
									break;
							}
						} );
					} );
				} );
			} );
		}
	}
}( jQuery ) );
