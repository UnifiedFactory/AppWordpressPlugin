<?php
/*
Plugin Name: Unified Factory Widget Plugin
Plugin URI: ...
Description: Simple plugin to add Unified Factory wifget to WP page
Version: 1.0
Author: Marcin Babecki
Author URI: ...
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
?>
<?php
class unifiedfactory_widget

	{
	private $options;
	public function __construct()
		{
		add_action('wp_footer', array(
			$this,
			'show_unifiedfactory_code'
		));
		add_action('admin_menu', array(
			$this,
			'add_page'
		));
		add_action('admin_init', array(
			$this,
			'page_init'
		));
		}

	public function show_unifiedfactory_code()
		{
		$this->options = get_option('unifiedfactory');
		echo $this->options['unifiedfactory_script'];
		}

	public function add_page()
		{
		add_options_page('Settings Admin', 'Unified Factory Widget Plugin', 'manage_options', 'unifiedfactory_settings_page', array(
			$this,
			'create_page'
		));
		}

	public function create_page()
		{
		$this->options = get_option('unifiedfactory');
?>
		<div class="wrap">
			<h2>Set Unified Factory Widget Plugin</h2>
			<form method="post" action="options.php">
			<?php
		  settings_fields('unifiedfactory_options');
		  do_settings_sections('unifiedfactory_settings_page');
		  submit_button();
?>
			</form>
		</div>
		<?php
		}

	public function page_init()
		{
		register_setting('unifiedfactory_options', 'unifiedfactory', array(
			$this,
			'sanitize'
		));
		add_settings_section('unifiedfactory_section', 'Unified Factory widget code', array(
			$this,
			'section_callback'
		) , 'unifiedfactory_settings_page');
		add_settings_field('unifiedfactory_script', 'Widget code', array(
			$this,
			'id_number_callback'
		) , 'unifiedfactory_settings_page', 'unifiedfactory_section');
		}

	public function sanitize($input)
		{
		$new_input = array();
		if (isset($input['unifiedfactory_script'])) $new_input['unifiedfactory_script'] = $input['unifiedfactory_script'];
		return $new_input;
		}

	public function section_callback()
		{
		echo 'Paste your widget code to add widget to your page. You\'ll find Unified factory widget code in the settings page inside of Unified Factory Platform <a href="https://app.unifiedfactory.com/settings" target="_blank">https://app.unifiedfactory.com/settings</a>';
		}

	public function id_number_callback()
		{
		if (isset($this->options['unifiedfactory_script'])) $unifiedfactory_script = esc_attr($this->options['unifiedfactory_script']);
		echo '<textarea id="unifiedfactory_script" rows="10" cols="80" name="unifiedfactory[unifiedfactory_script]">' . $unifiedfactory_script . '</textarea>';
		}
	}

$unifiedfactory_settings_page = new unifiedfactory_widget();
?>
