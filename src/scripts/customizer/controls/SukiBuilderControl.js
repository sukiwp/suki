/**
 * Builder control (React)
 */

import SukiControlLabel from '../components/SukiControlLabel';
import SukiControlDescription from '../components/SukiControlDescription';

import { ReactSortable } from 'react-sortablejs';

import {
	useState,
	render,
} from '@wordpress/element';

import {
	Button,
	Icon,
} from '@wordpress/components';

const SukiBuilder = ( { control } ) => {
	// Get all settings values, and also define inactive elements.
	const getValues = () => {
		const values = {};
		let activeItemIds = [];
		let inactiveItemIds = [];

		// Iterate through each setting, select the active items, and add them to the return array.
		Object.keys( control.settings ).forEach( ( settingId ) => {
			const settingValue = control.settings[ settingId ].get();

			values[ settingId ] = settingValue;

			activeItemIds = [ ...activeItemIds, ...settingValue ];
		} );

		// Add inactive items into the return array.
		control.params.choices.forEach( ( choice ) => {
			if ( -1 === activeItemIds.indexOf( choice.value ) ) {
				inactiveItemIds = [ ...inactiveItemIds, choice.value ];
			}
		} );

		values._inactive = inactiveItemIds;

		return values;
	};

	// State for all settings values and inactive elements.
	const [ values, setValues ] = useState( getValues() );

	// Sortable areas and their info.
	const areas = [ ...control.params.areas, {
		id: '_inactive',
		label: sukiCustomizerData.l10n.inactiveElements,
		sortableInstance: null,
	} ];

	return (
		<div className="suki-builder">
			{ areas.map( ( area ) => {
				// Array of item objects of current sortable area.
				const areaItems = values[ area.id ].map( ( itemId ) => {
					return control.params.choices.find( ( choice ) => {
						return itemId === choice.value;
					} );
				} );

				return (
					<div
						key={ area.id }
						data-area={ area.id }
						className="suki-builder__area"
					>
						<span className="suki-builder__area__label">{ area.label }</span>

						<ReactSortable
							// Store the sortable instance to `areas` variable.
							ref={ ( node ) => {
								if ( node ) {
									area.sortableInstance = node.sortable;
								}
							} }

							// Connect with other sortable areas.
							group={ control.id }

							// Sortable values.
							list={ areaItems }

							// Handler to update sortable values.
							setList={ ( updatedAreaItems ) => {
								// Parse array of IDs from the updated sortable items.
								const updatedAreaItemsIds = updatedAreaItems.map( ( item ) => {
									return item.value;
								} );

								// Update values state.
								setValues( ( prevValues ) => {
									return {
										...prevValues,
										[ area.id ]: updatedAreaItemsIds,
									};
								} );

								// Update setting values for areas, except the `_inactive` area.
								if ( '_inactive' !== area.id ) {
									if ( updatedAreaItemsIds !== control.settings[ area.id ].get() ) {
										control.settings[ area.id ].set( updatedAreaItemsIds );
									}
								}
							} }

							// When start dragging a sortable item, disable the unsupported areas.
							onStart={ ( e ) => {
								const itemId = e.item.getAttribute( 'data-value' );

								const itemObj = control.params.choices.find( ( choice ) => {
									return itemId === choice.value;
								} );

								itemObj.unsupported_areas.forEach( ( areaId ) => {
									const unsupportedArea = areas.find( ( a ) => {
										return areaId === a.id;
									} );

									unsupportedArea.sortableInstance.option( 'disabled', true );
									unsupportedArea.sortableInstance.el.parentElement.classList.add( 'disabled' );
								} );
							} }

							// When dropping a sortable item, restore all areas.
							onEnd={ () => {
								areas.forEach( ( a ) => {
									a.sortableInstance.option( 'disabled', false );
									a.sortableInstance.el.parentElement.classList.remove( 'disabled' );
								} );
							} }
							className="suki-builder__area__sortable"
						>
							{ areaItems.map( ( item ) => {
								return (
									<span
										key={ item.value }
										data-value={ item.value }
										className="suki-builder__item"
									>
										{ item.icon &&
											<Icon icon={ item.icon } />
										}

										{ item.label &&
											<span>{ item.label }</span>
										}

										{ '_inactive' !== area.id &&
											<Button
												icon="no-alt"
												className="suki-builder__item__remove"
												onClick={ () => {
													const updatedAreaItemsIds = values[ area.id ].filter( ( id ) => {
														return id !== item.value;
													} );

													setValues( ( prevValues ) => {
														return {
															...prevValues,
															[ area.id ]: updatedAreaItemsIds,
															_inactive: [ ...prevValues._inactive, item.value ],
														};
													} );

													if ( updatedAreaItemsIds !== control.settings[ area.id ].get() ) {
														control.settings[ area.id ].set( updatedAreaItemsIds );
													}
												} }
											/>
										}
									</span>
								);
							} ) }
						</ReactSortable>
					</div>
				);
			} ) }
		</div>
	);
};

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
