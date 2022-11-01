wp.customize.bind( 'ready', () => {
	/**
	 * Color Palette controls
	 *
	 * @param {number} i
	 * @param {string} color
	 */
	function setColorPaletteValue( i, color ) {
		const styleId = `suki-color-palette-${ i }-output-css`;

		let styleTag = document.getElementById( styleId );

		if ( ! styleTag ) {
			styleTag = document.createElement( 'style' );
			styleTag.id = styleId;

			document.head.appendChild( styleTag );
		}

		styleTag.textContent = `.wp-customizer{--color-palette-${ i }:${ color }}`;
	}

	for ( let i = 1; i <= 8; i++ ) {
		wp.customize( `color_palette_${ i }` ).bind( ( color ) => {
			setColorPaletteValue( i, color );
		} );

		setColorPaletteValue( i, wp.customize( `color_palette_${ i }` ).get() );
	}
} );
