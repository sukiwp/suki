import SukiControlLabel from '../../components/control-label';
import SukiControlDescription from '../../components/control-description';
import SukiControlResponsiveSwitcher from '../../components/control-responsive-switcher';
import SukiControlResponsiveContainer from '../../components/control-responsive-container';

import { RangeControl } from '@wordpress/components';

import { createRoot } from '@wordpress/element';

wp.customize.SukiSliderControl = wp.customize.SukiReactControl.extend( {
	renderContent() {
		const control = this;

		const min = parseFloat( control.params.min ) || 0;
		const max = parseFloat( control.params.max ) || 100;
		const step = parseFloat( control.params.step ) || 1;

		const content =
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

					return (
						<SukiControlResponsiveContainer key={ device } device={ device }>
							<RangeControl
								value={ value }
								min={ min }
								max={ max }
								step={ step }
								id={ '_customize-input-' + control.id }
								className="suki-slider"
								onChange={ ( newValue ) => {
									newValue = newValue || control.params.min;

									control.settings[ settingId ].set( newValue );
								} }
							/>
						</SukiControlResponsiveContainer>
					);
				} ) }
			</>;

		if ( ! control.root ) {
			control.root = createRoot( control.container[ 0 ] );
		}

		control.root.render( content );
	},
} );

wp.customize.controlConstructor[ 'suki-slider' ] = wp.customize.SukiSliderControl;
