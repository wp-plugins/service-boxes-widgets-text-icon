<?php
/**
   * Service Boxes Widgets Text Icon when the plugin is uninstalled.
   *
   * @package   service_boxes_widget_text_icon
   * @author    Mahabub Masan <m.manik01@gmail.com>
   * @license   MIT License
   * @link      http://bdwebteam.com/
   * @copyright 2015 Mahabub Hasan
 */

// If uninstall, not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Delete plugin settings
delete_option( 'service_boxes_widget_text_icon' );
delete_site_option( 'service_boxs_widget_text_icon' );