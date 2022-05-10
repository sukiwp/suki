/**
 * Background control (React)
 */

import SukiControlLabel from '../components/SukiControlLabel';
import SukiControlDescription from '../components/SukiControlDescription';

import {
	__experimentalGrid as Grid,
	__experimentalVStack as VStack,
	Button,
	SelectControl,
} from '@wordpress/components';

wp.customize.SukiBackgroundControl = wp.customize.SukiReactControl.extend( {
	renderContent: function() {
		const control = this;

		const attachmentOptions = [
			{ value: 'scroll', label: SukiCustomizerData.l10n.scroll },
			{ value: 'italic', label: SukiCustomizerData.l10n.italic },
		];

		const repeatOptions = [
			{ value: 'repeat', label: SukiCustomizerData.l10n.repeatBoth },
			{ value: 'repeat-x', label: SukiCustomizerData.l10n.repeatX },
			{ value: 'repeat-y', label: SukiCustomizerData.l10n.repeatY },
			{ value: 'no-repeat', label: SukiCustomizerData.l10n.noRepeat },
		];

		const sizeOptions = [
			{ value: 'auto', label: SukiCustomizerData.l10n.auto },
			{ value: 'contain', label: SukiCustomizerData.l10n.contain },
			{ value: 'cover', label: SukiCustomizerData.l10n.cover },
		];

		const positionOptions = [
			{ value: 'left top', label: SukiCustomizerData.l10n.leftTop },
			{ value: 'left center', label: SukiCustomizerData.l10n.leftCenter },
			{ value: 'left bottom', label: SukiCustomizerData.l10n.leftBottom },
			{ value: 'center top', label: SukiCustomizerData.l10n.centerTop },
			{ value: 'center center', label: SukiCustomizerData.l10n.centerCenter },
			{ value: 'center bottom', label: SukiCustomizerData.l10n.centerBottom },
			{ value: 'right top', label: SukiCustomizerData.l10n.rightTop },
			{ value: 'right right', label: SukiCustomizerData.l10n.rightCenter },
			{ value: 'right bottom', label: SukiCustomizerData.l10n.rightBottom },
		];

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

				<VStack
					spacing="2"
					className="suki-control-content-box"
				>
					{ control.settings.image &&
						<div className="suki-media-upload">
							{ control.params.imageAttachment ?
								<VStack
									spacing="2"
								>
									<div className="suki-media-upload__image">
										<img src={ control.params.imageAttachment.sizes?.medium?.url }/>
									</div>

									<Grid
										columns="2"
										gap="2"
									>
										<Button
											icon="upload"
											text={ SukiCustomizerData.l10n.changeImage }
											variant="secondary"
											className="suki-media-upload__actions__open"
											onClick={ ( e ) => {
												e.preventDefault();

												control.openMediaLibrary();
											} }
										/>
										<Button
											icon="no-alt"
											text={ SukiCustomizerData.l10n.removeImage }
											variant="secondary"
											className="suki-media-upload__actions__remove"
											onClick={ ( e ) => {
												e.preventDefault();

												control.removeImage();
											} }
										/>
									</Grid>
								</VStack>
							:
								<Grid
									columns="1"
								>
									<Button
										icon="upload"
										text={ SukiCustomizerData.l10n.selectImage }
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
						<VStack
							spacing="2"
						>
							<Grid
								columns="2"
								gap="2"
							>
								{ control.settings.attachment &&
									<SelectControl
										label={ SukiCustomizerData.l10n.attachment }
										value={ control.settings.attachment.get() }
										options={ attachmentOptions }
										onChange={ ( attachment ) => {
											control.settings.attachment.set( attachment );
										} }
									/>
								}

								{ control.settings.repeat &&
									<SelectControl
										label={ SukiCustomizerData.l10n.repeat }
										value={ control.settings.repeat.get() }
										options={ repeatOptions }
										onChange={ ( repeat ) => {
											control.settings.repeat.set( repeat );
										} }
									/>
								}

								{ control.settings.size &&
									<SelectControl
										label={ SukiCustomizerData.l10n.size }
										value={ control.settings.size.get() }
										options={ sizeOptions }
										onChange={ ( size ) => {
											control.settings.size.set( size );
										} }
									/>
								}

								{ control.settings.position &&
									<SelectControl
										label={ SukiCustomizerData.l10n.position }
										value={ control.settings.position.get() }
										options={ positionOptions }
										onChange={ ( position ) => {
											control.settings.position.set( position );
										} }
									/>
								}
							</Grid>
						</VStack>
					}
				</VStack>
			</>,
			control.container[0]
		);
	},

	openMediaLibrary: function() {
		const control = this;

		if ( ! control.mediaLibrary ) {
			control.initMediaLibrary();
		}

		control.mediaLibrary.open();
	},

	initMediaLibrary: function() {
		const control = this;

		control.mediaLibrary = wp.media({
			states: [
				new wp.media.controller.Library({
					library: wp.media.query({ type: 'image' }),
					multiple: false,
					date: false,
				}),
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
	
	onOpenMediaLibrary: function() {
		const control = this;

		if ( control.params.imageAttachment ) {
			var attachment = wp.media.attachment( control.params.imageAttachment.id );

			attachment.fetch();

			control.mediaLibrary.state().get( 'selection' ).add( [ attachment ] );
		}
	},

	onSelectMediaLibrary: function() {
		const control = this;

		var attachment = control.mediaLibrary.state().get( 'selection' ).first().toJSON();

		control.params.imageAttachment = attachment;

		// Set the Customizer setting; the callback takes care of rendering.
		control.settings.image.set( attachment.url );
	},

	removeImage: function() {
		const control = this;

		control.params.imageAttachment = undefined;

		control.settings.image.set( '' );
	},
} );

wp.customize.controlConstructor['suki-background'] = wp.customize.SukiBackgroundControl;