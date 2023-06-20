import './index.scss';

import SukiControlLabel from '../../components/control-label';
import SukiControlDescription from '../../components/control-description';

import SukiColorSelectDropdown from '../../components/color-select-dropdown';

import { createRoot } from '@wordpress/element';

wp.customize.SukiColorSelectControl = wp.customize.SukiReactControl.extend( {
	renderContent() {
		const control = this;

		const value = control.setting.get();

		const content =
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
					defaultValue={ String( control.params.defaultValue ) }
					defaultPickerValue="#ffffff"
					id={ '_customize-input' + control.id }
				/>
			</>;

		if ( ! control.root ) {
			control.root = createRoot( control.container[ 0 ] );
		}

		control.root.render( content );
	},
} );

wp.customize.controlConstructor[ 'suki-color-select' ] = wp.customize.SukiColorSelectControl;
