/**
 * Multi Select control (using React)
 */

import SukiControlLabel from "../components/SukiControlLabel";
import SukiControlDescription from "../components/SukiControlDescription";
 
import {
	__experimentalItem as Item,
	__experimentalItemGroup as ItemGroup,
	SelectControl,
} from '@wordpress/components';

wp.customize.SukiMultiSelectControl = wp.customize.SukiReactControl.extend({
	initialize: function( id, params ) {
		const control = this;

		wp.customize.Control.prototype.initialize.call( control, id, params );
	},

	renderContent: function() {
		const control = this;

		const valueArray = control.setting.get();

		// If limit is set to `0`, it means limit is same as the number of options.
		const limit = control.params.itemsLimit || Object.keys( control.params.choices ).length;

		ReactDOM.render(
			<>
				<SukiControlLabel htmlFor={ '_customize-input-' + control.id }>
					{ control.params.label }
				</SukiControlLabel>
				<SukiControlDescription id={ '_customize-description-' + control.id }>
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
									style={ {
										display: 'flex',
										justifyContent: 'space-between',
										alignItems: 'center',
										gap: '12px',
									} }
								>
									<span>{ control.params.choices[ value ] }</span>
									<span
										role="button"
										aria-label={ control.params.l10n.remove }
										tabIndex="0"
										style={ {
											cursor: 'pointer',
										} }
										onClick={ () => {
											control.removeValueItem( value );
										} }
										onKeyUp={ ( e ) => {
											if ( 13 == e.which || 32 == e.which ) {
												control.removeValueItem( value );
											}
										} }
									>✕</span>
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
						{ control.params.l10n.addNew }
					</option>

					{ Object.keys( control.params.choices ).map( ( value ) => {
						return (
							<option
								key={ value }
								value={ value }
								disabled={ -1 === valueArray.indexOf( value ) ? false : true }
							>
								{ control.params.choices[ value ] }
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

		// Sort the combinedValue according to the original options order.
		valueArray = Object.keys( control.params.choices ).filter( ( key ) => {
			return -1 !== valueArray.indexOf( key );
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