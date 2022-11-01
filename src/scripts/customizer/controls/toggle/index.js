import './index.scss';

import SukiControlLabel from '../../components/control-label';
import SukiControlDescription from '../../components/control-description';

import { ToggleControl } from '@wordpress/components';

import { render } from '@wordpress/element';

wp.customize.SukiToggleControl = wp.customize.SukiReactControl.extend( {
	renderContent() {
		const control = this;

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

				<ToggleControl
					checked={ control.setting.get() ? true : false }
					id={ '_customize-input-' + control.id }
					className="suki-toggle"
					onChange={ () => {
						control.setting.set( ! control.setting.get() );
					} }
				/>
			</>,
			control.container[ 0 ]
		);
	},
} );

wp.customize.controlConstructor[ 'suki-toggle' ] = wp.customize.SukiToggleControl;
