<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://webnauts.pro/
 * @since             1.0.1
 * @package           Bomondevent
 *
 * @wordpress-plugin
 * Plugin Name:       Bomond Event
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.1
 * Author:            Webnauts
 * Author URI:        https://webnauts.pro/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bomondevent
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bomondevent-activator.php
 */
function activate_bomondevent() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bomondevent-activator.php';
	Bomondevent_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bomondevent-deactivator.php
 */
function deactivate_bomondevent() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bomondevent-deactivator.php';
	Bomondevent_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bomondevent' );
register_deactivation_hook( __FILE__, 'deactivate_bomondevent' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bomondevent.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.1
 */
function run_bomondevent() {

	$plugin = new Bomondevent();
	$plugin->run();

}

run_bomondevent();

function footag_func(){
	wp_enqueue_script('jquery');

	  wp_enqueue_script('my-script', plugins_url('/public/js/slick.js', __FILE__), array('jquery'), '1.0', true);
	  wp_enqueue_style('my-style', plugins_url('/public/css/slick-theme.css', __FILE__));
	  wp_enqueue_style('my-style1', plugins_url('/public/css/slick.css', __FILE__));
	ob_start();
  ?> 
	<section class="regular slider">
    <?php
	$url = 'https://api.bomond.com/tours';
	$content = file_get_contents($url);
	$json = json_decode($content, true);
	date_default_timezone_set('America/Chicago');
	foreach($json['tours']as $item) {
		if($item[slug]!=null){
			echo '<div class="event_container"><a style="background: url('. $item[previewImage] .')" target="_blank" href="https://bomond.com/tours/'. $item[slug] .'">';
			echo '<div class="hHKXhv">';
			$from = date("M dS, Y", $item[startDate]);
			$to = date("M dS, Y", $item[endDate]);
			$str = ($from == $to) ? $from : $from.' - '.$to;
			echo '<div class="event_doorTime">'.$str.'</div>';
			echo '<div class="event_title">'.$item[title].'</div>' ;
			$events = $item[events];
			$i = 0;			
			foreach ($events as $value) {
				if ($i == 0) {
					echo '<div class="event_doorTime location"><i class="fa fa-map-marker" style="color:#fc2c50"></i> '.$value[place][city].'</div>' ;
				}else{
					echo '<div class="event_doorTime location" style="padding-left: 9px; border-left: 2px solid rgb(255, 255, 255); line-height: 1.1em; margin: 2px 0; ">'.$value[place][city].'</div>' ;
				}
				$i++;
			}

			echo "</div></a></div>";
		}else{
			echo '<div class="event_container"><a style="background: url('. $item[events][0][image][main] .')" target="_blank" href="https://bomond.com/events/'. $item[events][0][slug] .'">';
			echo '<div class="hHKXhv">';
			$from = date("M dS, Y", $item[events][0][date][from]);
			$to = date("M dS, Y", $item[events][0][date][to]);
			$str = ($from == $to) ? $from : $from.' - '.$to;
			echo '<div class="event_doorTime">'.$str.'</div>';
			echo '<div class="event_title">'.$item[events][0][title].'</div>' ;
			echo '<div class="event_doorTime location"><i class="fa fa-map-marker" style="color:#fc2c50"></i> '.$item[events][0][place][city].', '.$item[events][0][place][title] .'</div>' ;
			echo "</div></a></div>";
		}
	}?>
  </section>

<script type="text/javascript">
   (function($) { $(document).on('ready', function() {
      $(".regular").slick({
        dots: false,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
		  autoplay: true,
		  nextArrow: '<i class="fa fa-angle-right slick-arrow" style="font-size: 70px; display: inline-block;position: absolute;top: calc( 50% - .6em);left: 102%;"></i>',
		  prevArrow: '<i class="fa fa-angle-left slick-arrow" style="font-size: 70px; display: inline-block;position: absolute;top: calc( 50% - .6em);right: 102%;"></i>',
		  autoplaySpeed: 5000,
		  responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 3,
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 2,
				  }
				},
				{
				  breakpoint: 480,
				  settings: {
					slidesToShow: 1,
				  }
				}
			  ]
		  
      });
    });})(jQuery);
</script>
<style>
.regular.slider.slick-initialized.slick-slider {
    max-width: unset;
}
	.hHKXhv {
		position: relative;
		height: 100%;
		padding: 10px;
		border-radius: 6px;
		background: rgba(0, 0, 0, 0.1) linear-gradient(transparent, rgba(0, 0, 0, 0.7)) repeat scroll 0% 0%;
		transition: 0.4s ease-in-out;
		display: flex;
		flex-direction: column;
		justify-content: flex-end;
		font-family: "Open Sans", Helvetica, Arial, sans-serif;
		font-size: 0.9375rem;
		line-height: 1.6;
		font-weight: 400;
		text-rendering: optimizeLegibility;
	}
	.hHKXhv *{
		font-family: "Open Sans", Helvetica, Arial, sans-serif;
		font-size: 13px;
		line-height: 1.6;
		font-weight: 400;
		text-rendering: optimizeLegibility;
	}
	.hHKXhv .fa{
		font-family: FontAwesome;
	}
	.hHKXhv:hover {
		background: rgba(0, 0, 0, 0.7) linear-gradient(transparent, rgba(0, 0, 0, 0.7)) repeat scroll 0% 0%;
		padding-bottom: 20px;
	}
	.event_title {
		font-weight: bold;
		font-size: 20px;
	}
	.regular{
		width: 90%;
		margin: 0 auto;
        height: auto;
	}
	.event_container {
		height: 300px;
		padding: 10px;
	}
	.event_container a {
		text-decoration: none !important;
		height: 100%;
		background-size: cover !important;
		background-repeat: no-repeat !important;
		background-position: center center !important;
		display: block;
		border-radius: 6px;
		color: #fff;
	}
	.slick-arrow:hover{
		opacity:0.7;}	
	.slick-arrow {
		opacity: 1;
		cursor: pointer;
		transition: 0.2s ease-in-out;
	    color: <?php echo get_option('sliderarrowcolo_74839'); ?>!important;
		font-weight: bold;
	}
</style>
			
	<?php

  return ob_get_clean();
}

add_action( 'wp_enqueue_scripts', 'wp_styless' ); 
function wp_styless() {
    wp_register_style( 'fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', array(), '4.2.0' );
    wp_enqueue_style( 'fontawesome' );
}