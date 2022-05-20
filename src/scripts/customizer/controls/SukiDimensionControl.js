/**
 * Dimension control (React)
 */

import SukiControlLabel from '../components/SukiControlLabel';
import SukiControlDescription from '../components/SukiControlDescription';
import SukiControlResponsiveSwitcher from '../components/SukiControlResponsiveSwitcher';
import SukiControlResponsiveContainer from '../components/SukiControlResponsiveContainer';

import { convertDimensionValueIntoNumberAndUnit } from '../utils';

import {
	__experimentalGrid as Grid,
	__experimentalUnitControl as UnitControl,
} from '@wordpress/components';

wp.customize.SukiDimensionControl = wp.customize.SukiReactControl.extend( {
	renderContent: function() {
		const control = this;

		ReactDOM.render(
			<>
				{ control.params.label &&
					<SukiControlLabel target={ '_customize-input-' + control.id }>
						{ control.params.label }
						
						<SukiControlResponsiveSwitcher devices={ Object.keys( control.params.responsiveStructures ) }/>
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

					const [ valueNumber, valueUnit ] = convertDimensionValueIntoNumberAndUnit( value, control.params.units );

					const valueUnitObj = control.params.units.find( ( item ) => {
						return valueUnit === item.value
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
									min={ valueUnitObj?.min ?? -Infinity }
									max={ valueUnitObj?.max ?? Infinity }
									step={ valueUnitObj?.step ?? 1 }
									id={ '_customize-input-' + control.id }
									className="suki-dimension"
									onChange={ ( value ) => {
										// If value only contains unit (e.g. 'px'), set the value to empty string ('').
										value = isFinite( parseFloat( value ) ) ? value : '';

										control.settings[ settingId ].set( value );
									} }
								/>
							</Grid>
						</SukiControlResponsiveContainer>
					);
				} ) }
			</>,
			control.container[0]
		);
	},
} );

wp.customize.controlConstructor['suki-dimension'] = wp.customize.SukiDimensionControl;