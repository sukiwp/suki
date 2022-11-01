/**
 * Dimension control (React)
 */

import SukiControlLabel from '../../components/control-label';
import SukiControlDescription from '../../components/control-description';
import SukiControlResponsiveSwitcher from '../../components/control-responsive-switcher';
import SukiControlResponsiveContainer from '../../components/control-responsive-container';

import { convertDimensionValueIntoNumberAndUnit } from '../../utils';

import {
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalGrid as Grid,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalUnitControl as UnitControl,
} from '@wordpress/components';

import { render } from '@wordpress/element';

wp.customize.SukiDimensionControl = wp.customize.SukiReactControl.extend( {
	renderContent() {
		const control = this;

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

					const value = control.settings[ settingId ].get();

					/**
					 * @todo Wait for `parseQuantityAndUnitFromRawValue` to be available on UnitControl. For the time being, we are using our own function `convertDimensionValueIntoNumberAndUnit`.
					 */

					const valueUnit = convertDimensionValueIntoNumberAndUnit( value, control.params.units )[ 1 ];

					const valueUnitObj = control.params.units.find( ( item ) => {
						return valueUnit === item.value;
					} );

					return (
						<SukiControlResponsiveContainer key={ device } device={ device }>
							<Grid
								columns="4"
								gap="1"
							>
								<UnitControl
									value={ value }
									isResetValueOnUnitChange
									units={ control.params.units }
									min={ '' === valueUnitObj.min ? -Infinity : valueUnitObj.min }
									max={ '' === valueUnitObj.max ? Infinity : valueUnitObj.max }
									step={ '' === valueUnitObj.step ? 1 : valueUnitObj.step }
									id={ '_customize-input-' + control.id }
									className="suki-dimension"
									onChange={ ( newValue ) => {
										// If value only contains unit (e.g. 'px'), set the value to empty string ('').
										newValue = isFinite( parseFloat( newValue ) ) ? newValue : '';

										control.settings[ settingId ].set( newValue );
									} }
								/>
							</Grid>
						</SukiControlResponsiveContainer>
					);
				} ) }
			</>,
			control.container[ 0 ]
		);
	},
} );

wp.customize.controlConstructor[ 'suki-dimension' ] = wp.customize.SukiDimensionControl;
