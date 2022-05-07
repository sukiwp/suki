/**
 * Typography control (React)
 */

import SukiControlLabel from '../components/SukiControlLabel';
import SukiControlDescription from '../components/SukiControlDescription';
import SukiControlResponsiveSwitcher from '../components/SukiControlResponsiveSwitcher';
import SukiControlResponsiveContainer from '../components/SukiControlResponsiveContainer';

import {
	__experimentalGrid as Grid,
	__experimentalVStack as VStack,
	__experimentalUnitControl as UnitControl,
	Card,
	CardBody,
	SelectControl,
} from '@wordpress/components';

wp.customize.SukiTypographyControl = wp.customize.SukiReactControl.extend( {
	renderContent: function() {
		const control = this;

		const fontWeightOptions = [
			{ value: '', label: '' },
			{ value: 100, label: SukiCustomizerData.l10n.weight100 },
			{ value: 200, label: SukiCustomizerData.l10n.weight200 },
			{ value: 300, label: SukiCustomizerData.l10n.weight300 },
			{ value: 400, label: SukiCustomizerData.l10n.weight400 },
			{ value: 500, label: SukiCustomizerData.l10n.weight500 },
			{ value: 600, label: SukiCustomizerData.l10n.weight600 },
			{ value: 700, label: SukiCustomizerData.l10n.weight700 },
			{ value: 800, label: SukiCustomizerData.l10n.weight800 },
			{ value: 900, label: SukiCustomizerData.l10n.weight900 },
		];

		const fontStyleOptions = [
			{ value: '', label: '' },
			{ value: 'normal', label: SukiCustomizerData.l10n.normal },
			{ value: 'italic', label: SukiCustomizerData.l10n.italic },
		];

		const textTransformOptions = [
			{ value: '', label: '' },
			{ value: 'none', label: SukiCustomizerData.l10n.none },
			{ value: 'uppercase', label: SukiCustomizerData.l10n.uppercase },
			{ value: 'lowercase', label: SukiCustomizerData.l10n.lowercase },
			{ value: 'capitalize', label: SukiCustomizerData.l10n.capitalize },
		];

		const fontSizeUnits = [
			{ value: 'px', label: 'px' },
			{ value: 'em', label: 'em' },
			{ value: 'rem', label: 'rem' },
			{ value: '%', label: '%' },
		];

		const lineHeightUnits = [
			{ value: 'px', label: 'px' },
			{ value: '', label: 'em' },
			{ value: 'rem', label: 'rem' },
			{ value: '%', label: '%' },
		];

		const letterSpacingUnits = [
			{ value: 'px', label: 'px' },
			{ value: 'em', label: 'em' },
			{ value: 'rem', label: 'rem' },
		];

		let responsiveStructures = control.params.responsiveStructures;

		ReactDOM.render(
			<>
				{ control.params.label &&
					<SukiControlLabel for={ '_customize-input-' + control.id }>
						{ control.params.label }
					</SukiControlLabel>
				}

				{ control.params.description &&
					<SukiControlDescription id={ '_customize-description-' + control.id }>
						{ control.params.description }
					</SukiControlDescription>
				}

				<Card>
					<CardBody
						size="xSmall"
					>
						<VStack
							spacing="2"
						>
							{ control.settings.font_family &&
								<SelectControl
									label={ SukiCustomizerData.l10n.fontFamily }
									value={ control.settings.font_family.get() }
									onChange={ ( fontFamily ) => {
										control.settings.font_family.set( fontFamily );
									} }
								>
									{ Object.keys( SukiCustomizerData.fonts ).map( ( groupLabel ) => {
										return (
											<optgroup
												key={ groupLabel }
												label={ groupLabel }
											>
												{ Object.keys( SukiCustomizerData.fonts[ groupLabel ] ).map( ( familyName ) => {
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
								gap="2"
							>
								{ control.settings.font_weight &&
									<SelectControl
										label={ SukiCustomizerData.l10n.fontWeight }
										value={ control.settings.font_weight.get() }
										options={ fontWeightOptions }
										onChange={ ( fontWeight ) => {
											control.settings.font_weight.set( fontWeight );
										} }
									/>
								}

								{ control.settings.font_style &&
									<SelectControl
										label={ SukiCustomizerData.l10n.fontStyle }
										value={ control.settings.font_style.get() }
										options={ fontStyleOptions }
										onChange={ ( fontStyle ) => {
											control.settings.font_style.set( fontStyle );
										} }
									/>
								}

								{ control.settings.text_transform &&
									<SelectControl
										label={ SukiCustomizerData.l10n.textTransform }
										value={ control.settings.text_transform.get() }
										options={ textTransformOptions }
										onChange={ ( textTransform ) => {
											control.settings.text_transform.set( textTransform );
										} }
									/>
								}
							</Grid>

							<SukiControlResponsiveSwitcher devices={ Object.keys( responsiveStructures ) }/>

							{ Object.keys( responsiveStructures ).map( ( device ) => {
								if ( 'global' === device ) {
									return;
								}

								const fontSizeSettingId = 'font_size' + ( 'desktop' !== device ? '__' + device : '' );
								const lineHeightSettingId = 'line_height' + ( 'desktop' !== device ? '__' + device : '' );
								const letterSpacingSettingId = 'letter_spacing' + ( 'desktop' !== device ? '__' + device : '' );

								return (
									<SukiControlResponsiveContainer
										key={ device }
										device={ device }
									>
										<Grid
											columns="3"
											gap="2"
										>
											{ control.settings[ fontSizeSettingId ] &&
												<UnitControl
													label={ SukiCustomizerData.l10n.fontSize }
													value={ control.settings[ fontSizeSettingId ].get() }
													isResetValueOnUnitChange
													units={ fontSizeUnits }
													min="0"
													className="suki-dimension"
													onChange={ ( fontSize ) => {
														fontSize = isNaN( parseFloat( fontSize ) ) ? '' : fontSize;
														
														control.settings[ fontSizeSettingId ].set( fontSize );
													} }
												/>
											}

											{ control.settings[ lineHeightSettingId ] &&
												<UnitControl
													label={ SukiCustomizerData.l10n.lineHeight }
													value={ control.settings[ lineHeightSettingId ].get() }
													isResetValueOnUnitChange
													units={ lineHeightUnits }
													min="0"
													className="suki-dimension"
													onChange={ ( lineHeight ) => {
														lineHeight = isNaN( parseFloat( lineHeight ) ) ? '' : lineHeight;

														control.settings[ lineHeightSettingId ].set( lineHeight );
													} }
												/>
											}

											{ control.settings[ letterSpacingSettingId ] &&
												<UnitControl
													label={ SukiCustomizerData.l10n.letterSpacing }
													value={ control.settings[ letterSpacingSettingId ].get() }
													isResetValueOnUnitChange
													units={ letterSpacingUnits }
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
							
							
						</VStack>
					</CardBody>
				</Card>
			</>,
			control.container[0]
		);
	},
} );

wp.customize.controlConstructor['suki-typography'] = wp.customize.SukiTypographyControl;