<?php
/**
 * The template for displaying search results pages.
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
    				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'tuhh-institute' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
    			</header><!-- .page-header -->

    			<?php /* Start the Loop */ ?>
    			<?php while ( have_posts() ) : the_post(); ?>

    				<?php
    				/**
    				 * Run the loop for the search to output the results.
    				 * If you want to overload this in a child theme then include a file
    				 * called content-search.php and that will be used instead.
    				 */
    				get_template_part( 'content', 'search' );
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
<?php get_footer();  ?>
