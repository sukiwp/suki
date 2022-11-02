import './index.scss';

import SukiControlLabel from '../../components/control-label';
import SukiControlDescription from '../../components/control-description';

import SukiBuilder from './builder';

import { render } from '@wordpress/element';

wp.customize.SukiBuilderControl = wp.customize.SukiReactControl.extend( {
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

				<SukiBuilder control={ control } />
			</>,
			control.container[ 0 ]
		);
	},
} );

wp.customize.controlConstructor[ 'suki-builder' ] = wp.customize.SukiBuilderControl;
