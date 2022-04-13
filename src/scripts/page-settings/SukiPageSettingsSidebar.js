import { PluginSidebar, PluginSidebarMoreMenuItem } from '@wordpress/edit-post';
import { Fragment, Component } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { addFilter } from '@wordpress/hooks';
import SukiPageSettings from './SukiPageSettings';

class SukiPageSettingsSidebar extends Component {
	render() {
		return (
			<Fragment>
				<PluginSidebar name='suki-page-settings' title={ __( 'Theme Page Settings', 'suki' ) }>
					<SukiPageSettings />
				</PluginSidebar>
				<PluginSidebarMoreMenuItem target='suki-page-settings'>
					{ __( 'Theme Page Settings', 'suki' ) }
				</PluginSidebarMoreMenuItem>
			</Fragment>
		);
	}
}

export default SukiPageSettingsSidebar;