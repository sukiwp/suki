import { Component } from '@wordpress/element';
import { Panel, PanelBody, PanelRow, SelectControl, ToggleControl } from '@wordpress/components';
import { useSelect, useDispatch, select } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

class SukiPageSettings extends Component {
	render() {
		const values = select( 'core/editor' ).getEditedPostAttribute( 'meta' )[ SukiPageSettingsData.metaKey ];

		return (
			<>
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
								} }
								>
									{ panel.fields.map( ( field ) => {
										if ( 'select' === field.type ) {
											return (
												<SelectControl
												key={ field.key }
												label={ field.label }
												value=''
												options={ field.options }
												/>
											);
										}
									} ) }
								</div>
							</PanelBody>
						</Panel>
					);
				} ) }
			</>
		);
	}
}

export default SukiPageSettings;