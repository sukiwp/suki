/**
 * Multi Select control (React)
 */

import SukiControlLabel from '../components/SukiControlLabel';
import SukiControlDescription from '../components/SukiControlDescription';

import { ReactSortable } from 'react-sortablejs';

import {
	Button,
	Icon,
} from '@wordpress/components';

import { render } from '@wordpress/element';

import { __ } from '@wordpress/i18n';

function SukiMultiSelect( { control } ) {
	const values = control.setting.get();

	const valuesObj = values.map( ( value ) => {
		return control.params.choices.find( ( choice ) => {
			return value === choice.value;
		} );
	} );

	// If limit is set to `0`, it means limit is same as the number of options.
	const limit = control.params.itemsLimit || control.params.choices.length;

	return (
		<ReactSortable
			draggable=".suki-multiselect__list__item"
			handle=".suki-multiselect__list__item__move"
			list={ valuesObj }
			setList={ ( updatedValuesObj ) => {
				const updatedValues = updatedValuesObj.map( ( valueObj ) => {
					return valueObj.value;
				} );

				control.setting.set( updatedValues );
			} }
			className="suki-multiselect__list"
		>
			{ valuesObj.map( ( valueObj ) => {
				return (
					<span
						key={ valueObj.value }
						className="suki-multiselect__list__item"
					>
						{ control.params.isSortable &&
							<Icon
								icon="move"
								className="suki-multiselect__list__item__move"
							/>
						}
						<span className="suki-multiselect__list__item__label">{ valueObj.label }</span>
						<Button
							isSmall
							icon="no-alt"
							label={ __( 'Remove', 'suki' ) }
							showTooltip
							className="suki-multiselect__list__item__remove"
							onClick={ () => {
								let newValues = values || [];

								// Remove the clicked item from the value array.
								newValues = newValues.filter( ( value ) => {
									return value !== valueObj.value;
								} );

								control.setting.set( newValues );
							} }
						/>
					</span>
				);
			} ) }

			<select
				value=""
				id={ '_customize-input-' + control.id }
				hidden={ limit <= values.length }
				onChange={ ( e ) => {
					if ( limit <= values.length ) {
						return;
					}

					const addedValue = e.target.value;

					let newValues = values || [];

					// Add the selected item into the value array.
					if ( -1 === newValues.indexOf( addedValue ) ) {
						newValues = [ ...newValues, addedValue ];
					}

					// If sortable mode is deisabled, sort the array according to the original options order.
					if ( ! control.params.isSortable ) {
						const choicesValues = control.params.choices.map( ( item ) => {
							return item.value;
						} );

						newValues = choicesValues.filter( ( choice ) => {
							return -1 !== newValues.indexOf( choice );
						} );
					}

					control.setting.set( newValues );
				} }
			>
				<option
					value=""
					disabled
				>
					{ __( 'Add new', 'suki' ) }
				</option>

				{ control.params.choices.map( ( choice ) => {
					return (
						<option
							key={ choice.value }
							value={ choice.value }
							disabled={ -1 === values.indexOf( choice.value ) ? false : true }
						>
							{ choice.label }
						</option>
					);
				} ) }
			</select>
		</ReactSortable>
	);
}

wp.customize.SukiMultiSelectControl = wp.customize.SukiReactControl.extend( {
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

				<SukiMultiSelect control={ control } />
			</>,
			control.container[ 0 ]
		);
	},
} );

wp.customize.controlConstructor[ 'suki-multiselect' ] = wp.customize.SukiMultiSelectControl;
