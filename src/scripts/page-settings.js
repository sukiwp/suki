import { registerPlugin } from '@wordpress/plugins';
import { PluginSidebar, PluginSidebarMoreMenuItem } from '@wordpress/edit-post';
import { Panel, PanelBody, SelectControl } from '@wordpress/components';
import { useSelect, useDispatch } from '@wordpress/data';

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
								<div
									style={ {
										display: 'flex',
										flexDirection: 'column',
										gap: '4px',
										marginTop: '8px',
									} }
								>
									{ panel.fields.map( ( field ) => {
										if ( 'select' === field.type ) {
											return (
												<SelectControl
													key={ field.key }
													label={ field.label }
													value={ getFieldValue( field.key ) }
													options={ field.options }
													onChange={ ( value ) => {
														setFieldValue( field.key, value );
													} }
												/>
											);
										}
									} ) }
								</div>
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