// Base controls
import './controls/SukiControl';
import './controls/SukiReactControl';

// Custom controls
import './controls/SukiBackgroundControl';
import './controls/SukiBuilderControl';
import './controls/SukiColorControl';
import './controls/SukiColorSelectControl';
import './controls/SukiDimensionControl';
import './controls/SukiDimensionsControl';
import './controls/SukiMultiCheckControl';
import './controls/SukiMultiSelectControl';
import './controls/SukiRadioImageControl';
import './controls/SukiShadowControl';
import './controls/SukiSliderControl';
import './controls/SukiToggleControl';
import './controls/SukiTypographyControl';

wp.customize.bind( 'ready', () => {
	/**
	 * Color Palette controls
	 */
	function setColorPaletteValue( i, color ) {
		const styleId = `suki-color-palette-${i}-output-css`;

		let styleTag = document.getElementById( styleId );

		if ( ! styleTag ) {
			styleTag = document.createElement( 'style' );
			styleTag.id = styleId;

			document.head.appendChild( styleTag );
		}

		styleTag.textContent = `.wp-customizer{--color-palette-${i}:${color}}`;
	}

	for ( let i = 1; i <= 8; i++ ) {
		wp.customize( `color_palette_${i}` ).bind( ( color ) => {
			setColorPaletteValue( i, color );
		} );

		setColorPaletteValue( i, wp.customize( `color_palette_${i}` ).get() );
	}
} );