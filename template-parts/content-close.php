<?php
/**
 * Content section closing tag template.
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
			</div>

			<?php
			/**
			 * Hook: suki/frontend/after_primary_and_sidebar
			 */
			do_action( 'suki/frontend/after_primary_and_sidebar' );
			?>

		</div>
	</div>
</div>