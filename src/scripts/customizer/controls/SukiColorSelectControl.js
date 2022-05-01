/**
 * Color control
 */

import SukiControlLabel from "../components/SukiControlLabel";
import SukiControlDescription from "../components/SukiControlDescription";

import {
	__experimentalHStack as HStack,
	__experimentalVStack as VStack,
	Button,
	ColorIndicator,
	ColorPalette,
	ColorPicker,
	Dropdown,
	Popover,
	SlotFillProvider,
} from '@wordpress/components';

import {
	__,
	sprintf,
} from '@wordpress/i18n';

wp.customize.SukiColorSelectControl = wp.customize.SukiReactControl.extend({
	getColorPalette: function() {
		let colorPalette = [];
		for ( var i = 1; i <= 8; i++ ) {
			colorPalette.push( {
				name: wp.customize( 'color_palette_' + i + '_name' ).get() || sprintf( __( 'Theme Color %d', 'suki' ), i ),
				color: 'var(--color-palette-' + i + ')',
				actualValue: wp.customize( 'color_palette_' + i ).get(),
			} );
		}

		return colorPalette;
	},

	renderContent: function() {
		const control = this;

		const palette = control.getColorPalette();

		const value = control.setting.get();

		const valueIsLink = value && 0 === value.indexOf( 'var(' ) ? true : false;

		const pickerIsOpened = value && ! valueIsLink;

		const valueInfo = valueIsLink ? palette.find( ( item ) => {
			return value === item.color
		} ) : {
			name: __( 'Custom', 'suki' ),
			color: value,
			actualValue: value,
		};

		ReactDOM.render(
			<>
				{ control.params.label &&
					<SukiControlLabel for={ '_customize-input-' + control.id }>
						{ control.params.label }
					</SukiControlLabel>
				}

				{ control.params.description &&
					<SukiControlDescription id={ '_customize-description-' + control.id }>
						{ control.params.description }
					</SukiControlDescription>
				}

				<SlotFillProvider>
					<Dropdown
						position="bottom left"
						className="suki-color-dropdown"
						focusOnMount="container"
						renderToggle={ ( toggleParams ) => {
							return (
								<Button
									isSmall
									variant="tertiary"
									label={ valueInfo.name + ': ' + valueInfo.actualValue }
									showTooltip
									aria-expanded={ toggleParams.isOpen }
									id={ '_customize-input' + control.id }
									className="suki-color-dropdown__toggle"
									onClick={ toggleParams.onToggle }
								>
									<ColorIndicator
										colorValue={ value }
										className={ 'suki-color-indicator' + ( valueIsLink ? ' suki-color-indicator--linked' : '' ) }
									/>
								</Button>
							);
						} }
						renderContent={ ( contentParams ) => {
							return (
								<VStack
									style={ {
										width: '275px'
									} }
									spacing="3"
								>
									<HStack>
										<ColorPalette
											colors={ palette }
											value={ value }
											disableCustomColors={ true }
											clearable={ false }
											className="suki-color-select-palette"
											onChange={ ( color ) => {
												if ( color ) {
													control.setting.set( color );
												} else {
													control.setting.set( '' );
												}
											} }
										/>
										<div className="suki-color-select-custom">
											<Button
												isSmall
												isPressed={ pickerIsOpened }
												variant="tertiary"
												icon="color-picker"
												label={ __( 'Custom', 'suki' ) }
												showTooltip
												aria-expanded={ pickerIsOpened }
												onClick={ ( e ) => {
													if ( pickerIsOpened ) {
														// isPresed: true
														control.setting.set( '' );
													} else {
														// isPressed: false
														if ( valueInfo.actualValue ) {
															control.setting.set( valueInfo.actualValue );
														} else {
															control.setting.set( '#ffffff' );
														}
													}
												} }
											/>
										</div>
									</HStack>

									{ pickerIsOpened &&
										<ColorPicker
											color={ value }
											enableAlpha
											className="suki-color-select-custom__picker"
											onChange={ ( color ) => {
												control.setting.set( color );
											} }
										/>
									}

									{ control.params.defaultValue &&
										<HStack>
											<Button
												isSmall
												variant="secondary"
												onClick={ ( e ) => {
													control.setting.set( control.params.defaultValue );
												} }
											>
												{ __( 'Reset', 'suki' ) }
											</Button>
										</HStack>
									}
								</VStack>
							);
						} }
					/>
					<Popover.Slot/>
				</SlotFillProvider>
			</>,
			control.container[0]
		);
	},
});

wp.customize.controlConstructor['suki-color-select'] = wp.customize.SukiColorSelectControl;