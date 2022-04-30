/**
 * Dimension control
 */

import SukiControlLabel from "../components/SukiControlLabel";
import SukiControlDescription from "../components/SukiControlDescription";
import SukiControlResponsiveSwitcher from "../components/SukiControlResponsiveSwitcher";
import SukiControlResponsiveContainer from "../components/SukiControlResponsiveContainer";

import {
	__experimentalUnitControl as UnitControl,
} from '@wordpress/components';

wp.customize.SukiDimensionControl = wp.customize.SukiReactControl.extend({
	renderContent: function() {
		const control = this;

		ReactDOM.render(
			<>
				{ control.params.label &&
					<SukiControlLabel for={ '_customize-input-' + control.id }>
						{ control.params.label }
						{ 1 < Object.keys( control.params.responsiveStructures ).length &&
							<SukiControlResponsiveSwitcher devices={ Object.keys( control.params.responsiveStructures ) }/>
						}
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
					 * @todo Wait for `parseQuantityAndUnitFromRawValue` to be available on UnitControl, and then we can replace our manual (non-safe) parsing with it instead.
					 */

					const valueNumber = parseFloat( value );
					const valueUnit = value.replace( valueNumber, '' );

					const activeUnit = control.params.units.find( ( item ) => {
						return valueUnit === item.value
					} );

					return (
						/**
						 * @todo onChange is triggered twice when value is not ''.
						 */
						<SukiControlResponsiveContainer key={ device } device={ device }>
							<UnitControl
								id={ '_customize-input-' + control.id }
								value={ value }
								isResetValueOnUnitChange
								units={ control.params.units }
								min={ activeUnit?.min ?? -Infinity }
								max={ activeUnit?.max ?? Infinity }
								step={ activeUnit?.step ?? 1 }
								className="suki-dimension"
								onChange={ ( value ) => {
									value = isNaN( parseFloat( value ) ) ? '' : value;
									console.log( value );
									control.settings[ settingId ].set( value );
								} }
							/>
						</SukiControlResponsiveContainer>
					);
				} ) }
			</>,
			control.container[0]
		);
	},
});

wp.customize.controlConstructor['suki-dimension'] = wp.customize.SukiDimensionControl;