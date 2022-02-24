<?php
/**
 * Blog author bio template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	'<!-- wp:post-author {"avatarSize":96,"showBio":true,"backgroundColor":"base-2","className":"entry-author suki-has-margin-top__200"} /-->'
);
