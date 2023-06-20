import './index.scss';

import SukiControlLabel from '../../components/control-label';
import SukiControlDescription from '../../components/control-description';

import { ToggleControl } from '@wordpress/components';

import { createRoot } from '@wordpress/element';

wp.customize.SukiToggleControl = wp.customize.SukiReactControl.extend( {
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

				<ToggleControl
					checked={ 1 === control.setting.get() ? true : false }
					id={ '_customize-input-' + control.id }
					className="suki-toggle"
					onChange={ ( checked ) => {
						control.setting.set( checked ? 1 : 0 );
					} }
					__nextHasNoMarginBottom
				/>
			</>;

		if ( ! control.root ) {
			control.root = createRoot( control.container[ 0 ] );
		}

		control.root.render( content );
	},
} );

wp.customize.controlConstructor[ 'suki-toggle' ] = wp.customize.SukiToggleControl;
