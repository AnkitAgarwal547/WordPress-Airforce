<?php /* Template Name: PageWithoutSidebar */ ?>





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

<div class="container-fluid">
<div class="vc_row wpb_row vc_row-fluid page-sliders vc_row-has-fill vc_row-o-equal-height vc_row-flex">
	<div class="wpb_column vc_column_container vc_col-sm-4">
		<div class="vc_column-inner">
			<div class="explore-tafs">
				<div class="title">Explore <i>AFS</i></div>
				<?php 
					echo do_shortcode('[smartslider3 slider=6]');
				?>
			</div>
		</div>
	</div>
	<div class="wpb_column vc_column_container vc_col-sm-8">
		<div class="vc_column-inner">
			<div class="activities-tafs">
				<?php 
					echo do_shortcode('[smartslider3 slider=5]');
				?>
			</div>
		</div>
	</div>
</div>
</div>



<div id="primary" class="page-content">

	<main id="main" class="site-main" role="main">

		<div class="container">

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

		</div>

	</main><!-- .site-main -->



	<?php get_sidebar( 'content-bottom' ); ?>



</div><!-- .content-area -->

<?php get_footer(); ?>

