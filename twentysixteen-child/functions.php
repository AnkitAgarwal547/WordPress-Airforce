<?php

function namespace_theme_stylesheets() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
	wp_enqueue_style ('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
	wp_enqueue_style ('font-awesome5', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css');
	if (  is_single() ) {
    	wp_enqueue_style ('lightbox-css', get_stylesheet_directory_uri().'/lightbox/lightbox.min.css');
    	wp_enqueue_script('lightbox-js', get_stylesheet_directory_uri().'/lightbox/lightbox-plus-jquery.min.js', array('jquery'), '1.0.0', true );
	}
	
}
add_action( 'wp_enqueue_scripts', 'namespace_theme_stylesheets' );

function my_theme_scripts() {
    wp_enqueue_script('popper-js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array('jquery'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'my_theme_scripts' );

// ----------------- Disable Guetenburg --------------------------------
add_filter('use_block_editor_for_post', '__return_false', 10);
// ----------------- Disable Guetenburg Ends ---------------------------

// ------- Disable ACF Plugin updates and hide notification ------------
function filter_plugin_updates( $value ) {
    unset( $value->response['advanced-custom-fields-pro/acf.php'] );    
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );
// ------- Disable ACF Plugin updates and hide notification Ends --------

// -------------- Change Logo, URL, Title ADMIN area -------------------------
function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo home_url(); ?>/wp-content/uploads/2019/07/SCHOOL-LOGO.png);
			height: 80px;
			width: 100%;
			background-size: contain;
			background-repeat: no-repeat;
			padding-bottom: 20px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Airforce School Panchwati';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );
// -------------- Change Logo, URL, Title ADMIN area Ends ---------------

// ---------------- Shortcode for Homework ------------------------------

add_shortcode('Homework-airforce-school', 'homework_airforce_school');
function homework_airforce_school(){
	$args = array(
		'post_type' => 'homework',
		'post_status' => 'publish',
		'posts_per_page' => -1,
	);
	
	$query = new WP_Query($args);
	if($query->have_posts()){ ?>
	<div class="homework-responsive-table">
		<table class="homework-table">
			<tr class="head-table">
				<th>Class</th>
				<th>Section</th>
				<th>Homework File</th>
				<th>Updated Date</th>
			</tr>
		<?php while($query->have_posts()) : $query->the_post(); ?>
			
			<tr>
				<td>
					<?php 
						$classes = get_the_terms( $post->ID, "class" );
						echo $classes[0]->name;
					?>
				</td>
				<td>
					<?php 
						$section = get_the_terms( $post->ID, "section" );
						echo $section[0]->name;
					?>
				</td>
				<td>
					<a class="btn btn-success btn-sm" href="<?php echo the_field("homework_file_upload"); ?>"><i class="fa fa-file-pdf" aria-hidden="true"></i> | Download</a>
				</td>
				<td>
					<?php echo get_post_time("j F, Y"); ?>
				</td>
			</tr>
		<?php endwhile; ?>
		</table>
	</div>	
	<?php }
	wp_reset_query();	
}
// ---------------- Shortcode for Homework Ends --------------------------

// --------------------- Shortcode for Gallery ---------------------------

add_shortcode('Gallery-airforce-school', 'gallery_airforce_school');
function gallery_airforce_school(){
	$args = array(
		'post_type' => 'photo_gallery',
		'post_status' => 'publish',
		'posts_per_page' => -1,
	);
	
	$query = new WP_Query($args);
	if($query->have_posts()){ ?>
		<div class="gallery-airforce-main-page row">
			<?php while($query->have_posts()) : $query->the_post();?>
				<div class=" col-6">
					<div class="gallery-posts">
						<?php 
							$images = get_field('gallery_pictures');
							foreach( $images as $key=>$image ): ?>
								<a href="<?php echo get_the_permalink(); ?>">
									<div class="gallery-image" style="background-image:url(<?php echo $image['url']; ?>);"></div>
								</a>
							<?php if($key==0){ break;} endforeach;
						?>
						<div class="gallery-event-name">
							<a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
	<?php	}
	wp_reset_query();
}
// --------------------- Shortcode for Gallery Ends ---------------------------

// ---------------- Thought of the day shortcode ------------------------------
add_shortcode('Thought-of-the-day', 'thought_of_the_day');
function thought_of_the_day(){ ?>
	<div class="thought-day-container">
		<div class="content-thought-of-the-day">
			<h4>Thought of the Day</h4>
			<p>
				<?php
					$options = get_option( 'theme_settings' );
					if($options['thought-of-the-day']) {
						esc_attr_e( $options['thought-of-the-day'] );
					}
					else{
						echo 'Generating thoughts...';
					}
				?>
			</p>
		</div>
	</div>
<?php }
// ----------- Thought of the day shortcode Ends -------------------------------

// ------------------ register settings Option Page ----------------------------
function theme_options_add(){
    register_setting( 'theme_settings', 'theme_settings' );
}
 
//add settings page to menu
function add_options() {
add_menu_page( __( 'Theme Settings' ), __( 'Theme Settings' ), 'manage_options', 'settings', 'theme_options_page' , '
dashicons-admin-generic', 40);
}
//add actions
add_action( 'admin_init', 'theme_options_add' );
add_action( 'admin_menu', 'add_options' );
 
//start settings page
function theme_options_page() {
?>
<div>
	<form method="post" action="options.php">
		<h2>SMS Setting Options</h2>
		<?php settings_fields( 'theme_settings' ); ?>
		<?php $options = get_option( 'theme_settings' ); ?>
		<table style="width: 80%;">
			<tr valign="top">
				<th scope="row" style="text-align:left;"> <?php _e( 'TEXT LOCAL SETTINGS' ); ?></th>
			<tr>
			<tr>
				<td><label for="theme_settings[text_local_api_key]"><?php _e( 'Enter API Key' ); ?></label>
					<br /><br/>
					<input id="theme_settings[text_local_api_key]" name="theme_settings[text_local_api_key]" style="width:100%;" 		value="<?php 
							if($options['text_local_api_key']) {
								esc_attr_e( $options['text_local_api_key'] );
							}
						?>">
				</td>
				<td><label for="theme_settings[text_local_sender_id]"><?php _e( 'Sender ID' ); ?></label>
					<br /><br/>
					<input id="theme_settings[text_local_sender_id]" name="theme_settings[text_local_sender_id]" style="width:100%;" 		value="<?php 
							if($options['text_local_sender_id']) {
								esc_attr_e( $options['text_local_sender_id'] );
							}
						?>">
				</td>
			</tr>
		</table>
		<hr>
		<h2>Thought of The day</h2>
		<?php settings_fields( 'theme_settings' ); ?>
		<?php $options = get_option( 'theme_settings' ); ?>
		<table style="width: 80%;">
			<tr>
				<td><label for="theme_settings[thought-of-the-day]"><?php _e( 'Enter Thought' ); ?></label>
					<br /><br/>
					<input id="theme_settings[thought-of-the-day]" name="theme_settings[thought-of-the-day]" style="width:100%;" 		value="<?php 
							if($options['thought-of-the-day']) {
								esc_attr_e( $options['thought-of-the-day'] );
							}
						?>">
				</td>
			</tr>
		</table>
		<p><input name="submit" id="submit" value="Save Changes" class="button button-primary button-large" type="submit"></p>
	</form>

</div><!-- END wrap -->
<?php
}

// --------------------- register settings Option Page Ends -------------------------

// ------------------------------- Latest News Section -------------------------------

add_shortcode('Latest-News-airforce-school', 'latest_news_airforce_school');
function latest_news_airforce_school(){
	$args = array(
		'post_type' => 'notice',
		'post_status' => 'publish',
		'posts_per_page' => -1,
	);
	
	$query = new WP_Query($args);
	if($query->have_posts()){ ?>
		<div class="airforce-latest-news">
			<span>Latest News</span>
			<p  class="marquee">
				<?php while($query->have_posts()) : $query->the_post();?>
					<a href="<?php echo get_field('file_upload'); ?>" target="_blank"><?php echo get_the_title(); ?></a>
				<?php endwhile; ?>
			</p>
		</div>
	<?php }
	wp_reset_query();
}

// ----------------------------- Latest News Section Ends ----------------------------

// ------------------------------- Topbar shortcode ----------------------------------

add_shortcode('top-bar-airforce', 'top_bar_airforce');
function top_bar_airforce(){ ?>
<section class="top-bar">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<ul class="list-inline actions">
					<li><i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:011-25675467">011-25675467</a></li>
					<li><i class="fa fa-envelope-o" aria-hidden="true"></i> <a href="mailto:afspanchwati@gmail.com">afspanchwati@gmail.com</a></li>
				</ul>
			</div>
			<div class="col-sm-6">
				<ul class="list-inline social-media-icons">
					<li>
						<a href="" class="facebook" target="_blank"><span class="elementor-screen-only">Facebook</span><i class="fa fa-facebook"></i></a>
					</li>
					<li>
						<a href="" class="twitter" target="_blank"><span class="elementor-screen-only">twitter</span><i class="fa fa-twitter"></i></a>
					</li>
					<li>
						<a href="" class="linkedin" target="_blank"><span class="elementor-screen-only">Linkedin</span><i class="fa fa-linkedin"></i></a>
					</li>
					<li>
						<a href="" class="google-plus" target="_blank"><span class="elementor-screen-only">google-plus</span><i class="fa fa-google-plus"></i></a>
					</li>
					<li>
						<a href="" class="youtube" target="_blank"><span class="elementor-screen-only">youtube</span><i class="fa fa-youtube"></i></a>
					</li>
					<?php if(!is_user_logged_in()) { ?>
					<li>
						<a href="<?php echo home_url().'/login'; ?>" class="btn btn-yellow-login"><i class="fa fa-user-plus"></i> Login</a>
					</li>
					<?php } else { ?>
					<li>
						<div class="dropdown">
							<a class="btn btn-yellow-logi" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> <?php $current_user = wp_get_current_user(); echo $current_user->display_name ; ?></a>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
								<a class="dropdown-item" href="<?php echo admin_url(); ?>">Admin Panel</a>
								<a class="dropdown-item" href="<?php echo wp_logout_url(home_url()); ?>">Logout</a>
							</div>
						</div>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</section>
<?php }
// ------------------------------- Topbar shortcode Ends -------------------------------

// ---------------------- --------Rename Post to Notice --------------------------------

function revcon_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Notices';
    $submenu['edit.php'][5][0] = 'Notices';
    $submenu['edit.php'][10][0] = 'Add Notices';
    $submenu['edit.php'][16][0] = 'Notices Tags';
}
function revcon_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Notices';
    $labels->singular_name = 'Notices';
    $labels->add_new = 'Add Notices';
    $labels->add_new_item = 'Add Notices';
    $labels->edit_item = 'Edit Notices';
    $labels->new_item = 'Notices';
    $labels->view_item = 'View Notices';
    $labels->search_items = 'Search Notices';
    $labels->not_found = 'No News found';
    $labels->not_found_in_trash = 'No Notices found in Trash';
    $labels->all_items = 'All Notices';
    $labels->menu_name = 'Notices';
    $labels->name_admin_bar = 'Notices';
}
 
add_action( 'admin_menu', 'revcon_change_post_label' );
add_action( 'init', 'revcon_change_post_object' );

// -------------------------------Rename Post to Notice Ends ---------------------------

// -------------------------------- Change icon of Notices(posts) ----------------------

add_action( 'admin_menu', 'gowp_admin_menu' );
function gowp_admin_menu() {
  global $menu;
  foreach ( $menu as $key => $val ) {
    if ( 'Notices' == $val[0] ) {
      $menu[$key][6] = 'dashicons-pressthis';
    }
  }
}
// ------------------------- Change icon of Notices(posts) Ends ------------------------

// ------------------------- Login redirect if user logged in --------------------------

add_shortcode('login-redirect-user-airforce', 'login_redirect_user_airforce');
function login_redirect_user_airforce(){
    if ( is_user_logged_in() ) {
        wp_redirect(home_url());
        exit;
    }
    else{
        echo do_shortcode('[ultimatemember form_id="621"]');
    }
}

// ------------------------- Login redirect if user logged in Ends ----------------------

function remove_href_academic(){
	echo sprintf("<script>
		jQuery('.mec-event-container-simple .mec-monthly-tooltip.event-single-link-simple').removeAttr('href');
		jQuery(document).ready(function(){
			jQuery('.academic_calendar .mec-skin-monthly-view-month-navigator-container ').click(function() {
				jQuery('.mec-event-container-simple .mec-monthly-tooltip.event-single-link-simple').removeAttr('href');
				 
			}); 
		});
	</script>");
}

add_action("wp_footer", 'remove_href_academic');

add_filter( 'auto_update_plugin', '__return_false' );
add_filter( 'auto_update_theme', '__return_false' );