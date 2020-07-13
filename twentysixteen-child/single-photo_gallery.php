<?php
/**
 * The template for displaying Gallery Images
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>
<div class="container-fluid">
<div class="vc_row wpb_row vc_row-fluid page-sliders vc_row-has-fill vc_row-o-equal-height vc_row-flex main-header-container-airforce">
	<div class="wpb_column vc_column_container vc_col-sm-4 col-4-airforce-header">
		<div class="vc_column-inner">
			<div class="explore-tafs">
				<div class="title">Explore <i>AFS</i></div>
				<?php 
					echo do_shortcode('[smartslider3 slider=6]');
				?>
			</div>
		</div>
	</div>
	<div class="wpb_column vc_column_container vc_col-sm-8 col-8-airforce-header">
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
<!-- <img src="<?php echo get_site_url().'/wp-content/uploads/2019/07/blue-waves.png' ?>" class="img-fluid"> -->
<div class="container page-content clearfix">
	<div id="primary" class="content-area ">
	    <h2 class="page-title black"><?php the_title(); ?></h2>
		<main id="main" class="site-main" role="main">
			<?php
			// Start the loop.
			while ( have_posts() ) :
				the_post();

				// Include the gallery.

				$images = get_field('gallery_pictures'); ?>
				<div class="gallery-single-page-slider">
					<?php foreach( $images as $image ): ?>

						<!-- <a class="example-image-link" href="<?php echo $image['sizes']['large']; ?>" data-lightbox="example-set"><img class="example-image" src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?>"/></a> -->

						<a class="gallery-pic" href="<?php echo $image['url']; ?>" data-lightbox="example-set" style="background-image:url(<?php echo $image['sizes']['medium']; ?>);"></a>

					<?php endforeach; ?>
				</div>
			<?php	// End of the loop.
			endwhile;
			?>

		</main><!-- .site-main -->

		<?php get_sidebar( 'content-bottom' ); ?>

	</div><!-- .content-area -->
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
