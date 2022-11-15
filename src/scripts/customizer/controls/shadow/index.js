import SukiControlLabel from '../../components/control-label';
import SukiControlDescription from '../../components/control-description';

import SukiColorSelectDropdown from '../../components/color-select-dropdown';

import {
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalGrid as Grid,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalUnitControl as UnitControl,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalParseQuantityAndUnitFromRawValue as parseQuantityAndUnitFromRawValue,
	CardBody,
	Card,
	Flex,
	ToggleControl,
} from '@wordpress/components';

import { render } from '@wordpress/element';

import { __ } from '@wordpress/i18n';

wp.customize.SukiShadowControl = wp.customize.SukiReactControl.extend( {
	renderContent() {
		const control = this;

		const units = [
			{ value: 'px', label: 'px' },
			{ value: 'em', label: 'em' },
			{ value: 'rem', label: 'rem' },
		];

		let value = control.setting.get();

		if ( 'string' === typeof value ) {
			value = value.split( ' ' );
		}

		// Define value array and the fallback value.
		const valueObj = {
			x: value[ 0 ] ?? '',
			y: value[ 1 ] ?? '',
			blur: value[ 2 ] ?? '',
			spread: value[ 3 ] ?? '',
			color: value[ 4 ] ?? '',
			position: value[ 5 ] ?? '',
		};

		const labels = {
			x: __( 'X', 'suki' ),
			y: __( 'Y', 'suki' ),
			blur: __( 'Blur', 'suki' ),
			spread: __( 'Spread', 'suki' ),
		};

		render(
			<>
				{ control.params.label &&
					<SukiControlLabel target={ '_customize-input-' + control.id }>
						{ control.params.label }
					</SukiControlLabel>
				}

				{ control.params.description &&
					<SukiControlDescription id={ '_customize-description-' + control.id }>
						{ control.params.description }
					</SukiControlDescription>
				}

				<Card
					size="xSmall"
				>
					<CardBody>
						<Flex
							direction="column"
						>
							<Grid
								columns="4"
								gap="1"
							>
								{ [ 'x', 'y', 'blur', 'spread' ].map( ( prop ) => {
									const propValueUnit = parseQuantityAndUnitFromRawValue( valueObj[ prop ], units )[ 1 ] || units[ 0 ].value;

									const propValueUnitObj = units.find( ( item ) => {
										return propValueUnit === item.value;
									} );

									return (
										<UnitControl
											key={ prop }
											label={ labels[ prop ] }
											value={ valueObj[ prop ] }
											isResetValueOnUnitChange
											units={ units }
											min={ '' === propValueUnitObj.min ? -Infinity : propValueUnitObj.min }
											max={ '' === propValueUnitObj.max ? Infinity : propValueUnitObj.max }
											step={ '' === propValueUnitObj.step ? 1 : propValueUnitObj.step }
											className="suki-dimension"
											onChange={ ( newPropValue ) => {
												newPropValue = isNaN( parseFloat( newPropValue ) ) ? '0' : newPropValue;

												valueObj[ prop ] = newPropValue;

												const newValue = Object.values( valueObj );

												control.setting.set( newValue );
											} }
										/>
									);
								} ) }
							</Grid>

							<Flex>
								<ToggleControl
									label={ __( 'Inner shadow', 'suki' ) }
									checked={ 'inset' === valueObj.position }
									onChange={ () => {
										valueObj.position = 'inset' === valueObj.position ? '' : 'inset';

										const newValue = Object.values( valueObj );

										control.setting.set( newValue );
									} }
									__nextHasNoMarginBottom
								/>

								<SukiColorSelectDropdown
									value={ valueObj.color }
									changeValue={ ( newColorValue ) => {
										valueObj.color = newColorValue;

										const newValue = Object.values( valueObj );

										control.setting.set( newValue );
									} }
									defaultValue="#00000000"
									defaultPickerValue="#000000"
								/>
							</Flex>
						</Flex>
					</CardBody>
				</Card>
			</>,
			control.container[ 0 ]
		);
	},
} );

wp.customize.controlConstructor[ 'suki-shadow' ] = wp.customize.SukiShadowControl;
