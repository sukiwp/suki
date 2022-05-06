/**
 * Dimensions control (React)
 */

import SukiControlLabel from '../components/SukiControlLabel';
import SukiControlDescription from '../components/SukiControlDescription';

import {
	__experimentalGrid as Grid,
	__experimentalVStack as VStack,
	Button
} from '@wordpress/components';

wp.customize.SukiDimensionsControl = wp.customize.SukiReactControl.extend( {
	renderContent: function() {
		const control = this;

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

				<Grid
					columns={ control.params.columns || control.params.choices.length }
					gap="1"
					className="suki-radioimage"
				>
					{ control.params.choices.map( ( choice ) => {
						return (
							<Button
								key={ choice.value }
								isPressed={ choice.value === control.setting.get() }
								className="suki-radioimage__option"
								onClick={ () => {
									control.setting.set( choice.value );
								} }
							>
								<VStack
									expanded
									spacing="0.5"
									justify="center"
									style={ {
										width: '100%'
									} }
								>
									{ choice.image &&
										<img src={ choice.image } role="img" aria-hidden="true"/>
									}
									<span>{ choice.label }</span>
								</VStack>
							</Button>
						);
					} ) }
				</Grid>
			</>,
			control.container[0]
		);
	},
} );

wp.customize.controlConstructor['suki-radioimage'] = wp.customize.SukiDimensionsControl;