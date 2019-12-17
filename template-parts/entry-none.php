<?php
/**
 * Not found entry template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<section class="no-results not-found">
	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<h1><?php esc_html_e( 'Nothing Found', 'suki' ); ?></h1>
			<p>
				<a href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>"><?php esc_html_e( 'Ready to publish your first post? Get started here.', 'suki' ); ?></a>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p>
				<?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'suki' ); ?>
			</p>

		<?php else : ?>

			<p>
				<?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'suki' ); ?>
			</p>

			<?php get_search_form(); ?>

		<?php endif; ?>
	</div>
</section>
