import {
	__experimentalHStack as HStack,
	Button,
	ButtonGroup,
} from '@wordpress/components';

function SukiControlResponsiveSwitcher( { devices } ) {
	const controlDevices = [ 'desktop', 'tablet', 'mobile' ].filter( ( device ) => {
		return -1 !== devices.indexOf( device );
	} );

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
								label={ SukiCustomizerData.l10n.device }
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