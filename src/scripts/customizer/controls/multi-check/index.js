import SukiControlLabel from '../../components/control-label';
import SukiControlDescription from '../../components/control-description';

import {
	CheckboxControl,
	Flex,
} from '@wordpress/components';

import { render } from '@wordpress/element';

wp.customize.SukiMultiCheckControl = wp.customize.SukiReactControl.extend( {
	renderContent() {
		const control = this;

		const valueArray = control.setting.get();

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

				<Flex>
					{ control.params.choices.map( ( choice ) => {
						return (
							<CheckboxControl
								key={ choice.value }
								label={ choice.label }
								checked={ -1 !== valueArray.indexOf( choice.value ) }
								onChange={ ( newValue ) => {
									if ( newValue ) {
										control.addNewValueItem( choice.value );
									} else {
										control.removeValueItem( choice.value );
									}
								} }
							/>
						);
					} ) }
				</Flex>
			</>,
			control.container[ 0 ]
		);
	},

	addNewValueItem( value ) {
		const control = this;

		let valueArray = control.setting.get() || [];

		// Add the selected item into the value array.
		if ( -1 === valueArray.indexOf( value ) ) {
			valueArray = [ ...valueArray, value ];
		}

		const choicesValues = control.params.choices.map( ( item ) => {
			return item.value;
		} );

		// Sort the combinedValue according to the original options order.
		valueArray = choicesValues.filter( ( choice ) => {
			return -1 !== valueArray.indexOf( choice );
		} );

		control.setting.set( valueArray );
	},

	removeValueItem( removedValue ) {
		const control = this;

		let valueArray = control.setting.get() || [];

		// Remove the clicked item from the value array.
		valueArray = valueArray.filter( ( value ) => {
			return value !== removedValue;
		} );

		control.setting.set( valueArray );
	},
} );

wp.customize.controlConstructor[ 'suki-multicheck' ] = wp.customize.SukiMultiCheckControl;
