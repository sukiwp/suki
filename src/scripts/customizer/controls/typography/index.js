import './index.scss';

import SukiControlLabel from '../../components/control-label';
import SukiControlDescription from '../../components/control-description';
import SukiControlResponsiveSwitcher from '../../components/control-responsive-switcher';
import SukiControlResponsiveContainer from '../../components/control-responsive-container';

import {
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalGrid as Grid,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalUnitControl as UnitControl,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalParseQuantityAndUnitFromRawValue as parseQuantityAndUnitFromRawValue,
	CardBody,
	Card,
	Flex,
	SelectControl,
} from '@wordpress/components';

import { createRoot } from '@wordpress/element';

import { __ } from '@wordpress/i18n';

wp.customize.SukiTypographyControl = wp.customize.SukiReactControl.extend( {
	renderContent() {
		const control = this;

		const fontWeightOptions = [
			{ value: '', label: '' },
			{ value: 100, label: __( 'Thin', 'suki' ) },
			{ value: 200, label: __( 'Extra Light', 'suki' ) },
			{ value: 300, label: __( 'Light', 'suki' ) },
			{ value: 400, label: __( 'Regular', 'suki' ) },
			{ value: 500, label: __( 'Medium', 'suki' ) },
			{ value: 600, label: __( 'Semi Bold', 'suki' ) },
			{ value: 700, label: __( 'Bold', 'suki' ) },
			{ value: 800, label: __( 'Extra Bold', 'suki' ) },
			{ value: 900, label: __( 'Black' ) },
		];

		const fontStyleOptions = [
			{ value: '', label: '' },
			{ value: 'normal', label: __( 'Normal', 'suki' ) },
			{ value: 'italic', label: __( 'Italic', 'suki' ) },
		];

		const textTransformOptions = [
			{ value: '', label: '' },
			{ value: 'none', label: __( 'None', 'suki' ) },
			{ value: 'uppercase', label: __( 'Uppercase', 'suki' ) },
			{ value: 'lowercase', label: __( 'Lowercase', 'suki' ) },
			{ value: 'capitalize', label: __( 'Capitalize', 'suki' ) },
		];

		const fontSizeUnits = [
			{ value: 'px', label: 'px', default: '', min: '0', step: '1' },
			{ value: 'em', label: 'em', default: '', min: '0', step: '0.01' },
			{ value: 'rem', label: 'rem', default: '', min: '0', step: '0.01' },
			{ value: '%', label: '%', default: '', min: '0', step: '0.01' },
		];

		const lineHeightUnits = [
			{ value: '', label: '', default: '', min: '0', step: '0.01' },
		];

		const letterSpacingUnits = [
			{ value: 'px', label: 'px', default: '', step: '1' },
			{ value: 'em', label: 'em', default: '', step: '0.01' },
			{ value: 'rem', label: 'rem', default: '', step: '0.01' },
		];

		const responsiveStructures = control.params.responsiveStructures;

		const content =
			<>
				{ control.params.label &&
					<SukiControlLabel target={ '_customize-input-' + control.id }>
						{ control.params.label }
					</SukiControlLabel>
				}

				{ control.params.description &&
					<SukiControlDescription id={ '_customize-description-' + control.id }>
						{ control.params.description }
					</SukiControlDescription>
				}

				<Card
					size="xSmall"
				>
					<CardBody>
						<Flex
							direction="column"
						>
							{ control.settings.font_family &&
								<SelectControl
									label={ __( 'Family', 'suki' ) }
									value={ control.settings.font_family.get() }
									onChange={ ( fontFamily ) => {
										control.settings.font_family.set( fontFamily );
									} }
									__nextHasNoMarginBottom
								>
									<option value="">{ __( '', 'suki' ) }</option>
									{ Object.keys( sukiCustomizerData.fonts ).map( ( groupLabel ) => {
										if ( 1 > Object.keys( sukiCustomizerData.fonts[ groupLabel ] ).length ) {
											return null;
										}

										return (
											<optgroup
												key={ groupLabel }
												label={ sukiCustomizerData.fontGroups[ groupLabel ] || groupLabel }
											>
												{ Object.keys( sukiCustomizerData.fonts[ groupLabel ] ).map( ( familyName ) => {
													return (
														<option
															key={ familyName }
															value={ familyName }
														>
															{ familyName }
														</option>
													);
												} ) }
											</optgroup>
										);
									} ) }
								</SelectControl>
							}

							<Grid
								columns="3"
								gap="1"
							>
								{ control.settings.font_weight &&
									<SelectControl
										label={ __( 'Weight', 'suki' ) }
										value={ control.settings.font_weight.get() }
										options={ fontWeightOptions }
										onChange={ ( fontWeight ) => {
											control.settings.font_weight.set( fontWeight );
										} }
										__nextHasNoMarginBottom
									/>
								}

								{ control.settings.font_style &&
									<SelectControl
										label={ __( 'Style', 'suki' ) }
										value={ control.settings.font_style.get() }
										options={ fontStyleOptions }
										onChange={ ( fontStyle ) => {
											control.settings.font_style.set( fontStyle );
										} }
										__nextHasNoMarginBottom
									/>
								}

								{ control.settings.text_transform &&
									<SelectControl
										label={ __( 'Transform', 'suki' ) }
										value={ control.settings.text_transform.get() }
										options={ textTransformOptions }
										onChange={ ( textTransform ) => {
											control.settings.text_transform.set( textTransform );
										} }
										__nextHasNoMarginBottom
									/>
								}
							</Grid>

							<SukiControlResponsiveSwitcher devices={ Object.keys( responsiveStructures ) } />

							{ Object.keys( responsiveStructures ).map( ( device ) => {
								if ( 'global' === device ) {
									return ( null );
								}

								const fontSizeSettingId = 'font_size' + ( 'desktop' !== device ? '__' + device : '' );
								const fontSizeValue = control.settings[ fontSizeSettingId ]?.get() || '';
								const fontSizeUnit = parseQuantityAndUnitFromRawValue( fontSizeValue, control.params.units )[ 1 ] || fontSizeUnits[ 0 ].value;
								const fontSizeUnitObj = fontSizeUnits.find( ( item ) => {
									return fontSizeUnit === item.value;
								} );

								const lineHeightSettingId = 'line_height' + ( 'desktop' !== device ? '__' + device : '' );
								const lineHeightValue = control.settings[ lineHeightSettingId ]?.get() || '';
								const lineHeightUnit = parseQuantityAndUnitFromRawValue( lineHeightValue, control.params.units )[ 1 ] || lineHeightUnits[ 0 ].value;
								const lineHeightUnitObj = lineHeightUnits.find( ( item ) => {
									return lineHeightUnit === item.value;
								} );

								const letterSpacingSettingId = 'letter_spacing' + ( 'desktop' !== device ? '__' + device : '' );
								const letterSpacingValue = control.settings[ letterSpacingSettingId ]?.get() || '';
								const letterSpacingUnit = parseQuantityAndUnitFromRawValue( letterSpacingValue, control.params.units )[ 1 ] || letterSpacingUnits[ 0 ].value;
								const letterSpacingUnitObj = letterSpacingUnits.find( ( item ) => {
									return letterSpacingUnit === item.value;
								} );

								return (
									<SukiControlResponsiveContainer
										key={ device }
										device={ device }
									>
										<Grid
											columns="3"
											gap="1"
										>
											{ control.settings[ fontSizeSettingId ] &&
												<UnitControl
													label={ __( 'Size', 'suki' ) }
													value={ fontSizeValue }
													isResetValueOnUnitChange={ true }
													units={ fontSizeUnits }
													min={ fontSizeUnitObj.min ?? -Infinity }
													max={ fontSizeUnitObj.max ?? Infinity }
													step={ fontSizeUnitObj.step ?? 1 }
													className="suki-dimension"
													onChange={ ( fontSize ) => {
														fontSize = isNaN( parseFloat( fontSize ) ) ? '' : fontSize;

														control.settings[ fontSizeSettingId ].set( fontSize );
													} }
												/>
											}

											{ control.settings[ lineHeightSettingId ] &&
												<UnitControl
													label={ __( 'Line Height', 'suki' ) }
													value={ control.settings[ lineHeightSettingId ].get() }
													isResetValueOnUnitChange={ true }
													units={ lineHeightUnits }
													min={ lineHeightUnitObj.min ?? -Infinity }
													max={ lineHeightUnitObj.max ?? Infinity }
													step={ lineHeightUnitObj.step ?? 1 }
													className="suki-dimension"
													onChange={ ( lineHeight ) => {
														lineHeight = isNaN( parseFloat( lineHeight ) ) ? '' : lineHeight;

														control.settings[ lineHeightSettingId ].set( lineHeight );
													} }
												/>
											}

											{ control.settings[ letterSpacingSettingId ] &&
												<UnitControl
													label={ __( 'Spacing', 'suki' ) }
													value={ control.settings[ letterSpacingSettingId ].get() }
													isResetValueOnUnitChange={ true }
													units={ letterSpacingUnits }
													min={ letterSpacingUnitObj.min ?? -Infinity }
													max={ letterSpacingUnitObj.max ?? Infinity }
													step={ letterSpacingUnitObj.step ?? 1 }
													className="suki-dimension"
													onChange={ ( letterSpacing ) => {
														letterSpacing = isNaN( parseFloat( letterSpacing ) ) ? '' : letterSpacing;

														control.settings[ letterSpacingSettingId ].set( letterSpacing );
													} }
												/>
											}
										</Grid>
									</SukiControlResponsiveContainer>
								);
							} ) }
						</Flex>
					</CardBody>
				</Card>
			</>;

		if ( ! control.root ) {
			control.root = createRoot( control.container[ 0 ] );
		}

		control.root.render( content );
	},
} );

wp.customize.controlConstructor[ 'suki-typography' ] = wp.customize.SukiTypographyControl;
