<?php /* Template Name: Pagewithbreadcrumb */ ?>

<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>
<div class="breadcrumbs">
	<div class="breadcrumb-content">
		<?php
			echo "<h1>".get_the_title()."</h1>";
		?>
		<div class="breadcrumb-links">
			<?php
				if(function_exists('yoast_breadcrumb')){
					yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
				}
			?>
		</div>
	</div>
</div>
<!-- <img src="<?php echo get_site_url().'/wp-content/uploads/2019/07/breadcrumb-bg.jpg' ?>" class="img-fluid"> -->
<div class="container page-content clearfix">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
			// Start the loop.
			while ( have_posts() ) :
				the_post();

				// Include the page content template.
				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

				// End of the loop.
			endwhile;
			?>

		</main><!-- .site-main -->

		<?php get_sidebar( 'content-bottom' ); ?>

	</div><!-- .content-area -->
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>