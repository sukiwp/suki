/**
 * Shadow control (React)
 */

import SukiControlLabel from '../components/SukiControlLabel';
import SukiControlDescription from '../components/SukiControlDescription';

import SukiColorSelectDropdown from '../components/SukiColorSelectDropdown';

import { convertDimensionValueIntoNumberAndUnit } from '../utils';

import {
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalGrid as Grid,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalUnitControl as UnitControl,
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

		// Split value into array.
		const valueSplit = control.setting.get().split( ' ', 6 );

		// Define value array and the fallback value.
		const valueObj = {
			x: valueSplit[ 0 ] ?? '',
			y: valueSplit[ 1 ] ?? '',
			blur: valueSplit[ 2 ] ?? '',
			spread: valueSplit[ 3 ] ?? '',
			color: valueSplit[ 4 ] ?? '',
			position: valueSplit[ 5 ] ?? '',
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
					size="small"
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
									const propValueUnit = convertDimensionValueIntoNumberAndUnit( valueObj[ prop ], units )[ 1 ];

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

												const newValue = Object.values( valueObj ).join( ' ' ).trim();

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

										const newValue = Object.values( valueObj ).join( ' ' ).trim();

										control.setting.set( newValue );
									} }
									__nextHasNoMarginBottom={ true }
								/>

								<SukiColorSelectDropdown
									value={ valueObj.color }
									changeValue={ ( newColorValue ) => {
										valueObj.color = newColorValue;

										const newValue = Object.values( valueObj ).join( ' ' ).trim();

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
