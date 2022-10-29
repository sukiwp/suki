import {
	Button,
	ButtonGroup,
} from '@wordpress/components';

const SukiControlResponsiveSwitcher = ( { devices } ) => {
	// Make sure the specified `devices` prop valid and always in `[desktop] [tablet] [mobile]` orders.
	const deviceOptions = [ 'desktop', 'tablet', 'mobile' ].filter( ( device ) => {
		return -1 !== devices.indexOf( device );
	} );

	return (
		<>
			{ 1 < deviceOptions.length &&
				<ButtonGroup className="suki-responsive-switcher">
					{ deviceOptions.map( ( device ) => {
						return (
							<Button
								key={ device }
								isSmall
								variant="tertiary"
								icon={ 'mobile' === device ? 'smartphone' : device }
								data-device={ device }
								label={ sukiCustomizerData.l10n.device }
								showTooltip
								className="suki-responsive-switcher__button"
								onClick={ () => {
									wp.customize.previewedDevice.set( device );
								} }
							/>
						);
					} ) }
				</ButtonGroup>
			}
		</>
	);
};

export default SukiControlResponsiveSwitcher;
