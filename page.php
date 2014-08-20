<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
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
			<?php while ( have_posts() ) : the_post(); ?>
                <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<?php get_template_part( 'content', 'page' ); ?>
				<?php /*
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				*/ ?>
            </article>
			<?php endwhile; // end of the loop. ?>
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
