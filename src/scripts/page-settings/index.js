import './index.scss';

import {
	withFilters,
	Button,
	Panel,
	PanelBody,
	PanelRow,
	SelectControl,
	Slot,
} from '@wordpress/components';

import {
	useSelect,
	useDispatch,
} from '@wordpress/data';

import {
	PluginSidebar,
	PluginSidebarMoreMenuItem,
} from '@wordpress/edit-post';

import { __ } from '@wordpress/i18n';

import { registerPlugin } from '@wordpress/plugins';

const runFieldOutputs = ( key, rules, value, inheritValue ) => {
	const actualValue = '' !== value ? value : inheritValue;

	rules.forEach( ( rule ) => {
		if ( undefined === rule.element ) {
			return;
		}

		rule.pattern = rule.pattern || '$';

		switch ( rule.type ) {
			case 'class':
			default:
				const regex = new RegExp( rule.pattern.replace( '$', '[\\w\\-]+' ), 'i' );

				const formattedValue = rule.pattern.replace( '$', actualValue );

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
};

const SukiPageSettingsSidebarSlotFillFilterableComponent = withFilters( 'suki.pageSettingsAdditionalContentsBottom' )( () => <></> );

const SukiPageSettingsSidebar = () => {
	const metaValue = useSelect( ( select ) => {
		return select( 'core/editor' ).getEditedPostAttribute( 'meta' )[ sukiPageSettingsData.metaKey ];
	}, [] );

	const editPost = useDispatch( 'core/editor' ).editPost;

	const getFieldValue = ( key, defaultValue = '' ) => {
		// If the specified key exists in the values array, return it. Otherwise, return the defaultValue.
		return undefined !== metaValue && undefined !== metaValue[ key ] ? metaValue[ key ] : defaultValue;
	};

	const setFieldValue = ( key, value ) => {
		// Combine the meta value.
		const newValue = {
			...metaValue,
			[ key ]: value,
		};

		// Ignore '' value because it's "inherit".
		if ( '' === value ) {
			delete newValue[ key ];
		}

		// Update the changes in the data store.
		editPost( {
			meta: {
				[ sukiPageSettingsData.metaKey ]: newValue,
			},
		} );
	};

	return (
		<>
			<PluginSidebar
				name={ sukiPageSettingsData.metaKey }
				title={ __( 'Page Settings (Theme)', 'suki' ) }
			>

				{ sukiPageSettingsData.structures.map( ( panel ) => {
					return (
						<Panel key={ panel.key }>
							<PanelBody
								title={ panel.title }
								initialOpen={ false }
							>
								{ panel.fields.map( ( field ) => {
									const value = getFieldValue( field.key );

									if ( field.outputs ) {
										runFieldOutputs( field.key, field.outputs, value, field.inherit_value );
									}

									return (
										<PanelRow
											key={ field.key }
											className="suki-page-settings__row"
										>

											{ 'select' === field.type &&
												<SelectControl
													key={ field.key }
													label={ field.label }
													value={ value }
													options={ field.options }
													help={ field.description }
													onChange={ ( newValue ) => {
														setFieldValue( field.key, newValue );

														if ( field.outputs ) {
															runFieldOutputs( field.key, field.outputs, newValue, field.inherit_value );
														}
													} }
													__nextHasNoMarginBottom
												/>
											}

										</PanelRow>
									);
								} ) }
							</PanelBody>
						</Panel>
					);
				} ) }

				{ sukiPageSettingsData.showProTeaser &&
					<Panel>
						<PanelBody
							title={ __( 'More options in Suki Pro', 'suki' ) }
							initialOpen={ false }
						>
							<ul
								style={ {
									margin: '1em 0',
									listStyle: 'disc',
									paddingLeft: '1em',
								} }
							>
								<li>{ __( 'Transparent header', 'suki' ) }</li>
								<li>{ __( 'Sticky header', 'suki' ) }</li>
								<li>{ __( 'Alternate header colors', 'suki' ) }</li>
								<li>{ __( 'Sticky sidebar', 'suki' ) }</li>
								<li>{ __( 'Preloader screen', 'suki' ) }</li>
								<li>{ __( 'Insert custom content into any template hooks (header, footer, before content, etc.).', 'suki' ) }</li>
							</ul>

							<p>
								<Button
									variant="secondary"
									text={ __( 'Learn More', 'suki' ) }
									href={ sukiPageSettingsData.proTeaserUrl }
									target="_blank"
									rel="noopener"
								/>
							</p>
						</PanelBody>
					</Panel>
				}

				<Slot name="SukiPageSettingsAdditionalContentsBottom" />

				<SukiPageSettingsSidebarSlotFillFilterableComponent />

			</PluginSidebar>

			<PluginSidebarMoreMenuItem target={ sukiPageSettingsData.metaKey }>
				{ sukiPageSettingsData.title }
			</PluginSidebarMoreMenuItem>
		</>
	);
};

registerPlugin(
	sukiPageSettingsData.metaKey.replaceAll( '_', '-' ),
	{
		icon: 'admin-settings',
		render: SukiPageSettingsSidebar,
	}
);
