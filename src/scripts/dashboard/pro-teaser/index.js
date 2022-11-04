import './index.scss';

import {
	Button,
	CardBody,
	CardHeader,
	Card,
	Flex,
	Icon,
} from '@wordpress/components';

import { render } from '@wordpress/element';

import { __ } from '@wordpress/i18n';

const SukiDashboardProTeaser = () => {
	const data = sukiDashboardData.proTeaser;

	return (
		<Card className="suki-admin-dashboard__pro-teaser">
			<CardHeader>
				<div>
					<h2
						className="suki-admin-dashboard__heading"
						style={ { margin: 0 } }
					>
						{ __( 'Suki Pro', 'suki' ) }
					</h2>

					<p
						className="suki-admin-dashboard__subheading"
						style={ { margin: '5px 0 0' } }
					>
						{ __( 'Get more features, advanced demo templates, and premium support.', 'suki' ) }
					</p>
				</div>

				<Button
					text={ __( 'Upgrade to Suki Pro', 'suki' ) }
					variant="primary"
					href={ data.websiteURL }
					target="_blank"
					rel="noopener"
				/>
			</CardHeader>

			{ data.moduleCategories.map( ( category ) => {
				const modulesInThisCategory = data.modulesList.filter( ( module ) => {
					return module.category === category.slug;
				} );

				if ( 1 > modulesInThisCategory.length ) {
					return ( null );
				}

				return (
					<CardBody key={ category.slug }>
						<h3
							className="suki-admin-dashboard__pro-teaser-modules-category"
							style={ { marginTop: 0 } }
						>
							{ category.label }
						</h3>

						<div className="suki-admin-dashboard__pro-teaser-modules-grid">
							{ modulesInThisCategory.map( ( module ) => {
								return (
									<Flex
										key={ module.slug }
										justify="flex-start"
									>
										<Icon icon="lock" />
										<span>{ module.label }</span>
									</Flex>
								);
							} ) }
						</div>
					</CardBody>
				);
			} ) }
		</Card>
	);
};

window.addEventListener( 'DOMContentLoaded', () => {
	const root = document.getElementById( 'suki-admin-dashboard__pro-teaser' );

	if ( root ) {
		render(
			<SukiDashboardProTeaser />,
			root
		);
	}
} );
