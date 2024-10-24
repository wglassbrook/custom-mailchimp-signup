<?php

/**
 *  @package      Mailchimp Signup Form
 *  @author       Wayne Glassbrook/Ciesa Inc. <wayne@ciesadesign.com>
 *  @license      GPL-2.0+
 *  @link         https://ciesadesign.com
 *  @copyright    2024 Wayne Glassbrook/Ciesa Inc.
 *
 *  Plugin Name:  Mailchimp Signup Form
 *  Plugin URI:   https://ciesadesign.com
 *  Description:  A custom Mailchimp signup form using Bootstrap 5.3 with shortcode support.
 *  Version:      1.0.0
 *  Author:       Wayne Glassbrook/Ciesa Inc.
 *  Author URI:   https://ciesadesign.com
 *  License:      GPLv2
 *  License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
 *
 *
 *
 *  Copyright 2024 Wayne Glassbrook/Ciesa Inc. (email : wayne@ciesadesign.com)
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
**/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define Mailchimp API Key and List ID. Replace "get_field()" functions with your key/id.
define('MAILCHIMP_API_KEY', get_field('mailchimp_api_key', 'options'));
define('MAILCHIMP_LIST_ID', get_field('mailchimp_audience_id', 'options'));

// Include necessary files
include_once plugin_dir_path(__FILE__) . 'inc/_functions.php';
include_once plugin_dir_path(__FILE__) . 'inc/_shortcodes.php';

// Enqueue styles and scripts
function custom_mailchimp_enqueue_assets() {
  // Enqueue CSS
  wp_enqueue_style('custom-mailchimp-signup-css', plugin_dir_url(__FILE__) . 'css/custom-mailchimp-signup.css');

  // Enqueue JS
  wp_enqueue_script('custom-mailchimp-signup-js', plugin_dir_url(__FILE__) . 'js/custom-mailchimp-signup.js', ['jquery'], null, true);

  // Localize script for AJAX calls
  wp_localize_script('custom-mailchimp-signup-js', 'mailchimp_ajax', [
      'ajax_url' => admin_url('admin-ajax.php')
  ]);
}
add_action('wp_enqueue_scripts', 'custom_mailchimp_enqueue_assets');
