<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Together
 */

if ( ! function_exists( 'together_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function together_posted_on() {
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

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'together' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'together' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'together_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function together_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'together' ) );
		if ( $categories_list && together_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'together' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'together' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'together' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'together' ), esc_html__( '1 Comment', 'together' ), esc_html__( '% Comments', 'together' ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'together' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function together_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'together_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'together_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so together_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so together_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in together_categorized_blog.
 */
function together_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'together_categories' );
}
add_action( 'edit_category', 'together_category_transient_flusher' );
add_action( 'save_post',     'together_category_transient_flusher' );


/**
 * Limit Excerpt Content
 */
function together_excerpt( $limit ) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count( $excerpt )>=$limit) {
		array_pop( $excerpt );
		$excerpt = implode(" ", $excerpt ).'...';
	} else {
		$excerpt = implode(" ", $excerpt );
	}
	$excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt );
	return $excerpt;
}

/**
 * Breadcrumbs
 */
function together_breadcrumb() {
	global $post;
	echo '<ul id="dt_breadcrumbs">';
	if ( !is_home() ) {
		echo '<li><a href="';
		echo esc_url( home_url() );
		echo '">';
		echo __( 'Home', 'together' );
		echo '</a></li><li class="separator"> / </li>';
		if ( is_category() || is_single() ) {
			echo '<li>';
			the_category( ' </li><li class="separator"> / </li><li> ' );
			if ( is_single() ) {
				echo '</li><li class="separator"> / </li><li>';
				the_title();
				echo '</li>';
			}
		} elseif ( is_page() ) {
			if ( $post->post_parent ){
				$anc = get_post_ancestors( $post->ID );
				$title = get_the_title();
				foreach ( $anc as $ancestor ) {
					$output = '<li><a href="'. esc_url( get_permalink( $ancestor ) ) .'" title="'. esc_attr( get_the_title( $ancestor ) ) .'">'. esc_attr( get_the_title( $ancestor ) ) .'</a></li> <li class="separator"> / </li>';
				}
				echo $output;
				echo esc_attr( $title );
			} else { ?>
				<li><?php the_title_attribute(); ?></li>
			<?php }
		}
	} elseif ( is_tag() ) {
		single_tag_title();
	} elseif ( is_day() ) {
		echo"<li>" . __( 'Archive for', 'together' ); the_time( 'F jS, Y' ); echo'</li>';
	} elseif ( is_month() ) {
		echo"<li>" . __( 'Archive for', 'together' ); the_time( 'F, Y' ); echo'</li>';
	} elseif ( is_year() ) {
		echo"<li>" . __( 'Archive for', 'together' ); the_time( 'Y' ); echo'</li>';
	} elseif ( is_author( ) ) {
		echo"<li>" . __( 'Author Archive', 'together' ); echo'</li>';
	} elseif ( isset( $_GET['paged'] ) && !empty( $_GET['paged'] ) ) {
		echo "<li>" . __( 'Blog Archive', 'together' ); echo'</li>';
	} elseif ( is_search() ) {
		echo "<li>" . __( 'Search Results', 'together' ); echo'</li>';
	}
	echo '</ul>';
}