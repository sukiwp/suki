import './index.scss';

import { Icon } from '@wordpress/components';

import { render } from '@wordpress/element';

import { __ } from '@wordpress/i18n';

const SukiDashboardProTeaser = () => {
	const data = sukiDashboardData.customizerShortcuts;

	return (
		<div className="suki-admin-dashboard__customizer-shortcuts suki-admin-dashboard__box">
			<h2 className="suki-admin-dashboard__heading">{ __( 'Start Customizing', 'suki' ) }</h2>

			<div
				className="suki-admin-dashboard__customizer-links"
				style={ { '--items': data.links.length } }
			>
				{ data.links.map( ( link ) => {
					return (
						<div
							key={ link.label }
							className="suki-admin-dashboard__customizer-link"
						>
							<a href={ link.url }>
								<Icon icon={ link.icon } />
								<span>{ link.label }</span>
							</a>
						</div>
					);
				} ) }
			</div>
		</div>
	);
};

window.addEventListener( 'DOMContentLoaded', () => {
	render(
		<SukiDashboardProTeaser />,
		document.getElementById( 'suki-admin-dashboard__customizer-shortcuts' )
	);
} );
