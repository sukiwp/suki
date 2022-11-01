import './index.scss';

import { Button } from '@wordpress/components';

import { render } from '@wordpress/element';

import { __ } from '@wordpress/i18n';

const SukiDashboardProTeaser = () => {
	const data = sukiDashboardData.proTeaser;

	return (
		<div className="suki-admin-dashboard__pro-teaser suki-admin-dashboard__box">
			<h2
				className="suki-admin-dashboard__heading"
				style={ { margin: 0 } }
			>
				{ __( 'Suki Pro', 'suki' ) }
			</h2>
			<p
				className="suki-admin-dashboard__subheading"
				style={ { marginTop: '5px' } }
			>
				{ __( 'Get more features, advanced demo templates, and premium support.', 'suki' ) }
			</p>
			<hr className="suki-admin-dashboard__box-separator" />

			<ul
				className="suki-admin-dashboard__pro-teaser-modules-grid"
				style={ { '--items': data.modules.length } }
			>
				{ data.modules.map( ( module ) => {
					return (
						<li key={ module.slug }>{ module.label }</li>
					);
				} ) }
			</ul>

			<p className="suki-admin-dashboard__pro-teaser-action">
				<Button
					text={ __( 'Upgrade to Suki Pro', 'suki' ) }
					variant="primary"
					href={ data.websiteURL }
				/>
			</p>
		</div>
	);
};

window.addEventListener( 'DOMContentLoaded', () => {
	render(
		<SukiDashboardProTeaser />,
		document.getElementById( 'suki-admin-dashboard__pro-teaser' )
	);
} );
