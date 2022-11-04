import './index.scss';

import apiFetch from '@wordpress/api-fetch';

import {
	Button,
	CardBody,
	CardMedia,
	Card,
} from '@wordpress/components';

import {
	render,
	useState,
} from '@wordpress/element';

import { __ } from '@wordpress/i18n';

const SukiDashboardSitesImport = () => {
	const [ isPluginInstalling, setPluginInstalling ] = useState( false );
	const [ isPluginInstalled, setPluginInstalled ] = useState( sukiDashboardData.sitesImport.isPluginInstalled );

	const pluginSlug = 'suki-sites-import';
	const pluginFilePath = pluginSlug + '/' + pluginSlug;

	const handleInstallPlugin = async () => {
		setPluginInstalling( true );

		// Install plugin.
		await apiFetch( {
			method: 'POST',
			path: '/wp/v2/plugins/',
			data: { slug: pluginSlug },
		} ).catch( () => {} );

		// Activate plugin.
		await apiFetch( {
			method: 'POST',
			path: '/wp/v2/plugins/' + pluginFilePath,
			data: { status: 'active' },
		} ).catch( () => {} );

		setPluginInstalling( false );
		setPluginInstalled( true );
	};

	return (
		<Card className="suki-admin-dashboard__sites-import">
			<CardMedia className="suki-admin-dashboard__sites-import-banner">
				<img
					src={ sukiDashboardData.sitesImport.bannerImageURL }
					width="400"
					height="240"
					alt=""
				/>
			</CardMedia>

			<CardBody className="suki-admin-dashboard__sites-import-text">
				<h2
					className="suki-admin-dashboard__heading"
					style={ { margin: 0 } }
				>
					{ __( 'Demo Sites Import', 'suki' ) }
				</h2>

				<p>{ __( 'Kickstart your website with our pre-made demo websites: Import. Modify. Launch!', 'suki' ) }</p>

				<p style={ { marginBottom: 0 } }>
					{ isPluginInstalled &&
						<Button
							text={ __( 'Browse Demo Sites', 'suki' ) }
							variant="primary"
							href={ sukiDashboardData.sitesImport.pluginPageURL }
						/>
					}

					{ ! isPluginInstalled &&
						<Button
							text={ isPluginInstalling ? __( 'Installing & Activating Plugin', 'suki' ) : __( 'Install & Activate Plugin', 'suki' ) }
							variant="primary"
							isBusy={ isPluginInstalling }
							onClick={ handleInstallPlugin }
						/>
					}
				</p>
			</CardBody>
		</Card>
	);
};

window.addEventListener( 'DOMContentLoaded', () => {
	const root = document.getElementById( 'suki-admin-dashboard__sites-import' );

	if ( root ) {
		render(
			<SukiDashboardSitesImport />,
			root
		);
	}
} );
