/**
 * Toggle control
 */

import SukiControlLabel from "../components/SukiControlLabel";
import SukiControlDescription from "../components/SukiControlDescription";

import { FormToggle } from '@wordpress/components';

wp.customize.SukiToggleControl = wp.customize.SukiReactControl.extend({
	renderContent: function() {
		const control = this;

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

				<FormToggle
					id={ '_customize-input-' + control.id }
					className="suki-toggle"	
					checked={ control.setting.get() ? true : false }
					onChange={ ( e ) => {
						control.setting.set( e.target.checked );
					} }
				/>
			</>,
			control.container[0]
		);
	},
});

wp.customize.controlConstructor['suki-toggle'] = wp.customize.SukiToggleControl;