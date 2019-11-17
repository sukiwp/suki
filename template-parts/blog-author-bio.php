<?php
/**
 * Blog author bio template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="entry-author">
	<div class="entry-author-body">
		<div class="entry-author-name vcard">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'suki/frontend/entry_author_bio_avatar_size', 80 ), '', get_the_author_meta( 'display_name' ) ); ?>
			<b class="fn"><?php the_author_posts_link(); ?></b>
		</div>
		<div class="entry-author-content">
			<?php echo wp_kses_post( wpautop( get_the_author_meta( 'description' ) ) ); ?>
		</div>
	</div>
</div>