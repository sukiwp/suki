/**
 * Slider control (React)
 */

import SukiControlLabel from '../components/SukiControlLabel';
import SukiControlDescription from '../components/SukiControlDescription';
import SukiControlResponsiveSwitcher from '../components/SukiControlResponsiveSwitcher';
import SukiControlResponsiveContainer from '../components/SukiControlResponsiveContainer';

import { RangeControl } from '@wordpress/components';

wp.customize.SukiSliderControl = wp.customize.SukiReactControl.extend( {
	renderContent: function() {
		const control = this;

		const min = parseFloat( control.params.min ) || 0;
		const max = parseFloat( control.params.max ) || 100;
		const step = parseFloat( control.params.step ) || 1;

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

					return (
						<SukiControlResponsiveContainer key={ device } device={ device }>
							<RangeControl
								value={ value }
								min={ min }
								max={ max }
								step={ step }
								id={ '_customize-input-' + control.id }
								className="suki-slider"
								onChange={ ( value ) => {
									value = value || control.params.min;

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
} );

wp.customize.controlConstructor['suki-slider'] = wp.customize.SukiSliderControl;