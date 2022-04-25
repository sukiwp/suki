/**
 * Multi Select control
 */

import SukiControlLabel from "../components/SukiControlLabel";
import SukiControlDescription from "../components/SukiControlDescription";

import {
	SelectControl,
	Button,
	__experimentalItemGroup as ItemGroup,
	__experimentalItem as Item,
} from '@wordpress/components';

wp.customize.SukiMultiSelectControl = wp.customize.SukiReactControl.extend({
	initialize: function( id, params ) {
		const control = this;

		// Bind functions to this control context for passing as React props.
		control.handleAddNew = control.handleAddNew.bind( control );
		control.handleRemove = control.handleRemove.bind( control );

		wp.customize.Control.prototype.initialize.call( control, id, params );
	},

	renderContentForm: function( container ) {
		const control = this;

		ReactDOM.render(
			<>
				{ 0 < control.setting.get().length ? (
					<ItemGroup
						isSeparated
						isBordered
						size="small"
						style={ {
							backgroundColor: 'white',
							marginBottom: '8px',
						} }
					>
						{ control.setting.get().map( ( value ) => {
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
											control.handleRemove( value );
										} }
										onKeyUp={ ( e ) => {
											if ( 13 == e.which || 32 == e.which ) {
												control.handleRemove( value );
											}
										} }
									>✕</span>
								</Item>
							);
						} ) }
					</ItemGroup>
				) : '' }

				<SelectControl
					id={ '_customize-input-' + control.id }
					value=''
					options={ control.getOptions() }
					disabled={ control.getLimit() <= control.setting.get().length ? true : false }
					onChange={ ( value ) => {
						control.handleAddNew( value )
					} }
				/>
			</>,
			container
		);
	},

	getLimit: function() {
		const control = this;

		return control.params.itemsLimit || Object.keys( control.params.choices ).length;
	},

	getOptions: function() {
		const control = this;

		// Add "Add New" text as the first option with empty value;
		const options = [ {
			label: control.params.l10n.addNew,
			value: '',
			disabled: true,
		} ];

		// Convert object to array of object.
		Object.keys( control.params.choices ).forEach( ( key ) => {
			options.push( {
				label: control.params.choices[ key ],
				value: key,
				disabled: -1 !== control.setting.get().indexOf( key ) ? true : false,
			} );
		} );
		
		return options;
	},

	handleAddNew: function( value ) {
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

	handleRemove: function( removedValue ) {
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