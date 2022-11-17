import './index.scss';

import SukiControlLabel from '../../components/control-label';
import SukiControlDescription from '../../components/control-description';

import {
	Button,
	ColorIndicator,
	ColorPicker,
	Dropdown,
	Flex,
	Popover,
	SlotFillProvider,
	Tooltip,
} from '@wordpress/components';

import { render } from '@wordpress/element';

import { __ } from '@wordpress/i18n';

wp.customize.SukiColorControl = wp.customize.SukiReactControl.extend( {
	renderContent() {
		const control = this;

		const value = control.setting.get();

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
						renderContent={ () => {
							return (
								<Flex
									direction="column"
									gap="3"
									style={ {
										width: '248px',
									} }
								>
									<ColorPicker
										color={ value }
										onChange={ ( color ) => {
											control.setting.set( color );
										} }
										defaultValue="#ff0"
										enableAlpha
										className="suki-color-dropdown__picker"
									/>

									<Flex>
										<Button
											isSmall
											variant="secondary"
											onClick={ () => {
												control.setting.set( String( control.params.defaultValue ) );
											} }
										>
											{ __( 'Reset', 'suki' ) }
										</Button>
									</Flex>
								</Flex>
							);
						} }
					/>
					<Popover.Slot />
				</SlotFillProvider>
			</>,
			control.container[ 0 ]
		);
	},
} );

wp.customize.controlConstructor[ 'suki-color' ] = wp.customize.SukiColorControl;
