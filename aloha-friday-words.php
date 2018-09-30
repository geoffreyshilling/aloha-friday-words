<?php
/*
Plugin Name:       Aloha Friday Words
Description:       Easily share a weekly Hawaiian word and its definition.
Plugin URI:        https://geoffreyshilling.com/aloha-friday-words/
Contributors:      geoffreyshilling
Author:            Geoffrey Shilling
Author URI:        https://geoffreyshilling.com/aloha-friday-words/
Donate link:       https://paypal.me/geoffreyshilling
Version:           0.1.0
Stable tag:        0.1.0
Requires at least: 4.5
Tested up to:      4.9.9
Text Domain:       aloha-friday-words
Domain Path:       /languages
License:           GPL v2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.txt

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 
2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
with this program. If not, visit: https://www.gnu.org/licenses/
*/

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin Constants
// Plugin version.
if ( ! defined( 'ORD808AF_VERSION' ) ) {
	define( 'ORD808AF_VERSION', '0.1.0' );
}

// Plugin directory.
if ( ! defined( 'ORD808AF_PLUGIN_DIR' ) ) {
    define( 'ORD808AF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// Include dependencies
require_once ORD808AF_PLUGIN_DIR . 'admin/aloha-friday-cpt-defaults.php';

require_once ORD808AF_PLUGIN_DIR . 'includes/aloha-friday-activation.php';
require_once ORD808AF_PLUGIN_DIR . 'includes/post-types.php';

require_once ORD808AF_PLUGIN_DIR . 'public/aloha-friday-cpt-display.php';









































































