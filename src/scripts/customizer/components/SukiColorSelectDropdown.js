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

import { sprintf } from '@wordpress/i18n';

function SukiColorSelectDropdown( props ) {
	let palette = [];

	for ( var i = 1; i <= 8; i++ ) {
		const color = wp.customize( 'color_palette_' + i ).get();

		palette.push( {
			name: wp.customize( 'color_palette_' + i + '_name' ).get() || sprintf( SukiCustomizerData.l10n.themeColor$d, i ),
			color: color,
			value: 'var(--color-palette-' + i + ')',
		} );
	}

	const value = props.value;

	const valueIsLink = value && 0 === value.indexOf( 'var(' ) ? true : false;

	const pickerIsOpened = value && ! valueIsLink;

	const valueInfo = valueIsLink ? palette.find( ( item ) => {
		return value === item.value
	} ) : {
		name: SukiCustomizerData.l10n.custom,
		color: value,
		value: value,
	};

	return(
		<>
		<div className="suki-color-dropdown">
			<SlotFillProvider>
				<Dropdown
					position="bottom left"
					focusOnMount="container"
					renderToggle={ ( toggleParams ) => {
						return (
							<Button
								isSmall
								variant="tertiary"
								label={ '' !== value ? valueInfo.name + ': ' + valueInfo.color : SukiCustomizerData.l10n.notSet }
								showTooltip
								aria-expanded={ toggleParams.isOpen }
								id={ props.id || null }
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
								spacing="3"
								style={ {
									width: '275px'
								} }
							>
								<HStack>
									<ColorPalette
										colors={ palette }
										value={ valueIsLink && valueInfo.color }
										disableCustomColors={ true }
										clearable={ false }
										className="suki-color-dropdown__palette"
										onChange={ ( color ) => {											
											if ( color ) {
												const colorInfo = palette.find( ( item ) => {
													return color === item.color
												} );

												props.changeValue( colorInfo.value );
											} else {
												props.changeValue( '' );
											}
										} }
									/>
									<div className="suki-color-dropdown__custom">
										<Button
											isSmall
											isPressed={ pickerIsOpened }
											variant="tertiary"
											icon="color-picker"
											label={ SukiCustomizerData.l10n.custom }
											showTooltip
											aria-expanded={ pickerIsOpened }
											className="suki-color-dropdown__custom__toggle"
											onClick={ ( e ) => {
												if ( pickerIsOpened ) {
													// isPresed: true
													props.changeValue( '' );
												} else {
													// isPressed: false
													if ( valueInfo.color ) {
														props.changeValue( valueInfo.color );
													} else {
														props.changeValue( props.defaultPickerValue || '#ffffff' );
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
										className="suki-color-dropdown__picker"
										onChange={ ( value ) => {
											props.changeValue( value );
										} }
									/>
								}

								{ props.defaultValue &&
									<HStack>
										<Button
											isSmall
											variant="secondary"
											onClick={ ( e ) => {
												props.changeValue( props.defaultValue );
											} }
										>
											{ SukiCustomizerData.l10n.reset }
										</Button>
									</HStack>
								}
							</VStack>
						);
					} }
				/>
				<Popover.Slot/>
			</SlotFillProvider>
		</div>
		</>
	);
}

export default SukiColorSelectDropdown;