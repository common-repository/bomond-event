<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://webnauts.pro/
 * @since      1.0.0
 *
 * @package    Bomondevent
 * @subpackage Bomondevent/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Bomondevent
 * @subpackage Bomondevent/includes
 * @author     Webnauts <info@webnauts.pro>
 */
class Bomondevent {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Bomondevent_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'bomondevent';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Bomondevent_Loader. Orchestrates the hooks of the plugin.
	 * - Bomondevent_i18n. Defines internationalization functionality.
	 * - Bomondevent_Admin. Defines all hooks for the admin area.
	 * - Bomondevent_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bomondevent-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bomondevent-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-bomondevent-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-bomondevent-public.php';

		$this->loader = new Bomondevent_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Bomondevent_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Bomondevent_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Bomondevent_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Bomondevent_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Bomondevent_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
/* Bomond Settings Page */
class bomond_Settings_Page {
	function enqueue_scripts( $hook ) {
			wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		add_action( 'admin_footer', array( $this, 'admin_footer_script'), 99 );
	}

	function admin_footer_script(){
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			$('#sliderarrowcolo_74839').wpColorPicker({
	// устанавливает цвет по умолчанию, также цвет по умолчанию
	// из атрибута value у input
	defaultColor: false,
	// функция обратного вызова, срабатывающая каждый раз 
	//при выборе цвета (когда водите мышкой по палитре)
	change: function(event, ui){ },
	// функция обратного вызова, срабатывающая при очистке (сбросе) цвета
	clear: function(){ },
	// спрятать ли выбор цвета при загрузке
	// палитра будет появляться при клике
	hide: false,
	// показывать ли группу стандартных цветов внизу палитры
	// можно добавить свои цвета указав их в массиве: ['#125', '#459', '#78b', '#ab0', '#de3', '#f0f']
	palettes: true
			});
		});
		</script>
		<?php
	}

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'wph_create_settings' ) );
		add_action( 'admin_init', array( $this, 'wph_setup_sections' ) );
		add_action( 'admin_init', array( $this, 'wph_setup_fields' ) );
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts') );

	}
	public function wph_create_settings() {
		$page_title = 'Bomond Events';
		$menu_title = 'Bomond';
		$capability = 'manage_options';
		$slug = 'bomond';
		$callback = array($this, 'wph_settings_content');
		$icon = 'dashicons-admin-settings';
		$position = 4;
		add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $icon, $position);
	}
	public function wph_settings_content() { ?>
	wp_enqueue_script('jquery');
	<script type="text/javascript">
		(function($) {		$(document).ready(function() {

    var select = $('select[multiple]');
    var options = select.find('option');

    var div = $('<div />').addClass('selectMultiple');
    var active = $('<div />');
    var list = $('<ul />');
    var placeholder = select.data('placeholder');

    var span = $('<span />').text(placeholder).appendTo(active);

    options.each(function() {
        var text = $(this).text();
        if($(this).is(':selected')) {
            active.append($('<a />').html('<em>' + text + '</em><i></i>'));
            span.addClass('hide');
        } else {
            list.append($('<li />').html(text));
        }
    });

    active.append($('<div />').addClass('arrow'));
    div.append(active).append(list);

    select.wrap(div);

    $(document).on('click', '.selectMultiple ul li', function(e) {
        var select = $(this).parent().parent();
        var li = $(this);
        if(!select.hasClass('clicked')) {
            select.addClass('clicked');
            li.prev().addClass('beforeRemove');
            li.next().addClass('afterRemove');
            li.addClass('remove');
            var a = $('<a />').addClass('notShown').html('<em>' + li.text() + '</em><i></i>').hide().appendTo(select.children('div'));
            a.slideDown(400, function() {
                setTimeout(function() {
                    a.addClass('shown');
                    select.children('div').children('span').addClass('hide');
                    select.find('option:contains(' + li.text() + ')').prop('selected', true);
                }, 500);
            });
            setTimeout(function() {
                if(li.prev().is(':last-child')) {
                    li.prev().removeClass('beforeRemove');
                }
                if(li.next().is(':first-child')) {
                    li.next().removeClass('afterRemove');
                }
                setTimeout(function() {
                    li.prev().removeClass('beforeRemove');
                    li.next().removeClass('afterRemove');
                }, 200);

                li.slideUp(400, function() {
                    li.remove();
                    select.removeClass('clicked');
                });
            }, 600);
        }
    });

    $(document).on('click', '.selectMultiple > div a', function(e) {
        var select = $(this).parent().parent();
        var self = $(this);
        self.removeClass().addClass('remove');
        select.addClass('open');
        setTimeout(function() {
            self.addClass('disappear');
            setTimeout(function() {
                self.animate({
                    width: 0,
                    height: 0,
                    padding: 0,
                    margin: 0
                }, 300, function() {
                    var li = $('<li />').text(self.children('em').text()).addClass('notShown').appendTo(select.find('ul'));
                    li.slideDown(400, function() {
                        li.addClass('show');
                        setTimeout(function() {
                            select.find('option:contains(' + self.children('em').text() + ')').prop('selected', false);
                            if(!select.find('option:selected').length) {
                                select.children('div').children('span').removeClass('hide');
                            }
                            li.removeClass();
                        }, 400);
                    });
                    self.remove();
                })
            }, 300);
        }, 400);
    });
	
    $(document).on('click', '.selectMultiple > div .arrow, .selectMultiple > div span', function(e) {
        $(this).parent().parent().toggleClass('open');
    });

});})(jQuery);
	

</script>

<style type="text/css">
	
	.selectMultiple {
  width: 400px;
  position: relative;
}
.selectMultiple select {
  display: none;
}
.selectMultiple > div {
  position: relative;
  z-index: 2;
  padding: 8px 12px 2px 12px;
  border-radius: 8px;
  background: #fff;
  font-size: 14px;
  min-height: 44px;
  box-shadow: 0 4px 16px 0 rgba(22, 42, 90, 0.12);
  transition: box-shadow .3s ease;
}
.selectMultiple > div:hover {
  box-shadow: 0 4px 24px -1px rgba(22, 42, 90, 0.16);
}
.selectMultiple > div .arrow {
  right: 1px;
  top: 0;
  bottom: 0;
  cursor: pointer;
  width: 28px;
  position: absolute;
}
.selectMultiple > div .arrow:before, .selectMultiple > div .arrow:after {
  content: '';
  position: absolute;
  display: block;
  width: 2px;
  height: 8px;
  border-bottom: 8px solid #99A3BA;
  top: 43%;
  transition: all .3s ease;
}
.selectMultiple > div .arrow:before {
  right: 12px;
  -webkit-transform: rotate(-130deg);
          transform: rotate(-130deg);
}
.selectMultiple > div .arrow:after {
  left: 9px;
  -webkit-transform: rotate(130deg);
          transform: rotate(130deg);
}
.selectMultiple > div span {
  color: #99A3BA;
  display: block;
  position: absolute;
  left: 12px;
  cursor: pointer;
  top: 8px;
  line-height: 28px;
  transition: all .3s ease;
}
.selectMultiple > div span.hide {
  opacity: 0;
  visibility: hidden;
  -webkit-transform: translate(-4px, 0);
          transform: translate(-4px, 0);
}
.selectMultiple > div a {
  position: relative;
  padding: 0 24px 6px 8px;
  line-height: 28px;
  color: #1E2330;
  display: inline-block;
  vertical-align: top;
  margin: 0 6px 0 0;
}
.selectMultiple > div a em {
  font-style: normal;
  display: block;
  white-space: nowrap;
}
.selectMultiple > div a:before {
  content: '';
  left: 0;
  top: 0;
  bottom: 6px;
  width: 100%;
  position: absolute;
  display: block;
  background: rgba(228, 236, 250, 0.7);
  z-index: -1;
  border-radius: 4px;
}
.selectMultiple > div a i {
  cursor: pointer;
  position: absolute;
  top: 0;
  right: 0;
  width: 24px;
  height: 28px;
  display: block;
}
.selectMultiple > div a i:before, .selectMultiple > div a i:after {
  content: '';
  display: block;
  width: 2px;
  height: 10px;
  position: absolute;
  left: 50%;
  top: 50%;
  background: #4D18FF;
  border-radius: 1px;
}
.selectMultiple > div a i:before {
  -webkit-transform: translate(-50%, -50%) rotate(45deg);
          transform: translate(-50%, -50%) rotate(45deg);
}
.selectMultiple > div a i:after {
  -webkit-transform: translate(-50%, -50%) rotate(-45deg);
          transform: translate(-50%, -50%) rotate(-45deg);
}
.selectMultiple > div a.notShown {
  opacity: 0;
  transition: opacity .3s ease;
}
.selectMultiple > div a.notShown:before {
  width: 28px;
  transition: width 0.45s cubic-bezier(0.87, -0.41, 0.19, 1.44) 0.2s;
}
.selectMultiple > div a.notShown i {
  opacity: 0;
  transition: all .3s ease .3s;
}
.selectMultiple > div a.notShown em {
  opacity: 0;
  -webkit-transform: translate(-6px, 0);
          transform: translate(-6px, 0);
  transition: all .4s ease .3s;
}
.selectMultiple > div a.notShown.shown {
  opacity: 1;
}
.selectMultiple > div a.notShown.shown:before {
  width: 100%;
}
.selectMultiple > div a.notShown.shown i {
  opacity: 1;
}
.selectMultiple > div a.notShown.shown em {
  opacity: 1;
  -webkit-transform: translate(0, 0);
          transform: translate(0, 0);
}
.selectMultiple > div a.remove:before {
  width: 28px;
  transition: width 0.4s cubic-bezier(0.87, -0.41, 0.19, 1.44) 0s;
}
.selectMultiple > div a.remove i {
  opacity: 0;
  transition: all .3s ease 0s;
}
.selectMultiple > div a.remove em {
  opacity: 0;
  -webkit-transform: translate(-12px, 0);
          transform: translate(-12px, 0);
  transition: all .4s ease 0s;
}
.selectMultiple > div a.remove.disappear {
  opacity: 0;
  transition: opacity .5s ease 0s;
}
.selectMultiple > ul {
  margin: 0;
  padding: 0;
  list-style: none;
  font-size: 16px;
  z-index: 1;
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  visibility: hidden;
  opacity: 0;
  border-radius: 8px;
  -webkit-transform: translate(0, 20px) scale(0.8);
          transform: translate(0, 20px) scale(0.8);
  -webkit-transform-origin: 0 0;
          transform-origin: 0 0;
  -webkit-filter: drop-shadow(0 12px 20px rgba(22, 42, 90, 0.08));
          filter: drop-shadow(0 12px 20px rgba(22, 42, 90, 0.08));
  transition: all 0.4s ease, -webkit-transform 0.4s cubic-bezier(0.87, -0.41, 0.19, 1.44), -webkit-filter 0.3s ease 0.2s;
  transition: all 0.4s ease, transform 0.4s cubic-bezier(0.87, -0.41, 0.19, 1.44), filter 0.3s ease 0.2s;
  transition: all 0.4s ease, transform 0.4s cubic-bezier(0.87, -0.41, 0.19, 1.44), filter 0.3s ease 0.2s, -webkit-transform 0.4s cubic-bezier(0.87, -0.41, 0.19, 1.44), -webkit-filter 0.3s ease 0.2s;
}
.selectMultiple > ul li {
  color: #1E2330;
  background: #fff;
  padding: 12px 16px;
  cursor: pointer;
  overflow: hidden;
  position: relative;
  transition: background .3s ease, color .3s ease, opacity .5s ease .3s, border-radius .3s ease .3s, -webkit-transform .3s ease .3s;
  transition: background .3s ease, color .3s ease, transform .3s ease .3s, opacity .5s ease .3s, border-radius .3s ease .3s;
  transition: background .3s ease, color .3s ease, transform .3s ease .3s, opacity .5s ease .3s, border-radius .3s ease .3s, -webkit-transform .3s ease .3s;
}
.selectMultiple > ul li:first-child {
  border-radius: 8px 8px 0 0;
}
.selectMultiple > ul li:first-child:last-child {
  border-radius: 8px;
}
.selectMultiple > ul li:last-child {
  border-radius: 0 0 8px 8px;
}
.selectMultiple > ul li:last-child:first-child {
  border-radius: 8px;
}
.selectMultiple > ul li:hover {
  background: #4D18FF;
  color: #fff;
}
.selectMultiple > ul li:after {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 6px;
  height: 6px;
  background: rgba(0, 0, 0, 0.4);
  opacity: 0;
  border-radius: 100%;
  -webkit-transform: scale(1, 1) translate(-50%, -50%);
          transform: scale(1, 1) translate(-50%, -50%);
  -webkit-transform-origin: 50% 50%;
          transform-origin: 50% 50%;
}
.selectMultiple > ul li.beforeRemove {
  border-radius: 0 0 8px 8px;
}
.selectMultiple > ul li.beforeRemove:first-child {
  border-radius: 8px;
}
.selectMultiple > ul li.afterRemove {
  border-radius: 8px 8px 0 0;
}
.selectMultiple > ul li.afterRemove:last-child {
  border-radius: 8px;
}
.selectMultiple > ul li.remove {
  -webkit-transform: scale(0);
          transform: scale(0);
  opacity: 0;
}
.selectMultiple > ul li.remove:after {
  -webkit-animation: ripple .4s ease-out;
          animation: ripple .4s ease-out;
}
.selectMultiple > ul li.notShown {
  display: none;
  -webkit-transform: scale(0);
          transform: scale(0);
  opacity: 0;
  transition: opacity .4s ease, -webkit-transform .35s ease;
  transition: transform .35s ease, opacity .4s ease;
  transition: transform .35s ease, opacity .4s ease, -webkit-transform .35s ease;
}
.selectMultiple > ul li.notShown.show {
  -webkit-transform: scale(1);
          transform: scale(1);
  opacity: 1;
}
.selectMultiple.open > div {
  box-shadow: 0 4px 20px -1px rgba(22, 42, 90, 0.12);
}
.selectMultiple.open > div .arrow:before {
  -webkit-transform: rotate(-50deg);
          transform: rotate(-50deg);
}
.selectMultiple.open > div .arrow:after {
  -webkit-transform: rotate(50deg);
          transform: rotate(50deg);
}
.selectMultiple.open > ul {
  -webkit-transform: translate(0, 12px) scale(1);
          transform: translate(0, 12px) scale(1);
  opacity: 1;
  visibility: visible;
  -webkit-filter: drop-shadow(0 16px 24px rgba(22, 42, 90, 0.16));
          filter: drop-shadow(0 16px 24px rgba(22, 42, 90, 0.16));
}

@-webkit-keyframes ripple {
  0% {
    -webkit-transform: scale(0, 0);
            transform: scale(0, 0);
    opacity: 1;
  }
  25% {
    -webkit-transform: scale(30, 30);
            transform: scale(30, 30);
    opacity: 1;
  }
  100% {
    opacity: 0;
    -webkit-transform: scale(50, 50);
            transform: scale(50, 50);
  }
}

@keyframes ripple {
  0% {
    -webkit-transform: scale(0, 0);
            transform: scale(0, 0);
    opacity: 1;
  }
  25% {
    -webkit-transform: scale(30, 30);
            transform: scale(30, 30);
    opacity: 1;
  }
  100% {
    opacity: 0;
    -webkit-transform: scale(50, 50);
            transform: scale(50, 50);
  }
}
html {
  box-sizing: border-box;
  -webkit-font-smoothing: antialiased;
}

* {
  box-sizing: inherit;
}
*:before, *:after {
  box-sizing: inherit;
}

body {
  min-height: 100vh;
  font-family: Roboto, Arial;
  color: #000;
  display: flex;
  justify-content: center;
  align-items: center;
}
body .dribbble {
  position: fixed;
  display: block;
  right: 20px;
  bottom: 20px;
  opacity: .5;
  transition: all .4s ease;
}
body .dribbble:hover {
  opacity: 1;
}
body .dribbble img {
  display: block;
  height: 36px;
}

</style>
		<div class="wrap">
			<h1>Bomond Events</h1>
			<p style="font-size: 1.6em;">For display slider use the shortcode <code style="font-size: 1em;">[bomond]</code></p>
			
			<?php settings_errors(); ?>
			<form method="POST" action="options.php">
				<?php
					settings_fields( 'bomond' );
					do_settings_sections( 'bomond' );
					submit_button();
				?>
			</form>
			<script>
				(function($) {		$(document).ready(function() {
				$('.demo-default').selectize({
					plugins: ['bomondevent'],
					persist: false,
					create: true,
					render: {
						item: function(data, escape) {
							return '<div>"' + escape(data.text) + '"</div>';
						}
					},
					onDelete: function(values) {
						return confirm(values.length > 1 ? 'Are you sure you want to remove these ' + values.length + ' items?' : 'Are you sure you want to remove "' + values[0] + '"?');
					}
				});
				})(jQuery)});
				</script>
			
		</div> <?php
	}
	public function wph_setup_sections() {
		add_settings_section( 'bomond_section', '', array(), 'bomond' );
	}
	public function wph_setup_fields() {
		$fields = array(
			array(
				'label' => 'Slider arrow color',
				'id' => 'sliderarrowcolo_74839',
				'type' => 'text',
				'section' => 'bomond_section',
				'placeholder' => '#000',
			),
			array(
				'label' => 'State',
				'id' => 'state_85823',
				'type' => 'multiselect',
				'section' => 'bomond_section',
				'options' => array(
					'Alabama' => 'Alabama',
					'Alaska' => 'Alaska',
					'Arizona' => 'Arizona',
					'Arkansas' => 'Arkansas',
					'California' => 'California',
					'Colorado' => 'Colorado',
					'Connecticut' => 'Connecticut',
					'Delaware' => 'Delaware',
					'Florida' => 'Florida',
					'Georgia' => 'Georgia',
					'Hawaii' => 'Hawaii',
					'Idaho' => 'Idaho',
					'Illinois' => 'Illinois',
					'Indiana' => 'Indiana',
					'Iowa' => 'Iowa',
					'Kansas' => 'Kansas',
					'Kentucky' => 'Kentucky',
					'Louisiana' => 'Louisiana',
					'Maine' => 'Maine',
					'Maryland' => 'Maryland',
					'Massachusetts' => 'Massachusetts',
					'Michigan' => 'Michigan',
					'Minnesota' => 'Minnesota',
					'Mississippi' => 'Mississippi',
					'Missouri' => 'Missouri',
					'Montana' => 'Montana',
					'Nebraska' => 'Nebraska',
					'Nevada' => 'Nevada',
					'New Hampshire' => 'New Hampshire',
					'New Jersey' => 'New Jersey',
					'New Mexico' => 'New Mexico',
					'New York' => 'New York',
					'North Carolina' => 'North Carolina',
					'North Dakota' => 'North Dakota',
					'Ohio' => 'Ohio',
					'Oklahoma' => 'Oklahoma',
					'Oregon' => 'Oregon',
					'Pennsylvania' => 'Pennsylvania',
					'Rhode Island' => 'Rhode Island',
					'South Carolina' => 'South Carolina',
					'South Dakota' => 'South Dakota',
					'Tennessee' => 'Tennessee',
					'Texas' => 'Texas',
					'Utah' => 'Utah',
					'Vermont' => 'Vermont',
					'Virginia' => 'Virginia',
					'Washington' => 'Washington',
					'West Virginia' => 'West Virginia',
					'Wisconsin' => 'Wisconsin',
					'Wyoming' => 'Wyoming',
				),
				'desc' => 'Select which state events to display.',
				'placeholder' => 'all states',
			),
		);
		foreach( $fields as $field ){
			add_settings_field( $field['id'], $field['label'], array( $this, 'wph_field_callback' ), 'bomond', $field['section'], $field );
			register_setting( 'bomond', $field['id'] );
		}
	}
	public function wph_field_callback( $field ) {
		$value = get_option( $field['id'] );
		switch ( $field['type'] ) {
				case 'select':
				case 'multiselect':
					if( ! empty ( $field['options'] ) && is_array( $field['options'] ) ) {
						$attr = '';
						$options = '';
						foreach( $field['options'] as $key => $label ) {
							$options.= sprintf('<option value="%s" %s>%s</option>',
								$key,
								selected($value[array_search($key, $value, true)], $key, false),
								$label
							);
						}
						if( $field['type'] === 'multiselect' ){
							$attr = ' multiple="multiple" ';
						}
						printf( '<select size="50" name="%1$s[]" id="%1$s" %2$s>%3$s</select>',
							$field['id'],
							$attr,
							$options
						);
					}
					break;
			default:
				printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
					$field['id'],
					$field['type'],
					$field['placeholder'],
					$value
				);
		}
		if( $desc = $field['desc'] ) {
			printf( '<p class="description">%s </p>', $desc );
		}
	
	} 
}
new bomond_Settings_Page();

add_shortcode('bomond', 'footag_func');