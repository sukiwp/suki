/**
 * Multi-check control (React)
 */

import SukiControlLabel from '../components/SukiControlLabel';
import SukiControlDescription from '../components/SukiControlDescription';

import {
	__experimentalVStack as VStack,
	CheckboxControl,
} from '@wordpress/components';

wp.customize.SukiMultiCheckControl = wp.customize.SukiReactControl.extend( {
	renderContent: function() {
		const control = this;

		const valueArray = control.setting.get();

		ReactDOM.render(
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

				<VStack
					spacing="1.5"
				>
					{ control.params.choices.map( ( choice, i ) => {
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
						)
					} ) }
					
				</VStack>
			</>,
			control.container[0]
		);
	},

	addNewValueItem: function( value ) {
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

	removeValueItem: function( removedValue ) {
		const control = this;

		let valueArray = control.setting.get() || [];

		// Remove the clicked item from the value array.
		valueArray = valueArray.filter( ( value ) => {
			return value !== removedValue;
		} )

		control.setting.set( valueArray );
	},
} );

wp.customize.controlConstructor['suki-multicheck'] = wp.customize.SukiMultiCheckControl;