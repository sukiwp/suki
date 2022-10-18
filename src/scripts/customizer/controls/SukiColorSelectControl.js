/**
 * Color control (React)
 */

import SukiControlLabel from '../components/SukiControlLabel';
import SukiControlDescription from '../components/SukiControlDescription';

import SukiColorSelectDropdown from '../components/SukiColorSelectDropdown';

import { render } from '@wordpress/element';

wp.customize.SukiColorSelectControl = wp.customize.SukiReactControl.extend( {
	renderContent() {
		const control = this;

		const value = control.setting.get();

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

				<SukiColorSelectDropdown
					value={ value }
					changeValue={ ( newColorValue ) => {
						control.setting.set( newColorValue );
					} }
					defaultValue={ control.params.defaultValue || null }
					defaultPickerValue="#ffffff"
					id={ '_customize-input' + control.id }
				/>
			</>,
			control.container[ 0 ]
		);
	},
} );

wp.customize.controlConstructor[ 'suki-color-select' ] = wp.customize.SukiColorSelectControl;
