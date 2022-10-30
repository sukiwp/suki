/**
 * Dimensions control (React)
 */

import SukiControlLabel from '../components/SukiControlLabel';
import SukiControlDescription from '../components/SukiControlDescription';
import SukiControlResponsiveSwitcher from '../components/SukiControlResponsiveSwitcher';
import SukiControlResponsiveContainer from '../components/SukiControlResponsiveContainer';

import { convertDimensionValueIntoNumberAndUnit } from '../utils';

import {
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalGrid as Grid,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalUnitControl as UnitControl,
	CardBody,
	Card,
} from '@wordpress/components';

import { render } from '@wordpress/element';

import { __ } from '@wordpress/i18n';

wp.customize.SukiDimensionsControl = wp.customize.SukiReactControl.extend( {
	renderContent() {
		const control = this;

		const directions = [
			__( 'Top', 'suki' ),
			__( 'Right', 'suki' ),
			__( 'Bottom', 'suki' ),
			__( 'Left', 'suki' ),
		];

		render(
			<>
				{ control.params.label &&
					<SukiControlLabel target={ '_customize-input-' + control.id }>
						{ control.params.label }
						<SukiControlResponsiveSwitcher devices={ Object.keys( control.params.responsiveStructures ) } />
					</SukiControlLabel>
				}

				{ control.params.description &&
					<SukiControlDescription id={ '_customize-description-' + control.id }>
						{ control.params.description }
					</SukiControlDescription>
				}

				{ Object.keys( control.params.responsiveStructures ).map( ( device ) => {
					const settingId = control.params.responsiveStructures[ device ];

					let value = control.settings[ settingId ].get();

					if ( 'string' === typeof value ) {
						value = value.split( ' ' );
					}

					const valueArray = [
						value[ 0 ] ?? '',
						value[ 1 ] ?? '',
						value[ 2 ] ?? '',
						value[ 3 ] ?? '',
					];

					return (
						<SukiControlResponsiveContainer
							key={ device }
							device={ device }
						>
							<Card
								size="small"
							>
								<CardBody>
									<Grid
										columns="4"
										gap="1"
									>
										{ valueArray.map( ( subValue, i ) => {
											/**
											 * @todo Wait for `parseQuantityAndUnitFromRawValue` to be available on UnitControl, and then we can replace our manual (non-safe) parsing with it instead.
											 */

											const subValueUnit = convertDimensionValueIntoNumberAndUnit( subValue, control.params.units )[ 1 ];

											const subValueUnitObj = control.params.units.find( ( item ) => {
												return subValueUnit === item.value;
											} );

											return (
												<UnitControl
													key={ device + '-' + i }
													label={ directions[ i ] }
													value={ subValue }
													isResetValueOnUnitChange
													units={ control.params.units }
													min={ '' === subValueUnitObj.min ? -Infinity : subValueUnitObj.min }
													max={ '' === subValueUnitObj.max ? Infinity : subValueUnitObj.max }
													step={ '' === subValueUnitObj.step ? 1 : subValueUnitObj.step }
													className="suki-dimension"
													onChange={ ( newSubValue ) => {
														newSubValue = isNaN( parseFloat( newSubValue ) ) ? '' : newSubValue;

														valueArray[ i ] = newSubValue;

														// control.settings[ settingId ].set( '' );
														control.settings[ settingId ].set( valueArray );
													} }
												/>
											);
										} ) }
									</Grid>
								</CardBody>
							</Card>
						</SukiControlResponsiveContainer>
					);
				} ) }
			</>,
			control.container[ 0 ]
		);
	},
} );

wp.customize.controlConstructor[ 'suki-dimensions' ] = wp.customize.SukiDimensionsControl;
