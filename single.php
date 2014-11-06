<?php
/**
 * The template for displaying all single posts.
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

    			<?php get_template_part( 'content', 'single' ); ?>

    			<?php tuhh_institute_post_nav(); ?>

    			<?php
    				// If comments are open or we have at least one comment, load up the comment template
    				if ( comments_open() || '0' != get_comments_number() ) :
    					comments_template();
    				endif;
    			?>

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