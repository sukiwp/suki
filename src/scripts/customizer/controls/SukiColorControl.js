/**
 * Color control (React)
 */

import SukiControlLabel from '../components/SukiControlLabel';
import SukiControlDescription from '../components/SukiControlDescription';

import {
	__experimentalHStack as HStack,
	__experimentalVStack as VStack,
	Button,
	ColorIndicator,
	ColorPicker,
	Dropdown,
	Popover,
	SlotFillProvider,
	Tooltip,
} from '@wordpress/components';

wp.customize.SukiColorControl = wp.customize.SukiReactControl.extend( {
	renderContent: function() {
		const control = this;

		const value = control.setting.get();

		ReactDOM.render(
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

				<SlotFillProvider>
					<Dropdown
						position="bottom left"
						className="suki-color-dropdown"
						renderToggle={ ( toggleParams ) => {
							return (
								<Tooltip
									text={ value }
									position="top center"
								>
									<Button
										isSmall
										variant="tertiary"
										aria-expanded={ toggleParams.isOpen }
										id={ '_customize-input' + control.id }
										className="suki-color-dropdown__toggle"
										onClick={ toggleParams.onToggle }
									>
										<ColorIndicator
											colorValue={ value }
											className="suki-color-indicator"
										/>
									</Button>
								</Tooltip>
							);
						} }
						renderContent={ ( contentParams ) => {
							return (
								<VStack>
									<ColorPicker
										color={ value }
										onChange={ ( color ) => {
											control.setting.set( color );
										} }
										defaultValue="#ff0"
										enableAlpha
										className="suki-color-dropdown__picker"
									/>

									<HStack>
										<Button
											isSmall
											variant="secondary"
											onClick={ ( e ) => {
												control.setting.set( control.params.defaultValue );
											} }
										>
											{ SukiCustomizerData.l10n.reset }
										</Button>
									</HStack>
								</VStack>
							);
						} }
					/>
					<Popover.Slot/>
				</SlotFillProvider>
			</>,
			control.container[0]
		);
	},
} );

wp.customize.controlConstructor['suki-color'] = wp.customize.SukiColorControl;
