import './index.scss';

import SukiControlLabel from '../../components/control-label';
import SukiControlDescription from '../../components/control-description';

import {
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalGrid as Grid,
	Button,
	CardBody,
	Card,
	Flex,
	SelectControl,
} from '@wordpress/components';

import { render } from '@wordpress/element';

import { __ } from '@wordpress/i18n';

wp.customize.SukiBackgroundControl = wp.customize.SukiReactControl.extend( {
	renderContent() {
		const control = this;

		const attachmentOptions = [
			{ value: 'scroll', label: __( 'Scroll', 'suki' ) },
			{ value: 'fixed', label: __( 'Fixed', 'suki' ) },
		];

		const repeatOptions = [
			{ value: 'repeat', label: __( 'Repeat', 'suki' ) },
			{ value: 'repeat-x', label: __( 'Repeat horizontally', 'suki' ) },
			{ value: 'repeat-y', label: __( 'Repeat vertically', 'suki' ) },
			{ value: 'no-repeat', label: __( 'No repeat', 'suki' ) },
		];

		const sizeOptions = [
			{ value: 'auto', label: __( 'Auto', 'suki' ) },
			{ value: 'contain', label: __( 'Contain', 'suki' ) },
			{ value: 'cover', label: __( 'Cover', 'suki' ) },
		];

		const positionOptions = [
			{ value: 'left top', label: __( 'Left top', 'suki' ) },
			{ value: 'left center', label: __( 'Left center', 'suki' ) },
			{ value: 'left bottom', label: __( 'Left bottom', 'suki' ) },
			{ value: 'center top', label: __( 'Center top', 'suki' ) },
			{ value: 'center center', label: __( 'Center center', 'suki' ) },
			{ value: 'center bottom', label: __( 'Center bottom', 'suki' ) },
			{ value: 'right top', label: __( 'Right top', 'suki' ) },
			{ value: 'right right', label: __( 'Right center', 'suki' ) },
			{ value: 'right bottom', label: __( 'Right bottom', 'suki' ) },
		];

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
							{ control.settings.image &&
								<div className="suki-media-upload">
									{ control.params.imageAttachment &&
										<Flex
											direction="column"
										>
											<div className="suki-media-upload__image">
												<img src={ control.params.imageAttachment.sizes?.medium?.url } alt="" />
											</div>

											<Grid
												columns="2"
												gap="2"
											>
												<Button
													icon="upload"
													text={ __( 'Change image', 'suki' ) }
													variant="secondary"
													className="suki-media-upload__actions__open"
													onClick={ ( e ) => {
														e.preventDefault();

														control.openMediaLibrary();
													} }
												/>
												<Button
													icon="no-alt"
													text={ __( 'Remove image', 'suki' ) }
													variant="secondary"
													className="suki-media-upload__actions__remove"
													onClick={ ( e ) => {
														e.preventDefault();

														control.removeImage();
													} }
												/>
											</Grid>
										</Flex>
									}

									{ ! control.params.imageAttachment &&
										<Grid columns="1">
											<Button
												icon="upload"
												text={ __( 'Select image', 'suki' ) }
												variant="secondary"
												className="suki-media-upload-actions__open"
												onClick={ ( e ) => {
													e.preventDefault();

													control.openMediaLibrary();
												} }
											/>
										</Grid>
									}
								</div>
							}

							{ ( control.settings.attachment || control.settings.repeat || control.settings.size || control.settings.position ) &&
								<Grid
									columns="2"
									gap="2"
								>
									{ control.settings.attachment &&
										<SelectControl
											label={ __( 'Attachment', 'suki' ) }
											value={ control.settings.attachment.get() }
											options={ attachmentOptions }
											onChange={ ( attachment ) => {
												control.settings.attachment.set( attachment );
											} }
											__nextHasNoMarginBottom
										/>
									}

									{ control.settings.repeat &&
										<SelectControl
											label={ __( 'Repeat', 'suki' ) }
											value={ control.settings.repeat.get() }
											options={ repeatOptions }
											onChange={ ( repeat ) => {
												control.settings.repeat.set( repeat );
											} }
											__nextHasNoMarginBottom
										/>
									}

									{ control.settings.size &&
										<SelectControl
											label={ __( 'Size', 'suki' ) }
											value={ control.settings.size.get() }
											options={ sizeOptions }
											onChange={ ( size ) => {
												control.settings.size.set( size );
											} }
											__nextHasNoMarginBottom
										/>
									}

									{ control.settings.position &&
										<SelectControl
											label={ __( 'Position', 'suki' ) }
											value={ control.settings.position.get() }
											options={ positionOptions }
											onChange={ ( position ) => {
												control.settings.position.set( position );
											} }
											__nextHasNoMarginBottom
										/>
									}
								</Grid>
							}
						</Flex>
					</CardBody>
				</Card>
			</>,
			control.container[ 0 ]
		);
	},

	openMediaLibrary() {
		const control = this;

		if ( ! control.mediaLibrary ) {
			control.initMediaLibrary();
		}

		control.mediaLibrary.open();
	},

	initMediaLibrary() {
		const control = this;

		control.mediaLibrary = wp.media( {
			states: [
				new wp.media.controller.Library( {
					library: wp.media.query( { type: 'image' } ),
					multiple: false,
					date: false,
				} ),
			],
		} );

		// When a file is selected, run a callback.
		control.mediaLibrary.on( 'select', () => {
			control.onSelectMediaLibrary();
		} );

		control.mediaLibrary.on( 'open', () => {
			control.onOpenMediaLibrary();
		} );
	},

	onOpenMediaLibrary() {
		const control = this;

		if ( control.params.imageAttachment ) {
			const attachment = wp.media.attachment( control.params.imageAttachment.id );

			attachment.fetch();

			control.mediaLibrary.state().get( 'selection' ).add( [ attachment ] );
		}
	},

	onSelectMediaLibrary() {
		const control = this;

		const attachment = control.mediaLibrary.state().get( 'selection' ).first().toJSON();

		control.params.imageAttachment = attachment;

		// Set the Customizer setting; the callback takes care of rendering.
		control.settings.image.set( attachment.url );
	},

	removeImage() {
		const control = this;

		control.params.imageAttachment = undefined;

		control.settings.image.set( '' );
	},
} );

wp.customize.controlConstructor[ 'suki-background' ] = wp.customize.SukiBackgroundControl;
