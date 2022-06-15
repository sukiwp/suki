<?php
/**
 * Comments
 *
 * @package Suki
 */

ob_start();
?>
<!-- wp:comments-query-loop {
	"className":"suki-comments"
} --><div class="wp-block-comments-query-loop suki-comments">

	<!-- wp:comments-title /-->

	<!-- wp:comment-template {
		"className":"suki-comments__template"
	} -->

		<!-- wp:group {
			"layout":{
				"type":"flex",
				"orientation":"vertical"
			}
		} --><div class="wp-block-group">

			<!-- wp:group {
				"style":{
					"spacing":{
						"blockGap":"1rem"
					}
				},
				"layout":{
					"type":"flex",
					"flexWrap":"nowrap"
				}
			} --><div class="wp-block-group">

				<!-- wp:avatar {
					"size":50,
					"style":{
						"border":{
							"radius":"50%"
						}
					}
				} /-->

				<!-- wp:group {
					"layout":{
						"type":"default"
					}
				} --><div class="wp-block-group">

					<!-- wp:comment-author-name {
						"className":"suki-h6"
					} /-->

					<!-- wp:group {
						"style":{
							"spacing":{
								"margin":{
									"top":"0px",
									"bottom":"0px"
								},
								"blockGap":"0.75rem"
							}
						},
						"className":"suki-meta suki-reverse-link-color",
						"layout":{
							"type":"flex"
						}
					} --><div class="wp-block-group suki-meta suki-reverse-link-color" style="margin-top:0px;margin-bottom:0px">
						<!-- wp:comment-date /-->

						<!-- wp:comment-edit-link /-->
					</div><!-- /wp:group -->

				</div><!-- /wp:group -->

			</div><!-- /wp:group -->

			<!-- wp:comment-content /-->

			<!-- wp:comment-reply-link {
				"className":"suki-meta suki-reverse-link-color"
			} /-->

		</div><!-- /wp:group -->

	<!-- /wp:comment-template -->

	<!-- wp:comments-pagination {
		"paginationArrow":"arrow",
		"className":"suki-comments__pagination",
		"layout":{
			"type":"flex",
			"orientation":"horizontal",
			"justifyContent":"center"
		}
	} -->

		<!-- wp:comments-pagination-previous {
			"label":" "
		} /-->

		<!-- wp:comments-pagination-numbers /-->

		<!-- wp:comments-pagination-next {
			"label":" "
		} /-->

	<!-- /wp:comments-pagination -->

	<!-- wp:post-comments-form {
		"className":"suki-comments__form"
	} /-->

</div><!-- /wp:comments-query-loop -->
<?php
$content = ob_get_clean();

return array(
	'title'      => esc_html__( 'Comments', 'suki' ),
	'categories' => array( 'featured' ),
	'blockTypes' => array( 'core/comments-query-loop' ),
	'content'    => $content,
);
