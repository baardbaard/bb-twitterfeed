<?php

namespace Twitterfeed;

use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;

/**
 * Handles settings and creates a WordPress dashboard settings page where user
 * can enter Twitter API key and secret.
 */
class Settings {

    private $settings_page;
	private $mustache;

	/*
	 * Creates a Settings object with a WordPress Admin settings page.
	 *
	 * @param  Settings_Page $settings_page A reference to the class that
	 *		   needs to be rendered.
	 * @param  Mustache_Engine $mustache A reference to the class that
	 *		   helps with rendering the page.
	 * @return void
	 */
	public function __construct( Settings_Page $settings_page, Mustache_Engine $mustache ) {
		$this->settings_page = $settings_page;
		$this->mustache = $mustache;
	}

	/**
	 * Adds a submenu for this plugin to the 'Tools' menu.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
	}

	/**
	 * Creates the submenu item and calls on the Submenu Page object to render
	 * the actual contents of the page.
	 *
	 * @return void
	 */
	public function add_options_page() {
		add_options_page(
			'BB-Twitterfeed Settings Page',
			'BB-Twitterfeed',
			'manage_options',
			'bb-twitterfeed',
			[ $this, 'render' ]
		);
	}

	/**
	 * Renders the contents of the page associated with the settings that
	 * invokes the render method. In the context of this plugin, this is the
	 * Settings_Page class.
	 *
	 * @return void
	 */
	public function render() {
		echo $this->mustache->render( 'settings', $this->settings_page );
	}

	/**
	 * Returns Twitter API credentials.
	 *
	 * @return array Array containing Twitter API key and secret
	 */
	public function get_credentials() {
		return [
			get_option( 'twitterfeed-key' ),
			get_option( 'twitterfeed-secret' )
		];
	}

}
