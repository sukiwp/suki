/**
 * Shadow control (React)
 */

import SukiControlLabel from '../components/SukiControlLabel';
import SukiControlDescription from '../components/SukiControlDescription';

import SukiColorSelectDropdown from '../components/SukiColorSelectDropdown';

import { convertDimensionValueIntoNumberAndUnit } from '../utils';

import {
	__experimentalHStack as HStack,
	__experimentalUnitControl as UnitControl,
	Button,
} from '@wordpress/components';

wp.customize.SukiShadowControl = wp.customize.SukiReactControl.extend({
	renderContent: function() {
		const control = this;

		// Split value into array.
		let valueSplit = control.setting.get().split( ' ', 6 );
		
		// Define value array and the fallback value.
		let valueObj = {
			x: valueSplit[0] ?? '',
			y: valueSplit[1] ?? '',
			blur: valueSplit[2] ?? '',
			spread: valueSplit[3] ?? '',
			color: valueSplit[4] ?? '',
			position: valueSplit[5] ?? '',
		};

		ReactDOM.render(
			<>
				{ control.params.label &&
					<SukiControlLabel for={ '_customize-input-' + control.id }>
						{ control.params.label }
					</SukiControlLabel>
				}

				{ control.params.description &&
					<SukiControlDescription id={ '_customize-description-' + control.id }>
						{ control.params.description }
					</SukiControlDescription>
				}

				<HStack
					expanded
					align="top"
					spacing="0.5"
					className="suki-shadow"
				>
					<Button
						icon={ 'inset' === valueObj.position ? 'editor-contract' : 'editor-expand' }
						label={ 'inset' === valueObj.position ? SukiCustomizerData.l10n.innerShadow : SukiCustomizerData.l10n.outerShadow }
						showTooltip
						className="suki-shadow__position-toggle"
						onClick={ ( e ) => {
							valueObj.position = 'inset' === valueObj.position ? '' : 'inset';

							let newValue = Object.values( valueObj ).join( ' ' );
		
							control.setting.set( newValue );
						} }
					/>

					{ [ 'x', 'y', 'blur', 'spread' ].map( ( prop, i ) => {
						const [ propValueNumber, propValueUnit ] = convertDimensionValueIntoNumberAndUnit( valueObj[ prop ], control.params.units );

						const propValueUnitObj = control.params.units.find( ( item ) => {
							return propValueUnit === item.value
						} );

						return(
							<UnitControl
								key={ prop }
								label={ SukiCustomizerData.l10n[ prop ] }
								labelPosition="bottom"
								value={ valueObj[ prop ] }
								isResetValueOnUnitChange
								units={ control.params.units }
								min={ propValueUnitObj?.min ?? -Infinity }
								max={ propValueUnitObj?.max ?? Infinity }
								step={ propValueUnitObj?.step ?? 1 }
								className="suki-dimension"
								onChange={ ( newPropValue ) => {
									newPropValue = isNaN( parseFloat( newPropValue ) ) ? '0' : newPropValue;

									valueObj[ prop ] = newPropValue;

									let newValue = Object.values( valueObj ).join( ' ' );
		
									control.setting.set( newValue );
								} }
							/>
						);
					} ) }

					<SukiColorSelectDropdown
						value={ valueObj.color }
						changeValue={ ( newColorValue ) => {
							valueObj.color = newColorValue;

							let newValue = Object.values( valueObj ).join( ' ' );
		
							control.setting.set( newValue );
						} }
						defaultValue="#00000000"
						defaultPickerValue="#000000"
					/>
				</HStack>
			</>,
			control.container[0]
		);
	},
});

wp.customize.controlConstructor['suki-shadow'] = wp.customize.SukiShadowControl;