import { registerPlugin } from '@wordpress/plugins';

import {
	PluginSidebar,
	PluginSidebarMoreMenuItem
} from '@wordpress/edit-post';

import {
	__experimentalVStack as VStack,
	Panel,
	PanelBody,
	SelectControl
} from '@wordpress/components';

import {
	useSelect, 
	useDispatch
} from '@wordpress/data';

function runFieldOutputs( key, rules, value, inheritValue ) {
	const actualValue = '' !== value ? value : inheritValue;

	rules.forEach( ( rule ) => {
		if ( undefined == rule.element ) {
			return;
		}
		
		rule.pattern = rule.pattern || '$';

		switch ( rule.type ) {
			case 'class':
			default:
				const regex = new RegExp( rule['pattern'].replace( '$', '[\\w\\-]+' ), 'i' );

				const formattedValue = rule['pattern'].replace( '$', actualValue );

				document.querySelectorAll( rule.element ).forEach( ( element ) => {
					if ( element.className.match( regex ) ) {
						element.className = element.className.replace( regex, formattedValue );
					} else {
						element.className += ' ' + formattedValue;
					}
				} );
				break;
		}
	} );
}

function SukiPageSettingsSidebar() {
	const metaValue = useSelect( ( select ) => {
		return select( 'core/editor' ).getEditedPostAttribute( 'meta' )[ SukiPageSettingsData.metaKey ];
	}, [] );

	const editPost = useDispatch( 'core/editor' ).editPost;

	const getFieldValue = ( key, defaultValue = '' ) => {
		// If the specified key exists in the values array, return it. Otherwise, return the defaultValue.
		return undefined !== metaValue && undefined !== metaValue[ key ] ? metaValue[ key ] : defaultValue;
	}

	const setFieldValue = ( key, value ) => {
		// Combine the meta value.
		const newValue = {
			...metaValue,
			[ key ]: value
		}

		// Ignore '' value because it's "inherit".
		if ( '' === value ) {
			delete newValue[ key ];
		}

		// Update the changes in the data store.
		editPost( {
			meta: {
				[ SukiPageSettingsData.metaKey ]: newValue
			}
		} );
	}

	return (
		<>
			<PluginSidebar name={ SukiPageSettingsData.metaKey } title={ SukiPageSettingsData.title }>
				{ SukiPageSettingsData.structures.map( ( panel, i ) => {
					return (
						<Panel key={ panel.key }>
							<PanelBody
								title={ panel.title }
								initialOpen={ 0 == i ? true : false }
							>
								<VStack
									spacing="2"
								>
									{ panel.fields.map( ( field ) => {
										const value = getFieldValue( field.key );

										if ( field.outputs ) {
											runFieldOutputs( field.key, field.outputs, value, field.inherit_value );
										}

										if ( 'select' === field.type ) {
											return (
												<SelectControl
													key={ field.key }
													label={ field.label }
													value={ value }
													options={ field.options }
													help={ field.description }
													onChange={ ( value ) => {
														setFieldValue( field.key, value );

														if ( field.outputs ) {
															runFieldOutputs( field.key, field.outputs, value, field.inherit_value );
														}
													} }
												/>
											);
										}
									} ) }
								</VStack>
							</PanelBody>
						</Panel>
					);
				} )}
			</PluginSidebar>
			<PluginSidebarMoreMenuItem target={ SukiPageSettingsData.metaKey }>
				{ SukiPageSettingsData.title }
			</PluginSidebarMoreMenuItem>
		</>
	);
}

registerPlugin(
	SukiPageSettingsData.metaKey.replaceAll( '_', '-' ),
	{
		icon: 'admin-settings',
		render: SukiPageSettingsSidebar,
	}
);