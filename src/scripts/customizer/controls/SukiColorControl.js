/**
 * Color control
 */

import SukiControlLabel from "../components/SukiControlLabel";
import SukiControlDescription from "../components/SukiControlDescription";

import {
	Button,
	ColorIndicator,
	ColorPalette,
	ColorPicker,
	Dropdown,
	Icon,
	Popover,
	SlotFillProvider,
} from '@wordpress/components';

wp.customize.SukiColorControl = wp.customize.SukiReactControl.extend({
	renderContent: function() {
		const control = this;

		const colorValue = control.setting.get();

		const colorValueIsLinked = 0 === colorValue.indexOf( 'var(' ) ? true : false;

		let colorPalette = [];
		for ( var i = 1; i <= 8; i++ ) {
			colorPalette.push( {
				name: wp.customize( 'color_palette_' + i + '_name' ).get() || sprintf( __( 'Theme Color %d', 'suki' ), i ),
				color: 'var(--color-palette-' + i + ')',
				actualValue: wp.customize( 'color_palette_' + i ).get(),
			} );
		}

		ReactDOM.render(
			<>
				<SukiControlLabel htmlFor={ '_customize-input-' + control.id }>
					{ control.params.label }
				</SukiControlLabel>
				<SukiControlDescription id={ '_customize-description-' + control.id }>
					{ control.params.description }
				</SukiControlDescription>

				<SlotFillProvider>
					<Dropdown
						position="bottom left"
						className="suki-color-wrapper"
						renderToggle={ ( toggleParams ) => {
							return (
								<Button
									isSmall
									variant="tertiary"
									className="suki-color-toggle"
									aria-expanded={ toggleParams.isOpen }
									onClick={ toggleParams.onToggle }
								>
									<ColorIndicator
										colorValue={ colorValue }
										className="suki-color-toggle-indicator"
									/>
									{ colorValueIsLinked &&
										<Icon icon="admin-links" className="suki-color-toggle-indicator__linked"/>
									}
								</Button>
							);
						} }
						renderContent={ ( contentParams ) => {
							if ( control.params.hasPalette ) {
								return (
									<ColorPalette
										colors={ colorPalette }
										value={ colorValue }
										onChange={ ( color ) => {
											control.setting.set( color );
										} }
									/>
								);
							} else {
								return(
									<>
										<ColorPicker
											color={ colorValue }
											onChange={ ( color ) => {
												control.setting.set( color );
											} }
											defaultValue={ control.params.defaultValue }
											enableAlpha
										/>
										<Button
											variant="secondary"
											isSmall
											onClick={ ( e ) => {
												control.setting.set( control.params.defaultValue );
											} }
										>
											Reset
										</Button>
									</>
								);
							}
						} }
					/>
					<Popover.Slot/>
				</SlotFillProvider>
			</>,
			control.container[0]
		);
	},
});

wp.customize.controlConstructor['suki-color'] = wp.customize.SukiColorControl;