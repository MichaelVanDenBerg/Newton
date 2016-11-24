<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Newton
 */

if ( ! function_exists( 'newton_post_date' ) ) :
/**
 * Echoes the current post date.
 *
 * @return string
 */
function newton_post_date() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_date = sprintf(
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	echo '<div class="entry-date">' . $posted_date . '</div>';
}
endif;

if ( ! function_exists( 'newton_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and author.
 */
function newton_entry_meta() {

	if ( is_singular() ) :

		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'newton' ) );
		$category_tag = esc_html__( 'Posted in: ', 'newton' );
		if ( $categories_list && newton_categorized_blog() ) {
			printf( '<span class="cat-links"><span class="cat-tag">' . $category_tag . '</span>' . $categories_list . '</span>' ); // WPCS: XSS OK
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'newton' ) );
		$tags_tag = esc_html__( 'Tagged with: ', 'newton' );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><span class="tags-tag">' . $tags_tag . '</span>' . $tags_list . '</span>' ); // WPCS: XSS OK
		}

	endif; //is_singular

	$post_author = sprintf(
		esc_html_x( 'Written by: %s', 'post author', 'newton' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);
	echo '<span class="post-author"> ' . $post_author . '</span>';

}
endif;

if ( ! function_exists( 'newton_entry_comments' ) ) :
/**
 * Prints HTML with the comments and edit link.
 */
function newton_entry_comments() {
	if ( is_singular() ) {
		edit_post_link( esc_html__( 'Edit', 'newton' ), '<span class="edit-link">', '</span>' );
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'No comments', 'newton' ), esc_html__( '1 Comment', 'newton' ), esc_html__( '% Comments', 'newton' ) );
		echo '</span>';
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function newton_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'newton_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'newton_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so newton_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so newton_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in newton_categorized_blog.
 */
function newton_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'newton_categories' );
}
add_action( 'edit_category', 'newton_category_transient_flusher' );
add_action( 'save_post',     'newton_category_transient_flusher' );

if ( ! function_exists( 'newton_post_thumbnail' ) ) :
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * @since Newton 1.0
 */
function newton_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<div class="post-thumbnail">
		<a class="post-thumbnail-link" href="<?php the_permalink(); ?>" aria-hidden="true">
			<?php
				the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
			?>
		</a>
	</div><!-- .post-thumbnail -->

	<?php endif; // End is_singular()
}
endif;
