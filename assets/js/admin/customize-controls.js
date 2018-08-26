/**
 * Theme Customizer custom controls handlers
 */
;jQuery.noConflict();

(function( exports, $ ) {
	"use strict";

	var $window = $( window ),
	    $document = $( document ),
	    $body = $( 'body' );

	if ( undefined == getUrlParameter ) {
		var getUrlParameter = function( name, url ) {
			url = decodeURI( url );
			name = name.replace( /[\[]/, '\\[' ).replace( /[\]]/, '\\]' );

			var regex = new RegExp( '[\\?&]' + name + '=([^&#]*)' ),
			    results = regex.exec( url );

			return results === null ? '' : decodeURIComponent( results[1].replace( /\+/g, ' ' ) );
		};
	}

	/**
	 * Improve input type number behavior for better UX
	 */
	// Trigger change on all number input fields when "enter" key is pressed.
	var inputNumberValidation = function( e ) {
		var input = e.target;

		if ( '' === input.value ) {
			$( input ).trigger( 'change' );
			return;
		}

		if ( '' !== input.step ) {
			// Validate step / increment value.
			var split = input.step.toString().split( '.' ),
			    decimalCount = 0;

			// Detect decimal number.
			if ( undefined !== split[1] ) {
				decimalCount = split[1].length;
			}
			
			// Check if value mod step is not 0, then round the value to nearest valid value.
			if ( ! Number.isInteger( Number( input.value ) / Number( input.step ) ) ) {
				input.value = Math.round( Number( input.value ) / Number( input.step ), decimalCount ) * Number( input.step );
			}
		}
		
		// Validate maximum value.
		if ( '' !== input.max ) {
			input.value = Math.min( Number( input.value ), Number( input.max ) );
		}

		// Validate minimum value.
		if ( '' !== input.min ) {
			input.value = Math.max( Number( input.value ), Number( input.min ) );
		}

		$( input ).trigger( 'change' );
	}

	// $( '#customize-theme-controls' ).on( 'blur', 'input[type="number"]', inputNumberValidation );
	$( '#customize-theme-controls' ).on( 'keyup', 'input[type="number"]', function( e ) {
		if ( 13 == e.which ) {
			inputNumberValidation( e );
		}
	});
	// Disable mousewheel scroll when input is in focus.
	$( '#customize-theme-controls' ).on( 'focus', 'input[type="number"]', function( e ) {
		$( this ).on( 'mousewheel.disableScroll', function ( e ) { e.preventDefault(); });
	});
	$( '#customize-theme-controls' ).on( 'blur', 'input[type="number"]', function( e ) {
		$( this ).off( 'mousewheel.disableScroll' );
	});

	/**
	 * Contentless sections like: suki-section-spacer, suki-section-pro-teaser, suki-section-pro-link
	 */
	wp.customize.sectionConstructor['suki-section-pro-teaser'] =
	wp.customize.sectionConstructor['suki-section-pro-link'] =
	wp.customize.sectionConstructor['suki-section-spacer'] = wp.customize.Section.extend( {
		// No events for this type of section.
		attachEvents: function () {},
		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

	/**
	 * Suki color control
	 */
	// Use native ColorControl for our custom color controls.
	wp.customize.controlConstructor['suki-color'] = wp.customize.ColorControl;

	/**
	 * Suki shadow control
	 */
	wp.customize.controlConstructor['suki-shadow'] = wp.customize.Control.extend({
		ready: function() {
			var control = this,
			    updating = false,
			    $inputs = control.container.find( '.suki-shadow-input' ),
			    $color = control.container.find( '.suki-shadow-color input' ),
			    $value = control.container.find( '.suki-shadow-value' );

			$color.wpColorPicker({
				change: function() {
					updating = true;
					$color.val( $color.wpColorPicker( 'color' ) ).trigger( 'change' );
					updating = false;
				},
				clear: function() {
					updating = true;
					$color.val( '' ).trigger( 'change' );
					updating = false;
				},
			});

			$inputs.on( 'change', function( i, el ) {
				var values = $inputs.map( function() {
					return 'text' === this.getAttribute( 'type' ) ? ( '' === this.value ? 'rgba(0,0,0,0)' : this.value ) : ( '' === this.value ? '' : this.value.toString() + 'px' );
				}).get();

				$value.val( values.join( ' ' ) ).trigger( 'change' );
			});

			// Collapse color picker when hitting Esc instead of collapsing the current section.
			control.container.on( 'keydown', function( e ) {
				if ( 27 !== e.which ) { // Esc.
					return;
				}

				var $pickerContainer = control.container.find( '.wp-picker-container' );

				if ( $pickerContainer.hasClass( 'wp-picker-active' ) ) {
					picker.wpColorPicker( 'close' );
					control.container.find( '.wp-color-result' ).focus();
					e.stopPropagation(); // Prevent section from being collapsed.
				}
			} );
		}
	});

	/**
	 * Suki slider control
	 */
	wp.customize.controlConstructor['suki-slider'] = wp.customize.Control.extend({
		ready: function() {
			var control = this;

			control.container.find( '.suki-slider-fieldset' ).each(function( i, el ) {
				var $el = $( el ),
				    $unit = $el.find( '.suki-slider-unit' ),
				    $input = $el.find( '.suki-slider-input' ),
				    $slider = $el.find( '.suki-slider-ui' ),
				    $reset = $el.find( '.suki-slider-reset' ),
				    $value = $el.find( '.suki-slider-value' );

				$slider.slider({
					value: $input.val(),
					min: +$input.attr( 'min' ),
					max: +$input.attr( 'max' ),
					step: +$input.attr( 'step' ),
					slide: function( e, ui ) {
						$input.val( ui.value ).trigger( 'change' );
					},
				});

				$reset.on( 'click', function( e ) {
					var resetNumber = $( this ).attr( 'data-number' ),
					    resetUnit = $( this ).attr( 'data-unit' );

					$unit.val( resetUnit );
					$input.val( resetNumber ).trigger( 'change' );
					$slider.slider( 'value', resetNumber );
				});

				$unit.on( 'change', function( e ) {
					var $option = $unit.find( 'option[value="' + this.value + '"]' );

					$input.attr( 'min', $option.attr( 'data-min' ) );
					$input.attr( 'max', $option.attr( 'data-max' ) );
					$input.attr( 'step', $option.attr( 'data-step' ) );

					$slider.slider( 'option', {
						min: +$input.attr( 'min' ),
						max: +$input.attr( 'max' ),
						step: +$input.attr( 'step' ),
					});

					$input.val( '' ).trigger( 'change' );
				});

				$input.on( 'change', function( e ) {
					$slider.slider( 'value', this.value );

					var value = '' === this.value ? '' : this.value.toString() + $unit.val().toString();
					$value.val( value ).trigger( 'change' );
				});
			});
		}
	});
	
	/**
	 * Suki dimensions control
	 */
	wp.customize.controlConstructor['suki-dimensions'] = wp.customize.Control.extend({
		ready: function() {
			var control = this;

			control.container.find( '.suki-dimensions-fieldset' ).each(function( i, el ) {
				var $el = $( el ),
				    $unit = $el.find( '.suki-dimensions-unit' ),
				    $link = $el.find( '.suki-dimensions-link' ),
				    $unlink = $el.find( '.suki-dimensions-unlink' ),
				    $inputs = $el.find( '.suki-dimensions-input' ),
				    $value = $el.find( '.suki-dimensions-value' );

				$unit.on( 'change', function( e ) {
					var $option = $unit.find( 'option[value="' + this.value + '"]' );

					$inputs.attr( 'min', $option.attr( 'data-min' ) );
					$inputs.attr( 'max', $option.attr( 'data-max' ) );
					$inputs.attr( 'step', $option.attr( 'data-step' ) );

					$inputs.val( '' ).trigger( 'change' );
				});

				$link.on( 'click', function( e ) {
					$el.attr( 'data-linked', 'true' );
					$inputs.val( $inputs.first().val() ).trigger( 'change' );
					$inputs.first().focus();
				});

				$unlink.on( 'click', function( e ) {
					$el.attr( 'data-linked', 'false' );
					$inputs.first().focus();
				});

				$inputs.on( 'keyup mouseup', function( e ) {
					if ( 'true' == $el.attr( 'data-linked' ) ) {
						$inputs.not( this ).val( this.value ).trigger( 'change' );
					}
				});

				$inputs.on( 'change', function( e ) {
					var values = [];

					$inputs.each(function() {
						if ( '' === this.value ) {
							values.push( '0' + $unit.val().toString() );
						} else {
							values.push( this.value.toString() + $unit.val().toString() );
						}
					});

					var value = values.join( ' ' );

					$value.val( value ).trigger( 'change' );
				});
			});
		}
	});
	
	/**
	 * Suki typography control
	 */
	 wp.customize.controlConstructor['suki-typography'] = wp.customize.Control.extend({
		ready: function() {
			var control = this;

			control.container.find( '.suki-typography-size' ).each(function( i, el ) {
				var $el = $( el ),
				    $unit = $el.find( '.suki-typography-size-unit' ),
				    $input = $el.find( '.suki-typography-size-input' ),
				    $value = $el.find( '.suki-typography-size-value' );

				var setNumberAttrs = function( unit ) {
					var $option = $unit.find( 'option[value="' + unit + '"]' );

					$input.attr( 'min', $option.attr( 'data-min' ) );
					$input.attr( 'max', $option.attr( 'data-max' ) );
					$input.attr( 'step', $option.attr( 'data-step' ) );
				};

				$unit.on( 'change', function( e ) {
					setNumberAttrs( this.value );
					
					$input.val( '' ).trigger( 'change' );
				});
				setNumberAttrs( $unit.val() );

				$input.on( 'change', function( e ) {
					var value = '' === this.value ? '' : this.value.toString() + $unit.val().toString();

					$value.val( value ).trigger( 'change' );
				});
			});
		}
	});
	
	/**
	 * Suki multiple checkboxes control
	 */
	wp.customize.controlConstructor['suki-multicheck'] = wp.customize.Control.extend({
		ready: function() {
			var control = this,
			    $checkboxes = control.container.find( '.suki-multicheck-input' );

			$checkboxes.on( 'change', function( e ) {
				var value = [];

				$checkboxes.each(function() {
					if ( this.checked ) {
						value.push( this.value );
					}
				});

				control.setting.set( value );
			});
		}
	});
	
	/**
	 * Suki builder control
	 */
	wp.customize.controlConstructor['suki-builder'] = wp.customize.Control.extend({
		ready: function() {
			var control = this;

			control.builder = control.container.find( '.suki-builder' );
			control.builderLocations = control.builder.find( '.suki-builder-location' );
			control.builderInactive = control.builder.find( '.suki-builder-inactive' );

			// Core function to update setting's value.
			control.updateValue = function( location ) {
				if ( '__inactive' === location ) return;

				var $locationPanel = control.builderLocations.filter( '[data-location="' + location + '"]' ),
				    $elements = $locationPanel.find( '.suki-builder-element' ),
				    value = [];

				$elements.each(function() {
					value.push( $( this ).attr( 'data-value' ) );
				});

				if ( null !== control.settings ) {
					control.settings[ location ].set( value );
				} else {
					control.setting.set( value );
				}
			};

			// Trigger click event on all span with tabindex using keyboard.
			control.container.on( 'keyup', '[tabindex]', function( e ) {
				if ( 13 == e.which || 32 == e.which ) {
					$( this ).trigger( 'click' );
				}
			});

			// Expand inactive panel.
			control.container.on( 'click', '.suki-builder-element-add', function( e ) {
				e.preventDefault();

				var $this = $( this ),
				    $location = $this.closest( '.suki-builder-location' ),
				    $wrapper = $this.closest( '.suki-builder-locations' );

				if ( control.builderInactive.prev().get(0) == $location.get(0) && control.builderInactive.hasClass( 'show' ) ) {
					control.builderInactive.removeClass( 'show' ).appendTo( $wrapper );
				} else {
					control.builderInactive.addClass( 'show' ).insertAfter( $location );
				}
			});

			// Add element to nearby location.
			control.container.on( 'click', '.suki-builder-inactive .suki-builder-element', function( e ) {
				e.preventDefault();

				if ( control.builderInactive.hasClass( 'show' ) ) {
					var $element = $( this ),
					    $location = control.builderInactive.prev( '.suki-builder-location' );

					$element.appendTo( $location.children( '.suki-builder-sortable-panel' ) );
					control.builderInactive.removeClass( 'show' );

					control.updateValue( $location.attr( 'data-location' ) );
				}
			});

			// Delete element from location.
			control.container.on( 'click', '.suki-builder-element-delete', function( e ) {
				e.preventDefault();

				var $element = $( this ).parent( '.suki-builder-element' ),
				    $location = $element.closest( '.suki-builder-location' );

				$element.prependTo( control.builderInactive.children( '.suki-builder-sortable-panel' ) );
				control.updateValue( $location.attr( 'data-location' ) );
			});

			// Initialize sortable.
			control.container.find( '.suki-builder-sortable-panel' ).sortable({
				items: '.suki-builder-element:not(.suki-builder-element-disabled)',
				connectWith: '.suki-builder-sortable-panel[data-connect="' + control.builder.attr( 'data-name' ) + '"]',
				containment: control.container,
				update: function( e, ui ) {
					control.updateValue( $( e.target ).parent().attr( 'data-location' ) );
				},

				receive: function( e, ui ) {
					var limitations = $( ui.item ).attr( 'data-limitations' ).split( ',' );

					if ( 0 <= limitations.indexOf( $( this ).parent().attr( 'data-location' ) ) ) {
						$( ui.sender ).sortable( 'cancel' );
					}
				},
				start: function( e, ui ) {
					var limitations = $( ui.item ).attr( 'data-limitations' ).split( ',' );

					for ( var i = 0; i < limitations.length; ++i ) {
						var $target = control.builderLocations.filter( '[data-location="' + limitations[ i ] + '"]' );
						if ( undefined === $target ) continue;

						$target.addClass( 'disabled' );
					}
				},
				stop: function( e, ui ) {
					control.builderLocations.removeClass( 'disabled' );
					control.builderInactive.removeClass( 'disabled' );
				}
			})
			.disableSelection();
		}
	});

	/**
	 * API on ready event handlers
	 *
	 * All handlers need to be inside the 'ready' state.
	 */
	wp.customize.bind( 'ready', function() {

		/**
		 * Suki responsive control
		 */
		$( '#customize-theme-controls' ).on( 'click', '.suki-responsive-switcher-button', function( e ) {
			e.preventDefault();

			wp.customize.previewedDevice.set( $( this ).attr( 'data-device' ) );
		});

		wp.customize.previewedDevice.bind(function( device ) {
			var $buttons = $( 'span.suki-responsive-switcher-button' ),
			    $tabs = $( '.suki-responsive-switcher-button.nav-tab' ),
			    $panels = $( '.suki-responsive-fieldset' );

			$panels.removeClass( 'active' ).filter( '.preview-' + device ).addClass( 'active' );
			$buttons.removeClass( 'active' ).filter( '.preview-' + device ).addClass( 'active' );
			$tabs.removeClass( 'nav-tab-active' ).filter( '.preview-' + device ).addClass( 'nav-tab-active' );
		});

		/**
		 * Event handler for links to set preview URL.
		 */
		$( '#customize-theme-controls' ).on( 'click', '.suki-customize-set-preview-url', function( e ) {
			e.preventDefault();

			var $this = $( this ),
			    href = $this.attr( 'href' ),
			    url = getUrlParameter( 'url', href );

			if ( url !== wp.customize.previewer.previewUrl() ) {
				wp.customize.previewer.previewUrl( url );
			}
		});

		/**
		 * Event handler for links to jump to a certain control / section.
		 */
		$( '#customize-theme-controls' ).on( 'click', '.suki-customize-goto-control', function( e ) {
			e.preventDefault();

			var $this = $( this ),
			    href = $this.attr( 'href' ),
			    targetControl = getUrlParameter( 'autofocus[control]', href ),
			    targetSection = getUrlParameter( 'autofocus[section]', href ),
			    targetPanel= getUrlParameter( 'autofocus[panel]', href );

			if ( targetControl ) {
				wp.customize.control( targetControl ).focus();
			}
			else if ( targetSection ) {
				wp.customize.section( targetSection ).focus();
			}
			else if ( targetPanel ) {
				wp.customize.panel( targetPanel ).focus();
			}
		});

		if ( sukiCustomizerControlsData && sukiCustomizerControlsData.contexts ) {
			/**
			 * Active callback script (JS version)
			 * ref: https://make.xwp.co/2016/07/24/dependently-contextual-customizer-controls/
			 */
			_.each( sukiCustomizerControlsData.contexts, function( rules, key ) {
				var getSetting = function( settingName ) {
					// Get the dependent setting.
					switch ( settingName ) {
						case '__device':
							return wp.customize.previewedDevice;
							break;

						default:
							return wp.customize( settingName );
							break;
					}
				}

				var initContext = function( element ) {
					// Main function returning the conditional value
					var isDisplayed = function() {
						var displayed = false,
						    relation = rules['relation'];

						// Fallback invalid relation type to "AND".
						// Assign default displayed to true for "AND" relation type.
						if ( 'OR' !== relation ) {
							relation = 'AND';
							displayed = true;
						}

						// Each rule iteration
						_.each( rules, function( rule, i ) {
							// Skip "relation" property.
							if ( 'relation' == i ) return;

							// If in "AND" relation and "displayed" already flagged as false, skip the rest rules.
							if ( 'AND' == relation && false == displayed ) return;

							// Skip if no setting propery found.
							if ( undefined === rule['setting'] ) return;

							var result = false,
							    setting = getSetting( rule['setting'] );
							
							// Only process the rule if dependent setting is found.
							// Otherwise leave the result to "false".
							if ( undefined !== setting ) {
								var operator = rule['operator'],
								    comparedValue = rule['value'],
								    currentValue = setting.get();

								if ( undefined == operator || '=' == operator ) {
									operator = '==';
								}

								switch ( operator ) {
									case '>':
										result = currentValue > comparedValue; 
										break;

									case '<':
										result = currentValue < comparedValue; 
										break;

									case '>=':
										result = currentValue >= comparedValue; 
										break;

									case '<=':
										result = currentValue <= comparedValue; 
										break;

									case 'in':
										result = 0 <= comparedValue.indexOf( currentValue );
										break;

									case 'contains':
										result = 0 <= currentValue.indexOf( comparedValue );
										break;

									case '!=':
										result = comparedValue != currentValue;
										break;

									case 'empty':
										result = 0 == currentValue.length;
										break;

									case '!empty':
										result = 0 < currentValue.length;
										break;

									default:
										result = comparedValue == currentValue;
										break;
								}
							}

							// Combine to the final result.
							switch ( relation ) {
								case 'OR':
									displayed = displayed || result;
									break;

								default:
									displayed = displayed && result;
									break;
							}
						});

						return displayed;
					};

					// Wrapper function for binding purpose
					var setActiveState = function() {
						element.active.set( isDisplayed() );
					};

					// Setting changes bind
					_.each( rules, function( rule, i ) {
						// Skip "relation" property.
						if ( 'relation' == i ) return;

						var setting = getSetting( rule['setting'] );

						if ( undefined !== setting ) {
							// Bind the setting for future use.
							setting.bind( setActiveState );
						}
					});

					// Initial run
					element.active.validate = isDisplayed;
					setActiveState();
				};

				if ( 0 == key.indexOf( 'suki_section' ) ) {
					wp.customize.section( key, initContext );
				} else {
					wp.customize.control( key, initContext );
				}
			});
		}

		/**
		 * Resize Preview Frame when show / hide Builder.
		 */
		var resizePreviewer = function() {
			var $section = $( '.control-section.suki-builder-active' );

			if ( $body.hasClass( 'suki-has-builder-active' ) && 0 < $section.length && ! $section.hasClass( 'suki-hide' ) ) {
				wp.customize.previewer.container.css({ "bottom" : $section.outerHeight() + 'px' });
			} else {
				wp.customize.previewer.container.css({ "bottom" : "" });
			}
		}
		$window.on( 'resize', resizePreviewer );
		wp.customize.previewedDevice.bind( function( device ) {
			setTimeout(function() {
				resizePreviewer();
			}, 250 );
		});

		/**
		 * Init Header & Footer Builder
		 */
		var initHeaderFooterBuilder = function( panel ) {
			var $section = 'suki_panel_header' === panel.id ? wp.customize.section( 'suki_section_header_builder' ).contentContainer : wp.customize.section( 'suki_section_footer_builder' ).contentContainer;

			// If Header panel is expanded, add class to the body tag (for CSS styling).
			panel.expanded.bind(function( isExpanded ) {
				if ( isExpanded ) {
					$body.addClass( 'suki-has-builder-active' );
					$section.addClass( 'suki-builder-active' );
				} else {
					$body.removeClass( 'suki-has-builder-active' );
					$section.removeClass( 'suki-builder-active' );
				}

				resizePreviewer();
			});

			// Attach callback to builder toggle.
			$section.on( 'click', '.suki-builder-toggle', function( e ) {
				e.preventDefault();
				$section.toggleClass( 'suki-hide' );

				resizePreviewer();
			});

			$section.find( '.suki-builder-sortable-panel' ).on( 'sortover', function( e, ui ) {
				resizePreviewer();
			});
		};
		wp.customize.panel( 'suki_panel_header', initHeaderFooterBuilder );
		wp.customize.panel( 'suki_panel_footer', initHeaderFooterBuilder );

		/**
		 * Init Header Elements Locations Grouping
		 */
		var initHeaderFooterBuilderElements = function( control ) {
			var $groupWrapper = control.container.find( '.suki-builder-locations' ).addClass( 'suki-builder-groups' );

			var verticalSelector = '.suki-builder-location-vertical_top, .suki-builder-location-vertical_bottom, .suki-builder-location-mobile_vertical_top';

			var $verticalLocations = control.container.find( verticalSelector );
			if ( $verticalLocations.length ) {
				$( document.createElement( 'div' ) ).addClass( 'suki-builder-group suki-builder-group-vertical suki-builder-layout-block' ).appendTo( $groupWrapper ).append( $verticalLocations );
			}

			var $horizontalLocations = control.container.find( '.suki-builder-location' ).not( verticalSelector );
			if ( $horizontalLocations.length ) {
				$( document.createElement( 'div' ) ).addClass( 'suki-builder-group suki-builder-group-horizontal suki-builder-layout-inline' ).appendTo( $groupWrapper ).append( $horizontalLocations );
			}

			// Make logo element has button-primary colors.
			control.container.find( '.suki-builder-element[data-value="logo"], .suki-builder-element[data-value="mobile-logo"]' ).addClass( 'button-primary' );

			// Element on click jump to element options.
			control.container.on( 'click', '.suki-builder-location .suki-builder-element > span', function( e ) {
				e.preventDefault();

				var $element = $( this ).parent( '.suki-builder-element' ),
				    targetKey = 'heading_header_' + $element.attr( 'data-value' ).replace( '-', '_' ),
				    targetControl = wp.customize.control( targetKey );

				if ( targetControl ) targetControl.focus();
			});

			// Group edit button on click jump to group section.
			control.container.on( 'click', '.suki-builder-group-edit', function( e ) {
				e.preventDefault();

				var targetKey = 'suki_section_' + ( 'footer_elements' == control.id ? 'footer' : 'header' ) + '_' + $( this ).attr( 'data-value' ).replace( '-', '_' ),
				    targetSection = wp.customize.section( targetKey );

				if ( targetSection ) targetSection.focus();
			});
		};
		wp.customize.control( 'header_elements', initHeaderFooterBuilderElements );
		wp.customize.control( 'header_mobile_elements', initHeaderFooterBuilderElements );
		wp.customize.control( 'footer_elements', initHeaderFooterBuilderElements );

	});
})( wp, jQuery );