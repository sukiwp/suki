import { registerPlugin } from '@wordpress/plugins';
import SukiPageSettingsSidebar from './SukiPageSettingsSidebar';

registerPlugin(
	'suki-page-settings',
	{
		icon: 'admin-settings',
		render: SukiPageSettingsSidebar,
	}
);