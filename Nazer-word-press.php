<?php

/*
Plugin Name: Nazer
Plugin URI: https://github.com/hatamiarash7/Nazer-WordPress
Description: Nazer's Plugin For Your WordPress Website.
Version: 1.0
Author: hatamiarash7
Author URI: http://arash-hatami.ir
License: GPL-3.0
License URI:  https://www.gnu.org/licenses/gpl-3.0.html
*/

class Nazer
{
	public function __construct()
	{
		add_action('admin_menu', array($this, 'create_plugin_settings_page'));
		add_action('admin_init', array($this, 'setup_sections'));
		add_action('admin_init', array($this, 'setup_fields'));
	}

	public function create_plugin_settings_page()
	{
		$page_title = 'Nazer Settings';
		$menu_title = 'Nazer';
		$capability = 'manage_options';
		$slug = 'nazer';
		$callback = array($this, 'plugin_settings_page_content');
		$icon = plugin_dir_url(__FILE__) . 'images/nazer.png';
		$position = 100;

		add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $icon, $position);
	}

	public function plugin_settings_page_content()
	{ ?>
		<div class="wrap">
			<?php if (isset($_GET['settings-updated'])) {
				echo "<div class='updated'><p>Nazer settings updated successfully.</p></div>";
			} ?>
			<h1>Nazer Configuration</h1>
			<form method="post" action="options.php">
				<?php
				settings_fields('nazer');
				do_settings_sections('nazer');
				submit_button();
				?>
			</form>
		</div> <?php
	}

	public function setup_sections()
	{
		register_setting("nazer", "nazer_enable_field");
		register_setting("nazer", "nazer_api_field");
		add_settings_section('status_section', 'Status', array($this, 'section_callback'), 'nazer');
		add_settings_section('key_section', 'Keys', array($this, 'section_callback'), 'nazer');
	}

	public function section_callback($arguments)
	{
		switch ($arguments['id']) {
			case 'status_section':
				echo "Nazer's status";
				break;
			case 'key_section':
				echo 'Keys for configuration your Nazer';
				break;
		}
	}

	public function setup_fields()
	{
		add_settings_field('nazer_enable_field', 'Enable', array($this, 'nazer_enable_field_callback'), 'nazer', 'status_section');
		add_settings_field('nazer_api_field', 'API Key', array($this, 'nazer_api_field_callback'), 'nazer', 'key_section');
	}

	public function nazer_enable_field_callback()
	{
		$html = '<input type="checkbox" id="nazer_enable_field" name="nazer_enable_field" value="1"' . checked(get_option('nazer_enable_field'), 1, false) . '/>';
		echo $html;
	}

	public function nazer_api_field_callback()
	{
		echo '<input name="nazer_api_field" id="nazer_api_field" type="text" value="' . get_option('nazer_api_field') . '" />';
	}
}

new Nazer();
