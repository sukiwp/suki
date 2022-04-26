/**
 * Color control
 */

import SukiControlLabel from "../components/SukiControlLabel";
import SukiControlDescription from "../components/SukiControlDescription";

import {
	Popover
} from '@wordpress/components';

wp.customize.SukiColorControl = wp.customize.SukiReactControl.extend({
	renderContent: function() {
		const control = this;

		ReactDOM.render(
			<>
				<SukiControlLabel htmlFor={ '_customize-input-' + control.id }>
					{ control.params.label }
				</SukiControlLabel>
				<SukiControlDescription id={ '_customize-description-' + control.id }>
					{ control.params.description }
				</SukiControlDescription>
			</>,
			control.container[0]
		);
	},
});

wp.customize.controlConstructor['suki-color'] = wp.customize.SukiColorControl;