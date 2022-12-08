
import { ReactSortable } from 'react-sortablejs';

import {
	Button,
	Icon,
} from '@wordpress/components';

import { useState } from '@wordpress/element';

import { __ } from '@wordpress/i18n';

const SukiBuilder = ( { control } ) => {
	// Create a list of choice IDs.
	const choiceIds = control.params.choices.map( ( choice ) => {
		return choice.value;
	} );

	// Create a mapping of all elements, including the inactive elements.
	const initMapping = () => {
		const mapping = {};
		const activeItemIds = [];

		// Iterate through each setting, select the active items, and add them to the return array.
		Object.keys( control.settings ).forEach( ( settingId ) => {
			// Get active elements in this area.
			// Make sure the active elements are valid choices.
			// For example: if WooCommerce is disabled, the `cart-dropdown` value is no longer valid.
			const settingValue = control.settings[ settingId ].get().filter( ( itemId ) => {
				return choiceIds.includes( itemId );
			} );

			// Add this area and its value to mapping.
			mapping[ settingId ] = settingValue;

			// Add active elements in this area to the activeItemIds list.
			activeItemIds.push( ...settingValue );
		} );

		// Filter inactive elements and add them to the `inactive` area.
		mapping._inactive = choiceIds.filter( ( choiceId ) => {
			return ! activeItemIds.includes( choiceId );
		} );

		return mapping;
	};

	// State for all settings values and inactive elements.
	const [ mapping, setMapping ] = useState( initMapping() );

	const structures = {
		vertical: control.params.areas.filter( ( area ) => {
			return 'vertical' === area.location;
		} ),
		horizontal: control.params.areas.filter( ( area ) => {
			return 'horizontal' === area.location;
		} ),
		inactive: [ {
			id: '_inactive',
			label: __( 'Inactive elements', 'suki' ),
			sortableInstance: null,
			location: 'inactive',
		} ],
	};

	const areas = [ ...structures.vertical, ...structures.horizontal, ...structures.inactive ];

	return (
		<div className="suki-builder">
			{ Object.keys( structures ).map( ( location ) => {
				if ( 1 > structures[ location ].length ) {
					return null;
				}

				return (
					<div
						key={ location }
						className={ 'suki-builder__location-' + location }
					>
						{ structures[ location ].map( ( area ) => {
							const items = mapping[ area.id ].map( ( itemId ) => {
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
										list={ items }

										// Handler to update sortable values.
										setList={ ( updatedItems ) => {
											// Parse array of IDs from the updated sortable items.
											const updatedItemIds = updatedItems.map( ( item ) => {
												return item.value;
											} );

											// Update state.
											setMapping( ( prevMapping ) => {
												return {
													...prevMapping,
													[ area.id ]: updatedItemIds,
												};
											} );

											// Update setting values for areas, except the `_inactive` area.
											if ( '_inactive' !== area.id ) {
												// Only update setting value if the array value changed.
												if ( updatedItemIds.toString() !== control.settings[ area.id ].get().toString() ) {
													control.settings[ area.id ].set( updatedItemIds );
												}
											}
										} }

										// When start dragging a sortable item, disable the unsupported areas.
										onStart={ ( e ) => {
											const itemId = e.item.dataset.value;

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
										{ items.map( ( item ) => {
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
																const updatedItemIds = mapping[ area.id ].filter( ( itemId ) => {
																	return itemId !== item.value;
																} );

																setMapping( ( prevMapping ) => {
																	const newMapping = {
																		...prevMapping,
																		[ area.id ]: updatedItemIds,
																		_inactive: [ ...prevMapping._inactive, item.value ],
																	};

																	return newMapping;
																} );

																// Only update setting value if the array value changed.
																if ( updatedItemIds.toString() !== control.settings[ area.id ].get().toString() ) {
																	control.settings[ area.id ].set( updatedItemIds );
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
			} ) }
		</div>
	);
};

export default SukiBuilder;
