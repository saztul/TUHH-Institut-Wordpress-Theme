<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package TUHH Institute
 */

get_header(); ?>
    <section id="content-frame">
        <nav id="breadcrumb">
            <div>
            <?php tuhh_breadcrumbs(); ?>
            </div>
        </nav>
        <section id="content">
		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							printf( __( 'Author: %s', 'tuhh-institute' ), '<span class="vcard">' . get_the_author() . '</span>' );

						elseif ( is_day() ) :
							printf( __( 'Day: %s', 'tuhh-institute' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( __( 'Month: %s', 'tuhh-institute' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'tuhh-institute' ) ) . '</span>' );

						elseif ( is_year() ) :
							printf( __( 'Year: %s', 'tuhh-institute' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'tuhh-institute' ) ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides', 'tuhh-institute' );

						elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
							_e( 'Galleries', 'tuhh-institute' );

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'tuhh-institute' );

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'tuhh-institute' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes', 'tuhh-institute' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links', 'tuhh-institute' );

						elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
							_e( 'Statuses', 'tuhh-institute' );

						elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
							_e( 'Audios', 'tuhh-institute' );

						elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
							_e( 'Chats', 'tuhh-institute' );

						else :
							_e( 'Archives', 'tuhh-institute' );

						endif;
					?>
				</h1>
				<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
				?>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php tuhh_institute_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

        </section>
        <aside id="sidebar">
            <a class="anchor" name="siedebar" title="Seitenleiste"></a>
            <br>
            <?php tuhh_side_menu(); ?>
            <br>
            <?php get_sidebar(); ?>
        </aside>
    </section>
<?php get_footer(); ?>
