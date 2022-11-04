import './index.scss';

import {
	CardBody,
	Card,
	Icon,
} from '@wordpress/components';

import { render } from '@wordpress/element';

import { __ } from '@wordpress/i18n';

const SukiDashboardProTeaser = () => {
	const data = sukiDashboardData.customizerShortcuts;

	return (
		<Card className="suki-admin-dashboard__customizer-shortcuts">
			<CardBody>
				<h2
					className="suki-admin-dashboard__heading"
					style={ { marginTop: 0 } }
				>
					{ __( 'Start Customizing', 'suki' ) }
				</h2>
				<div className="suki-admin-dashboard__customizer-links">
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
			</CardBody>
		</Card>
	);
};

window.addEventListener( 'DOMContentLoaded', () => {
	const root = document.getElementById( 'suki-admin-dashboard__customizer-shortcuts' );

	if ( root ) {
		render(
			<SukiDashboardProTeaser />,
			root
		);
	}
} );
