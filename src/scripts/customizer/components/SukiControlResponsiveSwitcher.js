import {
	__experimentalHStack as HStack,
	Button,
	ButtonGroup,
} from '@wordpress/components';

import { __ } from '@wordpress/i18n';

function SukiControlResponsiveSwitcher( props ) {
	const controlDevices = [ 'desktop', 'tablet', 'mobile' ].filter( ( device ) => {
		return -1 !== props.devices.indexOf( device );
	} );

	const labels = {
		dekstop: __( 'Desktop', 'suki' ),
		tablet: __( 'Tablet', 'suki' ),
		mobile: __( 'Mobile', 'suki' ),
	};

	return (
		<>
			{ 1 < controlDevices.length &&
				<ButtonGroup className="suki-responsive-switcher">
					{ controlDevices.map( ( device ) => {
						return (
							<Button
								key={ device }
								isSmall
								variant="tertiary"
								icon={ 'mobile' === device ? 'smartphone' : device }
								data-device={ device }
								label={ labels.device }
								showTooltip
								className="suki-responsive-switcher__button"
								onClick={ ( e ) => {
									wp.customize.previewedDevice.set( device );
								} }
							/>
						);
					} ) }
				</ButtonGroup>
			}
		</>
	);
}

export default SukiControlResponsiveSwitcher;