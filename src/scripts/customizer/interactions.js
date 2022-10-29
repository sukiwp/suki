wp.customize.bind( 'ready', () => {
	/**
	 * Control dependencies
	 */

	Object.keys( sukiCustomizerData.contexts ).forEach( ( elementId ) => {
		const elementType = 0 === elementId.indexOf( 'suki_section' ) ? 'section' : 'control';

		wp.customize[ elementType ]( elementId, ( elementObj ) => {
			sukiCustomizerData.contexts[ elementId ].forEach( ( rule ) => {
				const settingObj = '__device' === rule.setting ? wp.customize.previewedDevice : wp.customize( rule.setting );

				const setVisibility = function( checkedValue ) {
					let displayed = false;

					if ( undefined === rule.operator || '=' === rule.operator ) {
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
							displayed = checkedValue !== rule.value;
							break;

						case 'empty':
							displayed = 0 === checkedValue.length;
							break;

						case '!empty':
							displayed = 0 < checkedValue.length;
							break;

						default:
							displayed = checkedValue === rule.value;
							break;
					}

					let container = elementObj.container;
					if ( 'section' === elementType ) {
						container = elementObj.headContainer;
					}

					if ( displayed ) {
						container.removeClass( 'suki-context--hidden' );
					} else {
						container.addClass( 'suki-context--hidden' );

						if ( 'section' === elementType && elementObj.expanded() ) {
							elementObj.collapse();
						}
					}
				};

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
		if ( ! e.target.closest( '.suki-jump-to-control-link' ) ) {
			return;
		}

		e.preventDefault();

		const url = new URL( e.target );

		if ( url.searchParams.get( 'autofocus[control]' ) ) {
			wp.customize.control( url.searchParams.get( 'autofocus[control]' ) ).focus();
		} else if ( url.searchParams.get( 'autofocus[section]' ) ) {
			wp.customize.section( url.searchParams.get( 'autofocus[section]' ) ).focus();
		} else if ( url.searchParams.get( 'autofocus[panel]' ) ) {
			wp.customize.panel( url.searchParams.get( 'autofocus[panel]' ) ).focus();
		}
	} );

	/**
	 * Responsive tabs
	 */

	document.getElementById( 'customize-controls' ).addEventListener( 'click', ( e ) => {
		if ( ! e.target.closest( '.suki-responsive-tabs__button' ) ) {
			return;
		}

		e.preventDefault();

		const button = e.target.closest( '.suki-responsive-tabs__button' );

		wp.customize.previewedDevice.set( button.dataset.device );
	} );

	wp.customize.previewedDevice.bind( ( device ) => {
		const targetDevice = 'desktop' === device ? 'desktop' : 'tablet';
		const buttons = document.querySelectorAll( '.suki-responsive-tabs__button' );

		buttons.forEach( ( button ) => {
			if ( targetDevice === button.dataset.device ) {
				button.classList.add( 'nav-tab-active', 'active' );
			} else {
				button.classList.remove( 'nav-tab-active', 'active' );
			}
		} );
	} );
} );
