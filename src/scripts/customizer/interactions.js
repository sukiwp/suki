wp.customize.bind( 'ready', () => {
	/**
	 * Control dependencies
	 */

	Object.keys( SukiCustomizerData.contexts ).forEach( ( elementId ) => {
		const elementType = 0 === elementId.indexOf( 'suki_section' ) ? 'section' : 'control';

		wp.customize[ elementType ]( elementId, ( elementObj ) => {
			SukiCustomizerData.contexts[ elementId ].forEach( ( rule, i ) => {
				const settingObj = '__device' === rule.setting ? wp.customize.previewedDevice : wp.customize( rule.setting );

				const setVisibility = function( checkedValue ) {
					let displayed = false;

					if ( undefined == rule.operator || '=' == rule.operator ) {
						rule.operator = '==';
					}

					switch ( rule.operator ) {
						case '>':
							displayed = checkedValue > rule.value; 
							break;

						case '<':
							displayed = checkedValue < rule.value; 
							break;

						case '>=':
							displayed = checkedValue >= rule.value; 
							break;

						case '<=':
							displayed = checkedValue <= rule.value; 
							break;

						case 'in':
							displayed = 0 <= rule.value.indexOf( checkedValue );
							break;

						case 'not_in':
							displayed = 0 > rule.value.indexOf( checkedValue );
							break;

						case 'contain':
							displayed = 0 <= checkedValue.indexOf( rule.value );
							break;

						case 'not_contain':
							displayed = 0 > checkedValue.indexOf( rule.value );
							break;

						case '!=':
							displayed = checkedValue != rule.value;
							break;

						case 'empty':
							displayed = 0 == checkedValue.length;
							break;

						case '!empty':
							displayed = 0 < checkedValue.length;
							break;

						default:
							displayed = checkedValue == rule.value;
							break;
					}

					let container = elementObj.container;
					if ( 'section' === elementType ) {
						container = elementObj.headContainer;
					}

					if ( displayed ) {
						container.show();
					} else {
						container.hide();

						if ( 'section' === elementType && elementObj.expanded() ) {
							elementObj.collapse();
						}
					}
				}

				if ( undefined !== settingObj ) {
					if ( '__device' !== rule.setting ) {
						setVisibility( settingObj.get() );
					}

					// Bind the setting for future use.
					settingObj.bind( setVisibility );
				}
			} );
		} );
	} );

	/**
	 * "Go to control / section" link
	 */

	document.getElementById( 'customize-controls' ).addEventListener( 'click', ( e ) => {
		if ( ! e.target.matches( '.suki-customize-autofocus-link' ) ) {
			return;
		}

		e.preventDefault();

		const url = new URL( e.target );
		
		if ( targetControl = url.searchParams.get( 'autofocus[control]' ) ) {
			wp.customize.control( targetControl ).focus();
		}

		else if ( targetSection = url.searchParams.get( 'autofocus[section]' ) ) {
			wp.customize.section( targetSection ).focus();
		}

		else if ( targetPanel = url.searchParams.get( 'autofocus[panel]' ) ) {
			wp.customize.panel( targetPanel ).focus();
		}
	} );
} );