import './index.scss';

import SukiControlLabel from '../../components/control-label';
import SukiControlDescription from '../../components/control-description';
import SukiControlResponsiveSwitcher from '../../components/control-responsive-switcher';
import SukiControlResponsiveContainer from '../../components/control-responsive-container';

import {
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalUnitControl as UnitControl,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalParseQuantityAndUnitFromRawValue as parseQuantityAndUnitFromRawValue,
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

					const valueUnit = parseQuantityAndUnitFromRawValue( value, control.params.units )[ 1 ] || control.params.units[ 0 ].value;

					const valueUnitObj = control.params.units.find( ( item ) => {
						return valueUnit === item.value;
					} );

					return (
						<SukiControlResponsiveContainer key={ device } device={ device }>
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
						</SukiControlResponsiveContainer>
					);
				} ) }
			</>,
			control.container[ 0 ]
		);
	},
} );

wp.customize.controlConstructor[ 'suki-dimension' ] = wp.customize.SukiDimensionControl;
