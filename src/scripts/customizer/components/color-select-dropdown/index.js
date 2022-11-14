import './index.scss';

import {
	Button,
	ColorIndicator,
	ColorPalette,
	ColorPicker,
	Dropdown,
	Flex,
	Popover,
	SlotFillProvider,
} from '@wordpress/components';

import {
	__,
	sprintf,
} from '@wordpress/i18n';

const SukiColorSelectDropdown = ( { changeValue, defaultPickerValue, defaultValue, value } ) => {
	const palette = [];

	for ( let i = 1; i <= 8; i++ ) {
		const color = wp.customize( `color_palette_${ i }` ).get();

		palette.push( {
			/* translators: %d: number. */
			name: wp.customize( `color_palette_${ i }_name` ).get() || sprintf( __( 'Theme Color %d', 'suki' ), i ),
			color: `var(--color-palette-${ i })`,
			actualValue: color,
		} );
	}

	const valueIsLink = value && 0 === value.indexOf( 'var(' ) ? true : false;

	const pickerIsOpened = value && ! valueIsLink;

	const valueInfo = valueIsLink ? palette.find( ( item ) => {
		return value === item.color;
	} ) : {
		name: __( 'Custom', 'suki' ),
		color: value,
		actualValue: value,
	};

	return (
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
								label={ '' !== value ? valueInfo.name : __( 'Not set', 'suki' ) }
								showTooltip
								aria-expanded={ toggleParams.isOpen }
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
					renderContent={ () => {
						return (
							<Flex
								direction="column"
								gap="3"
								style={ {
									width: '248px',
								} }
							>
								<Flex gap="1">
									<ColorPalette
										colors={ palette }
										value={ valueIsLink ? valueInfo.color : '' }
										disableCustomColors={ true }
										clearable={ false }
										className="suki-color-dropdown__palette"
										onChange={ ( color ) => {
											changeValue( color );
										} }
									/>
									<div className="suki-color-dropdown__custom">
										<Button
											isSmall
											isPressed={ pickerIsOpened }
											variant="tertiary"
											icon="color-picker"
											label={ __( 'Custom', 'suki' ) }
											showTooltip
											aria-expanded={ pickerIsOpened }
											className="suki-color-dropdown__custom__toggle"
											onClick={ () => {
												if ( pickerIsOpened ) {
													// Pressed
													changeValue( '' );
												} else if ( valueInfo.actualValue ) {
													// Not pressed but has actual value
													changeValue( valueInfo.actualValue );
												} else {
													// Not pressed
													changeValue( defaultPickerValue || '#ffffff' );
												}
											} }
										/>
									</div>
								</Flex>

								{ pickerIsOpened &&
									<ColorPicker
										color={ value }
										enableAlpha
										className="suki-color-dropdown__picker"
										onChange={ ( newValue ) => {
											changeValue( newValue );
										} }
									/>
								}

								{ defaultValue &&
									<Flex>
										<Button
											isSmall
											variant="secondary"
											onClick={ () => {
												changeValue( defaultValue );
											} }
										>
											{ __( 'Reset', 'suki' ) }
										</Button>
									</Flex>
								}
							</Flex>
						);
					} }
				/>
				<Popover.Slot />
			</SlotFillProvider>
		</div>
	);
};

export default SukiColorSelectDropdown;
