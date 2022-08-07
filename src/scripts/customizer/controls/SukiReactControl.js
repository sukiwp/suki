/**
 * Base react control.
 */

wp.customize.SukiReactControl = wp.customize.SukiControl.extend( {
	/**
	 * Initialize.
	 *
	 * @param {string} id - Control ID.
	 * @param {Object} params - Control params.
	 */
	initialize: function( id, params ) {
		const control = this;

		// Bind functions to this control context for passing as React props.
		control.setNotificationContainer = control.setNotificationContainer.bind( control );

		wp.customize.Control.prototype.initialize.call( control, id, params );

		// The following should be eliminated with <https://core.trac.wordpress.org/ticket/31334>.
		const onRemoved = ( removedControl ) => {
			if ( control === removedControl ) {
				control.destroy();
				control.container.remove();
				wp.customize.control.unbind( 'removed', onRemoved );
			}
		}
		wp.customize.control.bind( 'removed', onRemoved );
	},

	/**
	 * Set notification container and render.
	 *
	 * This is called when the React component is mounted.
	 *
	 * @param {Element} element - Notification container.
	 * @return {void}
	 */
	setNotificationContainer: function( element ) {
		const control = this;

		control.notifications.container = jQuery( element );
		control.notifications.render();
	},

	/**
	 * After control has been first rendered, start re-rendering when setting changes.
	 *
	 * React is able to be used here instead of the wp.customize.Element abstraction.
	 *
	 * @returns {void}
	 */
	ready: function() {
		const control = this;

		/**
		 * Update component value's state when customizer setting's value is changed.
		 */

		Object.keys( control.settings ).forEach( ( settingKey ) => {
			control.settings[ settingKey ].bind( ( val ) => {
				control.renderContent();
			} )
		} );
	},

	/**
	 * Handle removal/de-registration of the control.
	 *
	 * This is essentially the inverse of the Control#embed() method.
	 *
	 * @link https://core.trac.wordpress.org/ticket/31334
	 * @returns {void}
	 */
	destroy: function() {
		const control = this;

		// Garbage collection: undo mounting that was done in the embed/renderContent method.
		ReactDOM.unmountComponentAtNode( control.container[0] );

		// Call destroy method in parent if it exists (as of #31334).
		if ( wp.customize.Control.prototype.destroy ) {
			wp.customize.Control.prototype.destroy.call( control );
		}
	},
} );
