/**
 * Customizer Preview's post messages
 */
if ( undefined !== sukiCustomizerPreviewData && undefined !== sukiCustomizerPreviewData.postMessages ) {
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
		let $style = document.getElementById( styleID );
		let css = '';

		// Create <style> tag if doesn't exist.
		if ( ! $style ) {
			$style = document.createElement( 'style' );
			$style.id = styleID;
			$style.type = 'text/css';

			// Append <style> tag to <head>.
			document.head.appendChild( $style );
		}

		let value = newValue;

		// Convert array value into string.
		if ( Array.isArray( value ) ) {
			if ( '' === value.join( '' ).trim() ) {
				// If all values are empty then set value to empty string.
				value = '';
			} else {
				// If one of the values are not empty, iterate through the values and convert every empty string to '0'.
				value = value.map( function( subValue ) {
					return '' === subValue ? 0 : subValue;
				} ).join( ' ' );
			}
		}

		// If value is an empty string, reset CSS and then abort.
		if ( '' === value ) {
			$style.textContent = '';
			return;
		}

		rules.forEach( function( rule ) {
			let formattedValue;

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
					const propValue = properties[ property ];

					css += property + ':' + propValue + ';';
				} );

				css += '}';
			} );

			if ( 'global' !== media ) {
				css += '}';
			}
		} );

		// Add CSS string to <style> tag.
		$style.textContent = css;
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

			const elements = [ ...document.querySelectorAll( rule.element ) ];
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

			const elements = [ ...document.querySelectorAll( rule.element ) ];
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

		const fontStack = sukiCustomizerPreviewData.fonts[ newValue ] || '';

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

/**
 * Reinit frontend JS after partial refresh
 */
document.addEventListener( 'DOMContentLoaded', function() {
	if ( 'undefined' !== typeof wp && wp.customize && wp.customize.selectiveRefresh && wp.customize.widgetsPreview && wp.customize.widgetsPreview.WidgetPartial ) {
		wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function( placement ) {
			// Nav Menu
			if ( placement.partial.id.indexOf( 'nav_menu_instance' ) ) {
				suki.initAll();
			}
		} );
	}
} );
