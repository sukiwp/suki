import './index.scss';

import SukiControlLabel from '../../components/control-label';
import SukiControlDescription from '../../components/control-description';

import {
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalGrid as Grid,
	Button,
	Flex,
} from '@wordpress/components';

import { createRoot } from '@wordpress/element';

wp.customize.SukiDimensionsControl = wp.customize.SukiReactControl.extend( {
	renderContent() {
		const control = this;

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

				<Grid
					columns={ control.params.columns || 3 }
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
								<Flex
									direction="column"
									expanded
									gap="0"
									justify="center"
								>
									{ choice.image &&
										<img src={ choice.image } role="img" aria-hidden="true" alt="" />
									}
									<span>{ choice.label }</span>
								</Flex>
							</Button>
						);
					} ) }
				</Grid>
			</>;

		if ( ! control.root ) {
			control.root = createRoot( control.container[ 0 ] );
		}

		control.root.render( content );
	},
} );

wp.customize.controlConstructor[ 'suki-radioimage' ] = wp.customize.SukiDimensionsControl;
