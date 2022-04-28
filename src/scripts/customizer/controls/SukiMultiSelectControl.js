/**
 * Multi Select control (using React)
 */

import SukiControlLabel from "../components/SukiControlLabel";
import SukiControlDescription from "../components/SukiControlDescription";
 
import {
	__experimentalHStack as HStack,
	__experimentalItem as Item,
	__experimentalItemGroup as ItemGroup,
	Button,
	Text,
} from '@wordpress/components';

import { __ } from '@wordpress/i18n';

wp.customize.SukiMultiSelectControl = wp.customize.SukiReactControl.extend({
	renderContent: function() {
		const control = this;

		const valueArray = control.setting.get();

		// If limit is set to `0`, it means limit is same as the number of options.
		const limit = control.params.itemsLimit || control.params.choices.length;

		ReactDOM.render(
			<>
				<SukiControlLabel id={ control.id }>
					{ control.params.label }
				</SukiControlLabel>
				<SukiControlDescription id={ control.id }>
					{ control.params.description }
				</SukiControlDescription>

				{ 0 < valueArray.length &&
					<ItemGroup
						isSeparated
						isBordered
						size="small"
						style={ {
							backgroundColor: 'white',
							marginBottom: '8px',
						} }
					>
						{ valueArray.map( ( value ) => {
							return(
								<Item
									key={ value }
									data-value={ value }
									className="suki-multiselect-item"
								>
									<HStack
										expanded
										spacing="3"
									>
										<span>{ value }</span>
										<Button
											isSmall
											label={ __( 'Remove', 'suki' ) }
											showTooltip
											className="suki-multiselect-item__remove"
											onClick={ () => {
												control.removeValueItem( value );
											} }
										>
											✕
										</Button>
									</HStack>
								</Item>
							);
						} ) }
					</ItemGroup>
				}

				<select
					id={ '_customize-input-' + control.id }
					value=""
					disabled={ limit <= valueArray.length ? true : false }
					onChange={ ( e ) => {
						control.addNewValueItem( e.target.value );
					} }
				>
					<option
						value=""
						disabled
					>
						{ __( '＋ Add new', 'suki' ) }
					</option>

					{ control.params.choices.map( ( choice, i ) => {
						return (
							<option
								key={ choice.value }
								value={ choice.value }
								disabled={ -1 === valueArray.indexOf( choice.value ) ? false : true }
							>
								{ choice.label }
							</option>
						)
					} ) }
				</select>
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
});

wp.customize.controlConstructor['suki-multiselect'] = wp.customize.SukiMultiSelectControl;