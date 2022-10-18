/**
 * Background control (React)
 */

import SukiControlLabel from '../components/SukiControlLabel';
import SukiControlDescription from '../components/SukiControlDescription';

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

wp.customize.SukiBackgroundControl = wp.customize.SukiReactControl.extend( {
	renderContent() {
		const control = this;

		const attachmentOptions = [
			{ value: 'scroll', label: sukiCustomizerData.l10n.scroll },
			{ value: 'italic', label: sukiCustomizerData.l10n.italic },
		];

		const repeatOptions = [
			{ value: 'repeat', label: sukiCustomizerData.l10n.repeatBoth },
			{ value: 'repeat-x', label: sukiCustomizerData.l10n.repeatX },
			{ value: 'repeat-y', label: sukiCustomizerData.l10n.repeatY },
			{ value: 'no-repeat', label: sukiCustomizerData.l10n.noRepeat },
		];

		const sizeOptions = [
			{ value: 'auto', label: sukiCustomizerData.l10n.auto },
			{ value: 'contain', label: sukiCustomizerData.l10n.contain },
			{ value: 'cover', label: sukiCustomizerData.l10n.cover },
		];

		const positionOptions = [
			{ value: 'left top', label: sukiCustomizerData.l10n.leftTop },
			{ value: 'left center', label: sukiCustomizerData.l10n.leftCenter },
			{ value: 'left bottom', label: sukiCustomizerData.l10n.leftBottom },
			{ value: 'center top', label: sukiCustomizerData.l10n.centerTop },
			{ value: 'center center', label: sukiCustomizerData.l10n.centerCenter },
			{ value: 'center bottom', label: sukiCustomizerData.l10n.centerBottom },
			{ value: 'right top', label: sukiCustomizerData.l10n.rightTop },
			{ value: 'right right', label: sukiCustomizerData.l10n.rightCenter },
			{ value: 'right bottom', label: sukiCustomizerData.l10n.rightBottom },
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
													text={ sukiCustomizerData.l10n.changeImage }
													variant="secondary"
													className="suki-media-upload__actions__open"
													onClick={ ( e ) => {
														e.preventDefault();

														control.openMediaLibrary();
													} }
												/>
												<Button
													icon="no-alt"
													text={ sukiCustomizerData.l10n.removeImage }
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
												text={ sukiCustomizerData.l10n.selectImage }
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
											label={ sukiCustomizerData.l10n.attachment }
											value={ control.settings.attachment.get() }
											options={ attachmentOptions }
											onChange={ ( attachment ) => {
												control.settings.attachment.set( attachment );
											} }
										/>
									}

									{ control.settings.repeat &&
										<SelectControl
											label={ sukiCustomizerData.l10n.repeat }
											value={ control.settings.repeat.get() }
											options={ repeatOptions }
											onChange={ ( repeat ) => {
												control.settings.repeat.set( repeat );
											} }
										/>
									}

									{ control.settings.size &&
										<SelectControl
											label={ sukiCustomizerData.l10n.size }
											value={ control.settings.size.get() }
											options={ sizeOptions }
											onChange={ ( size ) => {
												control.settings.size.set( size );
											} }
										/>
									}

									{ control.settings.position &&
										<SelectControl
											label={ sukiCustomizerData.l10n.position }
											value={ control.settings.position.get() }
											options={ positionOptions }
											onChange={ ( position ) => {
												control.settings.position.set( position );
											} }
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
