/**
 * Typography control (React)
 */

import SukiControlLabel from '../components/SukiControlLabel';
import SukiControlDescription from '../components/SukiControlDescription';
import SukiControlResponsiveSwitcher from '../components/SukiControlResponsiveSwitcher';
import SukiControlResponsiveContainer from '../components/SukiControlResponsiveContainer';

import { convertDimensionValueIntoNumberAndUnit } from '../utils';

import {
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalGrid as Grid,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalUnitControl as UnitControl,
	CardBody,
	Card,
	Flex,
	SelectControl,
} from '@wordpress/components';

import { render } from '@wordpress/element';

wp.customize.SukiTypographyControl = wp.customize.SukiReactControl.extend( {
	renderContent() {
		const control = this;

		const fontWeightOptions = [
			{ value: '', label: '' },
			{ value: 100, label: sukiCustomizerData.l10n.weight100 },
			{ value: 200, label: sukiCustomizerData.l10n.weight200 },
			{ value: 300, label: sukiCustomizerData.l10n.weight300 },
			{ value: 400, label: sukiCustomizerData.l10n.weight400 },
			{ value: 500, label: sukiCustomizerData.l10n.weight500 },
			{ value: 600, label: sukiCustomizerData.l10n.weight600 },
			{ value: 700, label: sukiCustomizerData.l10n.weight700 },
			{ value: 800, label: sukiCustomizerData.l10n.weight800 },
			{ value: 900, label: sukiCustomizerData.l10n.weight900 },
		];

		const fontStyleOptions = [
			{ value: '', label: '' },
			{ value: 'normal', label: sukiCustomizerData.l10n.normal },
			{ value: 'italic', label: sukiCustomizerData.l10n.italic },
		];

		const textTransformOptions = [
			{ value: '', label: '' },
			{ value: 'none', label: sukiCustomizerData.l10n.none },
			{ value: 'uppercase', label: sukiCustomizerData.l10n.uppercase },
			{ value: 'lowercase', label: sukiCustomizerData.l10n.lowercase },
			{ value: 'capitalize', label: sukiCustomizerData.l10n.capitalize },
		];

		const fontSizeUnits = [
			{ value: 'px', label: 'px', default: '', min: '0', step: '1' },
			{ value: 'em', label: 'em', default: '', min: '0', step: '0.01' },
			{ value: 'rem', label: 'rem', default: '', min: '0', step: '0.01' },
			{ value: '%', label: '%', default: '', min: '0', step: '0.01' },
		];

		const lineHeightUnits = [
			{ value: 'px', label: 'px', default: '', min: '0', step: '1' },
			{ value: 'em', label: 'em', default: '', min: '0', step: '0.01' },
			{ value: 'rem', label: 'rem', default: '', min: '0', step: '0.01' },
			{ value: '%', label: '%', default: '', min: '0', step: '0.01' },
		];

		const letterSpacingUnits = [
			{ value: 'px', label: 'px', default: '', step: '1' },
			{ value: 'em', label: 'em', default: '', step: '0.01' },
			{ value: 'rem', label: 'rem', default: '', step: '0.01' },
		];

		const responsiveStructures = control.params.responsiveStructures;

		render(
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
					size="small"
				>
					<CardBody>
						<Flex
							direction="column"
						>
							{ control.settings.font_family &&
								<SelectControl
									label={ sukiCustomizerData.l10n.fontFamily }
									value={ control.settings.font_family.get() }
									onChange={ ( fontFamily ) => {
										control.settings.font_family.set( fontFamily );
									} }
								>
									{ Object.keys( sukiCustomizerData.fonts ).map( ( groupLabel ) => {
										return (
											<optgroup
												key={ groupLabel }
												label={ groupLabel }
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
										label={ sukiCustomizerData.l10n.fontWeight }
										value={ control.settings.font_weight.get() }
										options={ fontWeightOptions }
										onChange={ ( fontWeight ) => {
											control.settings.font_weight.set( fontWeight );
										} }
									/>
								}

								{ control.settings.font_style &&
									<SelectControl
										label={ sukiCustomizerData.l10n.fontStyle }
										value={ control.settings.font_style.get() }
										options={ fontStyleOptions }
										onChange={ ( fontStyle ) => {
											control.settings.font_style.set( fontStyle );
										} }
									/>
								}

								{ control.settings.text_transform &&
									<SelectControl
										label={ sukiCustomizerData.l10n.textTransform }
										value={ control.settings.text_transform.get() }
										options={ textTransformOptions }
										onChange={ ( textTransform ) => {
											control.settings.text_transform.set( textTransform );
										} }
									/>
								}
							</Grid>

							<SukiControlResponsiveSwitcher devices={ Object.keys( responsiveStructures ) } />

							{ Object.keys( responsiveStructures ).map( ( device ) => {
								if ( 'global' === device ) {
									return ( null );
								}

								const fontSizeSettingId = 'font_size' + ( 'desktop' !== device ? '__' + device : '' );
								const fontSizeValue = control.settings[ fontSizeSettingId ].get();
								const fontSizeUnit = convertDimensionValueIntoNumberAndUnit( fontSizeValue, control.params.units )[ 1 ] || fontSizeUnits[ 0 ].value;
								const fontSizeUnitObj = fontSizeUnits.find( ( item ) => {
									return fontSizeUnit === item.value;
								} );

								const lineHeightSettingId = 'line_height' + ( 'desktop' !== device ? '__' + device : '' );
								const lineHeightValue = control.settings[ lineHeightSettingId ].get();
								const lineHeightUnit = convertDimensionValueIntoNumberAndUnit( lineHeightValue, control.params.units )[ 1 ] || lineHeightUnits[ 0 ].value;
								const lineHeightUnitObj = lineHeightUnits.find( ( item ) => {
									return lineHeightUnit === item.value;
								} );

								const letterSpacingSettingId = 'letter_spacing' + ( 'desktop' !== device ? '__' + device : '' );
								const letterSpacingValue = control.settings[ letterSpacingSettingId ].get();
								const letterSpacingUnit = convertDimensionValueIntoNumberAndUnit( letterSpacingValue, control.params.units )[ 1 ] || letterSpacingUnits[ 0 ].value;
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
													label={ sukiCustomizerData.l10n.fontSize }
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
													label={ sukiCustomizerData.l10n.lineHeight }
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
													label={ sukiCustomizerData.l10n.letterSpacing }
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
			</>,
			control.container[ 0 ]
		);
	},
} );

wp.customize.controlConstructor[ 'suki-typography' ] = wp.customize.SukiTypographyControl;
