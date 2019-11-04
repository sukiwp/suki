/**
 * Theme Customizer custom controls handlers
 */
(function( exports, $ ) {
	'use strict';

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

	$( '#customize-controls' ).on( 'blur', 'input[type="number"]', inputNumberValidation );
	$( '#customize-controls' ).on( 'keyup', 'input[type="number"]', function( e ) {
		if ( 13 == e.which ) {
			inputNumberValidation( e );
		}
	});
	// Disable mousewheel scroll when input is in focus.
	$( '#customize-controls' ).on( 'focus', 'input[type="number"]', function( e ) {
		$( this ).on( 'mousewheel.disableScroll', function ( e ) { e.preventDefault(); });
	});
	$( '#customize-controls' ).on( 'blur', 'input[type="number"]', function( e ) {
		$( this ).off( 'mousewheel.disableScroll' );
	});

	/**
	 * Contentless sections like: suki-section-spacer, suki-section-pro-teaser, suki-section-pro-link
	 */
	wp.customize.sectionConstructor['suki-section-pro-teaser'] =
	wp.customize.sectionConstructor['suki-section-pro-link'] =
	wp.customize.sectionConstructor['suki-section-spacer'] = wp.customize.Section.extend({
		// No events for this type of section.
		attachEvents: function () {},
		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	});

	/**
	 * Suki base control
	 * 
	 * ref:
	 * - https://github.com/aristath/kirki/blob/develop/controls/js/src/dynamic-control.js
	 * - https://github.com/xwp/wp-customize-posts/blob/develop/js/customize-dynamic-control.js
	 */
	wp.customize.SukiControl = wp.customize.Control.extend({
		initialize: function( id, options ) {
			var control = this,
			    args    = options || {};

			args.params = args.params || {};
			if ( ! args.params.type ) {
				args.params.type = 'suki-base';
			}
			if ( ! args.params.content ) {
				args.params.content = jQuery( '<li></li>' );
				args.params.content.attr( 'id', 'customize-control-' + id.replace( /]/g, '' ).replace( /\[/g, '-' ) );
				args.params.content.attr( 'class', 'customize-control customize-control-' + args.params.type );
			}

			control.propertyElements = [];
			wp.customize.Control.prototype.initialize.call( control, id, args );
		},

		/**
		 * Add bidirectional data binding links between inputs and the setting(s).
		 *
		 * This is copied from wp.customize.Control.prototype.initialize(). It
		 * should be changed in Core to be applied once the control is embedded.
		 *
		 * @private
		 * @returns {null}
		 */
		_setUpSettingRootLinks: function() {
			var control = this,
				nodes   = control.container.find( '[data-customize-setting-link]' );

			nodes.each(function() {
				var node = jQuery( this );

				wp.customize( node.data( 'customizeSettingLink' ), function( setting ) {
					var element = new wp.customize.Element( node );
					control.elements.push( element );
					element.sync( setting );
					element.set( setting() );
				});
			});
		},

		/**
		 * Add bidirectional data binding links between inputs and the setting properties.
		 *
		 * @private
		 * @returns {null}
		 */
		_setUpSettingPropertyLinks: function() {
			var control = this,
				nodes;

			if ( ! control.setting ) {
				return;
			}

			nodes = control.container.find( '[data-customize-setting-property-link]' );

			nodes.each(function() {
				var node = jQuery( this ),
					element,
					propertyName = node.data( 'customizeSettingPropertyLink' );

				element = new wp.customize.Element( node );
				control.propertyElements.push( element );
				element.set( control.setting()[ propertyName ] );

				element.bind(function( newPropertyValue ) {
					var newSetting = control.setting();
					if ( newPropertyValue === newSetting[ propertyName ] ) {
						return;
					}
					newSetting = _.clone( newSetting );
					newSetting[ propertyName ] = newPropertyValue;
					control.setting.set( newSetting );
				});
				control.setting.bind(function( newValue ) {
					if ( newValue[ propertyName ] !== element.get() ) {
						element.set( newValue[ propertyName ] );
					}
				});
			});
		},

		/**
		 * @inheritdoc
		 */
		ready: function() {
			var control = this;

			control._setUpSettingRootLinks();
			control._setUpSettingPropertyLinks();

			wp.customize.Control.prototype.ready.call( control );

			control.deferred.embedded.done(function() {});
		},

		/**
		 * Embed the control in the document.
		 *
		 * Override the embed() method to do nothing,
		 * so that the control isn't embedded on load,
		 * unless the containing section is already expanded.
		 *
		 * @returns {null}
		 */
		embed: function() {
			var control   = this,
				sectionId = control.section();

			if ( ! sectionId ) {
				return;
			}

			wp.customize.section( sectionId, function( section ) {
				if ( section.expanded() || wp.customize.settings.autofocus.control === control.id ) {
					control.actuallyEmbed();
				} else {
					section.expanded.bind(function( expanded ) {
						if ( expanded ) {
							control.actuallyEmbed();
						}
					});
				}
			});
		},

		/**
		 * Deferred embedding of control when actually
		 *
		 * This function is called in Section.onChangeExpanded() so the control
		 * will only get embedded when the Section is first expanded.
		 *
		 * @returns {null}
		 */
		actuallyEmbed: function() {
			var control = this;
			if ( 'resolved' === control.deferred.embedded.state() ) {
				return;
			}
			control.renderContent();
			control.deferred.embedded.resolve(); // This triggers control.ready().

			// Fire event after control is initialized.
			control.container.trigger( 'init' );
		},

		/**
		 * This is not working with autofocus.
		 *
		 * @param {object} [args] Args.
		 * @returns {null}
		 */
		focus: function( args ) {
			var control = this;
			control.actuallyEmbed();
			wp.customize.Control.prototype.focus.call( control, args );
		},
	});
	wp.customize.controlConstructor['suki-base'] = wp.customize.SukiControl;

	/**
	 * Suki color control
	 */
	wp.customize.controlConstructor['suki-color'] = wp.customize.SukiControl.extend({
		ready: function() {
			var control = this,
				$picker = control.container.find( '.color-picker' );

			$picker.alphaColorPicker({
				change: function() {
					control.setting.set( $picker.wpColorPicker( 'color' ) );
				},
				clear: function() {
					control.setting.set( '' );
				},
			});
		}
	});

	/**
	 * Suki shadow control
	 */
	wp.customize.controlConstructor['suki-shadow'] = wp.customize.SukiControl.extend({
		ready: function() {
			var control = this,
			    $inputs = control.container.find( '.suki-shadow-input' ),
			    $value = control.container.find( '.suki-shadow-value' );

			control.updateValue = function( e ) {
				var values = $inputs.map(function() {
					return $( this ).hasClass( 'color-picker' ) ? ( '' === $( this ).wpColorPicker( 'color' ) ? 'rgba(0,0,0,0)' : $( this ).wpColorPicker( 'color' ) ) : ( '' === this.value ? '0' : this.value.toString() + 'px' );
				}).get();

				$value.val( values.join( ' ' ) ).trigger( 'change' );
			}

			control.container.find( '.suki-shadow-color .color-picker' ).alphaColorPicker({
				change: control.updateValue,
				clear: control.updateValue,
			});

			control.container.on( 'change blur', '.suki-shadow-input', control.updateValue );
		}
	});

	/**
	 * Suki dimension control
	 */
	wp.customize.controlConstructor['suki-dimension'] = wp.customize.SukiControl.extend({
		ready: function() {
			var control = this;

			control.container.find( '.suki-dimension-fieldset' ).each(function( i, el ) {
				var $el = $( el ),
				    $unit = $el.find( '.suki-dimension-unit' ),
				    $input = $el.find( '.suki-dimension-input' ),
				    $value = $el.find( '.suki-dimension-value' );

				$unit.on( 'change', function( e ) {
					var $option = $unit.find( 'option[value="' + this.value + '"]' );

					$input.attr( 'min', $option.attr( 'data-min' ) );
					$input.attr( 'max', $option.attr( 'data-max' ) );
					$input.attr( 'step', $option.attr( 'data-step' ) );

					$input.val( '' ).trigger( 'change' );
				});

				$input.on( 'change blur', function( e ) {
					var value = '' === this.value ? '' : this.value.toString() + $unit.val().toString();

					$value.val( value ).trigger( 'change' );
				});
			});
		}
	});

	/**
	 * Suki slider control
	 */
	wp.customize.controlConstructor['suki-slider'] = wp.customize.SukiControl.extend({
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

				$input.on( 'change blur', function( e ) {
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
	wp.customize.controlConstructor['suki-dimensions'] = wp.customize.SukiControl.extend({
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
					e.preventDefault();
					
					$el.attr( 'data-linked', 'true' );
					$inputs.val( $inputs.first().val() ).trigger( 'change' );
					$inputs.first().focus();
				});

				$unlink.on( 'click', function( e ) {
					e.preventDefault();
					
					$el.attr( 'data-linked', 'false' );
					$inputs.first().focus();
				});

				$inputs.on( 'keyup mouseup', function( e ) {
					if ( 'true' == $el.attr( 'data-linked' ) ) {
						$inputs.not( this ).val( this.value ).trigger( 'change' );
					}
				});

				$inputs.on( 'change blur', function( e ) {
					var values = [],
					    unit = $unit.val().toString(),
					    isEmpty = true,
					    value;

					$inputs.each(function() {
						if ( '' === this.value ) {
							values.push( '0' + unit );
						} else {
							values.push( this.value.toString() + unit );
							isEmpty = false;
						}
					});

					if ( isEmpty ) {
						value = '   ';
					} else {
						value = values.join( ' ' );
					}

					$value.val( value ).trigger( 'change' );
				});
			});
		}
	});
	
	/**
	 * Suki typography control
	 */
	 wp.customize.controlConstructor['suki-typography'] = wp.customize.SukiControl.extend({
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

				$input.on( 'change blur', function( e ) {
					var value = '' === this.value ? '' : this.value.toString() + $unit.val().toString();

					$value.val( value ).trigger( 'change' );
				});
			});
		}
	});
	
	/**
	 * Suki multiple checkboxes control
	 */
	wp.customize.controlConstructor['suki-multicheck'] = wp.customize.SukiControl.extend({
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
	 * Suki radio image control
	 */
	wp.customize.controlConstructor['suki-radioimage'] = wp.customize.SukiControl.extend({
		ready: function() {
			var control = this,
			    $inputs = control.container.find( '.suki-radioimage-input' );

			$inputs.on( 'change', function( e ) {
				control.setting.set( this.value );
			});
		}
	});
	
	/**
	 * Suki builder control
	 */
	wp.customize.controlConstructor['suki-builder'] = wp.customize.SukiControl.extend({
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

			// Show / hide add button.
			control.showHideAddButton = function() {
				var $addButton = control.builder.find( '.suki-builder-element-add' );

				if ( 0 === control.builderInactive.find( '.suki-builder-element' ).length ) {
					$addButton.hide();
				} else {
					$addButton.show();
				}
			}
			control.showHideAddButton();

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
					control.showHideAddButton();
				}
			});

			// Delete element from location.
			control.container.on( 'click', '.suki-builder-element-delete', function( e ) {
				e.preventDefault();

				var $element = $( this ).parent( '.suki-builder-element' ),
				    $location = $element.closest( '.suki-builder-location' );

				$element.prependTo( control.builderInactive.children( '.suki-builder-sortable-panel' ) );
				control.updateValue( $location.attr( 'data-location' ) );
				control.showHideAddButton();
			});

			// Initialize sortable.
			control.container.find( '.suki-builder-sortable-panel' ).sortable({
				items: '.suki-builder-element:not(.suki-builder-element-disabled)',
				connectWith: '.suki-builder-sortable-panel[data-connect="' + control.builder.attr( 'data-name' ) + '"]',
				containment: control.container,
				update: function( e, ui ) {
					control.updateValue( $( e.target ).parent().attr( 'data-location' ) );
					control.showHideAddButton();
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

		// Set handler when custom responsive toggle is clicked.
		$( '#customize-controls' ).on( 'click', '.suki-responsive-switcher-button', function( e ) {
			e.preventDefault();

			wp.customize.previewedDevice.set( $( this ).attr( 'data-device' ) );
		});

		// Set all custom responsive toggles and fieldsets.
		var setCustomResponsiveElementsDisplay = function() {
			var device = wp.customize.previewedDevice.get(),
			    $buttons = $( 'span.suki-responsive-switcher-button' ),
			    $tabs = $( '.suki-responsive-switcher-button.nav-tab' ),
			    $panels = $( '.suki-responsive-fieldset' );

			$panels.removeClass( 'active' ).filter( '.preview-' + device ).addClass( 'active' );
			$buttons.removeClass( 'active' ).filter( '.preview-' + device ).addClass( 'active' );
			$tabs.removeClass( 'nav-tab-active' ).filter( '.preview-' + device ).addClass( 'nav-tab-active' );
		}

		// Refresh all responsive elements when previewedDevice is changed.
		wp.customize.previewedDevice.bind( setCustomResponsiveElementsDisplay );

		// Refresh all responsive elements when any section is expanded.
		// This is required to set responsive elements on newly added controls inside the section.
		wp.customize.section.each(function ( section ) {
			section.expanded.bind( setCustomResponsiveElementsDisplay );
		});

		/**
		 * Event handler for links to set preview URL.
		 */
		$( '#customize-controls' ).on( 'click', '.suki-customize-set-preview-url', function( e ) {
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
		$( '#customize-controls' ).on( 'click', '.suki-customize-goto-control', function( e ) {
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

									case 'not_in':
										result = 0 > comparedValue.indexOf( currentValue );
										break;

									case 'contain':
										result = 0 <= currentValue.indexOf( comparedValue );
										break;

									case 'not_contain':
										result = 0 > currentValue.indexOf( comparedValue );
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

			if ( 1324 <= window.innerWidth && $body.hasClass( 'suki-has-builder-active' ) && 0 < $section.length && ! $section.hasClass( 'suki-hide' ) ) {
				wp.customize.previewer.container.css({ "bottom" : $section.outerHeight() + 'px' });
			} else {
				wp.customize.previewer.container.css({ "bottom" : "" });
			}
		}
		$window.on( 'resize', resizePreviewer );
		wp.customize.previewedDevice.bind(function( device ) {
			setTimeout(function() {
				resizePreviewer();
			}, 250 );
		});

		/**
		 * Init Header & Footer Builder
		 */
		var initHeaderFooterBuilder = function( panel ) {
			var section = 'suki_panel_header' === panel.id ? wp.customize.section( 'suki_section_header_builder' ) : wp.customize.section( 'suki_section_footer_builder' ),
			    $section = section.contentContainer;

			// If Header panel is expanded, add class to the body tag (for CSS styling).
			panel.expanded.bind(function( isExpanded ) {
				_.each(section.controls(), function( control ) {
					if ( 'resolved' === control.deferred.embedded.state() ) {
						return;
					}
					control.renderContent();
					control.deferred.embedded.resolve(); // This triggers control.ready().
					
					// Fire event after control is initialized.
					control.container.trigger( 'init' );
				});

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

			var moveHeaderFooterBuilder = function() {
				if ( 1324 <= window.innerWidth ) {
					$section.insertAfter( $( '.wp-full-overlay-sidebar-content' ) );
					
					if ( section.expanded() ) {
						section.collapse();
					}
				} else {
					$section.appendTo( $( '#customize-theme-controls' ) );
				}
			}
			wp.customize.bind( 'pane-contents-reflowed', moveHeaderFooterBuilder );
			$window.on( 'resize', moveHeaderFooterBuilder );
		};
		wp.customize.panel( 'suki_panel_header', initHeaderFooterBuilder );
		wp.customize.panel( 'suki_panel_footer', initHeaderFooterBuilder );
		
		wp.customize.control( 'footer_elements' ).container.on( 'init', setCustomResponsiveElementsDisplay );

		/**
		 * Init Header Elements Locations Grouping
		 */
		var initHeaderFooterBuilderElements = function( e ) {
			var $control = $( this ),
			    mode = 0 <= $control.attr( 'id' ).indexOf( 'header' ) ? 'header' : 'footer',
			    $groupWrapper = $control.find( '.suki-builder-locations' ).addClass( 'suki-builder-groups' ),
			    verticalSelector = '.suki-builder-location-vertical_top, .suki-builder-location-vertical_middle, .suki-builder-location-vertical_bottom, .suki-builder-location-mobile_vertical_top',
			    $verticalLocations = $control.find( verticalSelector ),
			    $horizontalLocations = $control.find( '.suki-builder-location' ).not( verticalSelector );

			if ( $verticalLocations.length ) {
				$( document.createElement( 'div' ) ).addClass( 'suki-builder-group suki-builder-group-vertical suki-builder-layout-block' ).appendTo( $groupWrapper ).append( $verticalLocations );
			}

			if ( $horizontalLocations.length ) {
				$( document.createElement( 'div' ) ).addClass( 'suki-builder-group suki-builder-group-horizontal suki-builder-layout-inline' ).appendTo( $groupWrapper ).append( $horizontalLocations );
			}

			// Make logo element has button-primary colors.
			$control.find( '.suki-builder-element[data-value="logo"], .suki-builder-element[data-value="mobile-logo"]' ).addClass( 'button-primary' );

			// Element on click jump to element options.
			$control.on( 'click', '.suki-builder-location .suki-builder-element > span', function( e ) {
				e.preventDefault();

				var $element = $( this ).parent( '.suki-builder-element' ),
				    targetKey = 'heading_' + mode + '_' + $element.attr( 'data-value' ).replace( '-', '_' ),
				    targetControl = wp.customize.control( targetKey );

				if ( targetControl ) targetControl.focus();
			});

			// Group edit button on click jump to group section.
			$control.on( 'click', '.suki-builder-group-edit', function( e ) {
				e.preventDefault();

				var targetKey = 'suki_section_' + ( 'footer_elements' == control.id ? 'footer' : 'header' ) + '_' + $( this ).attr( 'data-value' ).replace( '-', '_' ),
				    targetSection = wp.customize.section( targetKey );

				if ( targetSection ) targetSection.focus();
			});
		};
		wp.customize.control( 'header_elements' ).container.on( 'init', initHeaderFooterBuilderElements );
		wp.customize.control( 'header_mobile_elements' ).container.on( 'init', initHeaderFooterBuilderElements );
		wp.customize.control( 'footer_elements' ).container.on( 'init', initHeaderFooterBuilderElements );

	});
})( wp, jQuery );