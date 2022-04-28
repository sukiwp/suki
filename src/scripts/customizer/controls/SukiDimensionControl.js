/**
 * Dimension control
 */

import SukiControlLabel from "../components/SukiControlLabel";
import SukiControlDescription from "../components/SukiControlDescription";
import SukiControlResponsiveGroup from "../components/SukiControlResponsiveGroup";

import {
	__experimentalUnitControl as UnitControl,
} from '@wordpress/components';

wp.customize.SukiDimensionControl = wp.customize.SukiReactControl.extend({
	renderContent: function() {
		const control = this;

		ReactDOM.render(
			<>
				<SukiControlLabel id={ control.id }>
					{ control.params.label }
				</SukiControlLabel>
				<SukiControlDescription id={ control.id }>
					{ control.params.description }
				</SukiControlDescription>
				
				{ Object.keys( control.params.responsiveStructures ).map( ( deviceId ) => {
					const settingId = control.params.responsiveStructures[ deviceId ];

					const value = control.settings[ settingId ].get();

					/**
					 * @todo Wait for `parseQuantityAndUnitFromRawValue` to be available on UnitControl, and then we can replace our manual (non-safe) parsing with it instead.
					 */

					const valueNumber = parseFloat( value );

					const valueUnit = value.replace( valueNumber, '' );

					const currentUnit = control.params.units.find( ( item ) => {
						return valueUnit === item.value
					} );

					return (
						<SukiControlResponsiveGroup key={ deviceId } data-device={ deviceId }>
							<UnitControl
								value={ value }
								isPressEnterToChange
								isResetValueOnUnitChange
								units={ control.params.units }
								min={ '' !== currentUnit.min ? currentUnit.min : -Infinity }
								max={ '' !== currentUnit.max ? currentUnit.max : Infinity }
								step={ '' !== currentUnit.step ? currentUnit.step : 1 }
								className="suki-dimension"
								onChange={ ( value ) => {
									control.settings[ settingId ].set( value );
								} }
							/>
						</SukiControlResponsiveGroup>
					);
				} ) }
			</>,
			control.container[0]
		);
	},
});

wp.customize.controlConstructor['suki-dimension'] = wp.customize.SukiDimensionControl;