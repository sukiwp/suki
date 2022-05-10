/**
 * Multi Select control (React)
 */

import SukiControlLabel from '../components/SukiControlLabel';
import SukiControlDescription from '../components/SukiControlDescription';
 
import {
	__experimentalHStack as HStack,
	__experimentalSpacer as Spacer,
	__experimentalVStack as VStack,
	Button,
	Icon,
} from '@wordpress/components';

import {
	DndContext, 
	closestCenter,
	KeyboardSensor,
	PointerSensor,
	useSensor,
	useSensors,
} from '@dnd-kit/core';

import {
	arrayMove,
	SortableContext,
	sortableKeyboardCoordinates,
	verticalListSortingStrategy,
	useSortable
} from '@dnd-kit/sortable';

import {
	restrictToVerticalAxis,
	restrictToParentElement
} from '@dnd-kit/modifiers';

import {
	CSS,
} from '@dnd-kit/utilities';

function SukiMultiSelectList( props ) {
	const { control } = props;
	
	const values = control.setting.get();

	if ( 1 > values.length ) {
		return null;
	}

	return (
		<VStack
			spacing="1"
			className="suki-multiselect__list"
		>
			<SukiMultiSelectConditionalWrapper
				values={ values }
				sortable={ control.params.sortable }
				handleUpdateValues={ ( items ) => {
					control.setting.set( items );
				} }
			>
				{ values.map( ( value ) => {
					const valueInfo = control.params.choices.find( ( choice ) => {
						return value === choice.value;
					} );

					return (
						<SukiMultiSelectItem
							key={ value }
							value={ value }
							label={ valueInfo.label }
							sortable={ control.params.sortable }
							handleRemoveItem={ ( removedValue ) => {
								let newValues = values || [];

								// Remove the clicked item from the value array.
								newValues = newValues.filter( ( value ) => {
									return value !== removedValue;
								} )

								control.setting.set( newValues );
							} }
						/>
					);
				} ) }
			</SukiMultiSelectConditionalWrapper>
		</VStack>
	);
}

function SukiMultiSelectConditionalWrapper( props ) {
	const sensors = useSensors(
		useSensor( PointerSensor ),
		useSensor( KeyboardSensor, {
			coordinateGetter: sortableKeyboardCoordinates,
		} )
	);

	if ( props.sortable ) {
		return (
			<DndContext
				sensors={ sensors }
				collisionDetection={ closestCenter }
				modifiers={ [ restrictToVerticalAxis, restrictToParentElement ] }
				onDragEnd={ ( e ) => {
					if ( e.active.id !== e.over.id ) {
						let items = props.values;
			
						const oldIndex = items.indexOf( e.active.id );
						const newIndex = items.indexOf( e.over.id );
			
						items = arrayMove( items, oldIndex, newIndex );
			
						props.handleUpdateValues( items );
					}
				} }
			>
				<SortableContext
					items={ props.values }
					strategy={ verticalListSortingStrategy }
				>
					{ props.children }
				</SortableContext>
			</DndContext>
		);
	}

	return props.children;
}

function SukiMultiSelectItem( props ) {
	const {
		attributes,
		listeners,
		setNodeRef,
		transform,
		transition,
	} = useSortable( { id: props.value } );

	const itemStyle = {
		transform: CSS.Transform.toString( transform ),
		transition,
	};

	const itemAttributes = props.sortable ? attributes : undefined;

	return (
		<div
			ref={ setNodeRef }
			style={ itemStyle }
			{ ...itemAttributes }
			size="xSmall"
			data-value={ props.value }
			className="suki-multiselect__list__item"
		>
			<HStack
				expanded
				spacing="2"
			>
				{ props.sortable &&
					<Icon
						icon="move"
						{ ...listeners }
						className="suki-multiselect__list__item__move"
					/>
				}
				<Spacer>{ props.label }</Spacer>
				<Button
					isSmall
					icon="no-alt"
					label={ SukiCustomizerData.l10n.remove }
					showTooltip
					className="suki-multiselect__list__item__remove"
					onClick={ () => {
						props.handleRemoveItem( props.value );
					} }
				/>
			</HStack>
		</div>
	);
}

wp.customize.SukiMultiSelectControl = wp.customize.SukiReactControl.extend( {
	renderContent: function() {
		const control = this;

		const values = control.setting.get();

		// If limit is set to `0`, it means limit is same as the number of options.
		const limit = control.params.itemsLimit || control.params.choices.length;

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

				<VStack
					spacing="1"
				>
					<SukiMultiSelectList
						control={ control }
					/>

					<select
						value=""
						id={ '_customize-input-' + control.id }
						hidden={ limit <= values.length }
						onChange={ ( e ) => {
							const addedValue = e.target.value;

							let newValues = values || [];

							// Add the selected item into the value array.
							if ( -1 === newValues.indexOf( addedValue ) ) {
								newValues = [ ...newValues, addedValue ];
							}

							// If sortable mode is deisabled, sort the array according to the original options order.
							if ( ! control.params.sortable ) {
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
							{ SukiCustomizerData.l10n.addNew }
						</option>

						{ control.params.choices.map( ( choice, i ) => {
							return (
								<option
									key={ choice.value }
									value={ choice.value }
									disabled={ -1 === values.indexOf( choice.value ) ? false : true }
								>
									{ choice.label }
								</option>
							)
						} ) }
					</select>
				</VStack>
			</>,
			control.container[0]
		);
	},
} );

wp.customize.controlConstructor['suki-multiselect'] = wp.customize.SukiMultiSelectControl;