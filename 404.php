<?php
/**
 * The template for displaying 404 pages (not found).
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
        <section id="content" class="error-404 not-found">
            <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
            	<header class="entry-header">
            		<h1 class="entry-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'tuhh-institute' ); ?></h1>
            	</header><!-- .entry-header -->
            	<div class="entry-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'tuhh-institute' ); ?></p>

					<?php get_search_form(); ?>

					<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

					<?php if ( tuhh_institute_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
					<div class="widget widget_categories">
						<h2 class="widget-title"><?php _e( 'Most Used Categories', 'tuhh-institute' ); ?></h2>
						<ul>
						<?php
							wp_list_categories( array(
								'orderby'    => 'count',
								'order'      => 'DESC',
								'show_count' => 1,
								'title_li'   => '',
								'number'     => 10,
							) );
						?>
						</ul>
					</div><!-- .widget -->
					<?php endif; ?>

					<?php
						/* translators: %1$s: smiley */
						$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'tuhh-institute' ), '' ) . '</p>';
						the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
					?>

					<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
            	</div><!-- .entry-content -->
            	<footer class="entry-footer">
            	</footer><!-- .entry-footer -->
            </article>
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
