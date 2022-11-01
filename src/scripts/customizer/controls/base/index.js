/**
 * Base dynamic control.
 *
 * @see https://github.com/xwp/wp-customize-posts/blob/develop/js/customize-dynamic-control.js
 */

wp.customize.SukiControl = wp.customize.Control.extend( {

	initialize( id, options ) {
		const control = this;
		const args = options || {};

		args.params = args.params || {};
		if ( ! args.params.type ) {
			args.params.type = 'dynamic';
		}
		if ( ! args.params.content ) {
			args.params.content = jQuery( '<li></li>' );
			args.params.content.attr( 'id', 'customize-control-' + id.replace( /]/g, '' ).replace( /\[/g, '-' ) );
			args.params.content.attr( 'class', 'suki-customize-control customize-control customize-control-' + args.params.type );
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
	 * @return {void}
	 */
	_setUpSettingRootLinks() {
		const control = this;
		const nodes = control.container.find( '[data-customize-setting-link]' );

		nodes.each( function() {
			let radios;
			let node = jQuery( this );

			if ( node.is( ':radio' ) ) {
				const name = node.prop( 'name' );
				if ( radios[ name ] ) {
					return;
				}

				radios[ name ] = true;
				node = nodes.filter( '[name="' + name + '"]' );
			}

			wp.customize( node.data( 'customizeSettingLink' ), function( setting ) {
				const element = new wp.customize.Element( node );
				control.elements.push( element );
				element.sync( setting );
				element.set( setting() );
			} );
		} );
	},

	/**
	 * Add bidirectional data binding links between inputs and the setting properties.
	 *
	 * @private
	 * @return {void}
	 */
	_setUpSettingPropertyLinks() {
		const control = this;

		if ( ! control.setting ) {
			return;
		}

		const nodes = control.container.find( '[data-customize-setting-property-link]' );
		let radios;

		nodes.each( function() {
			let node = jQuery( this );

			if ( node.is( ':radio' ) ) {
				const name = node.prop( 'name' );
				if ( radios[ name ] ) {
					return;
				}
				radios[ name ] = true;
				node = nodes.filter( '[name="' + name + '"]' );
			}

			const propertyName = node.data( 'customizeSettingPropertyLink' );

			const element = new wp.customize.Element( node );
			control.propertyElements.push( element );
			element.set( control.setting()[ propertyName ] );

			element.bind( function( newPropertyValue ) {
				let newSetting = control.setting();
				if ( newPropertyValue === newSetting[ propertyName ] ) {
					return;
				}
				newSetting = _.clone( newSetting );
				newSetting[ propertyName ] = newPropertyValue;
				control.setting.set( newSetting );
			} );
			control.setting.bind( function( newValue ) {
				if ( newValue[ propertyName ] !== element.get() ) {
					element.set( newValue[ propertyName ] );
				}
			} );
		} );
	},

	/**
	 * @inheritdoc
	 */
	ready() {
		const control = this;

		control._setUpSettingRootLinks();
		control._setUpSettingPropertyLinks();

		wp.customize.Control.prototype.ready.call( control );

		// @todo build out the controls for the post when Control is expanded.
		// @todo Let the Control title include the post title.
		control.deferred.embedded.done( function() {} );
	},

	/**
	 * Embed the control in the document.
	 *
	 * Override the embed() method to do nothing,
	 * so that the control isn't embedded on load,
	 * unless the containing section is already expanded.
	 *
	 * @return {void}
	 */
	embed() {
		const control = this;
		const sectionId = control.section();

		if ( ! sectionId ) {
			return;
		}

		wp.customize.section( sectionId, function( section ) {
			if ( section.expanded() || wp.customize.settings.autofocus.control === control.id ) {
				control.actuallyEmbed();
			} else {
				section.expanded.bind( function( expanded ) {
					if ( expanded ) {
						control.actuallyEmbed();
					}
				} );
			}
		} );
	},

	/**
	 * Deferred embedding of control when actually
	 *
	 * This function is called in Section.onChangeExpanded() so the control
	 * will only get embedded when the Section is first expanded.
	 *
	 * @return {void}
	 */
	actuallyEmbed() {
		const control = this;

		if ( 'resolved' === control.deferred.embedded.state() ) {
			return;
		}

		control.renderContent();
		control.deferred.embedded.resolve(); // This triggers control.ready().
	},

	/**
	 * This is not working with autofocus.
	 *
	 * @param {Object} [args] Args.
	 * @return {void}
	 */
	focus( args ) {
		const control = this;

		control.actuallyEmbed();

		wp.customize.Control.prototype.focus.call( control, args );
	},
} );
