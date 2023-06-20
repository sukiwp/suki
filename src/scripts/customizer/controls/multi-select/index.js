import './index.scss';

import SukiControlLabel from '../../components/control-label';
import SukiControlDescription from '../../components/control-description';

import SukiMultiSelect from './multi-select';

import { createRoot } from '@wordpress/element';

wp.customize.SukiMultiSelectControl = wp.customize.SukiReactControl.extend( {
	renderContent() {
		const control = this;

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

				<SukiMultiSelect control={ control } />
			</>;

		if ( ! control.root ) {
			control.root = createRoot( control.container[ 0 ] );
		}

		control.root.render( content );
	},
} );

wp.customize.controlConstructor[ 'suki-multiselect' ] = wp.customize.SukiMultiSelectControl;
