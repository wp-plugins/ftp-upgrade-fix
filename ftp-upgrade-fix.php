<?php
/*
Plugin Name: FTP Upgrade Fix
Plugin URI: http://johnford.is/fixing-errors-when-upgrading-wordpress-via-ftp/
Description: Fixes problems that prevent installing or upgrading WordPress, themes, and plugins on some FTP server configurations (typically Pure-FTPd). A permanent patch is planned for WordPress 3.2 and this plugin should be obsolete after upgrading to that version. To get started: 1) Click the "Activate" link to the left of this description, 2) Upgrade WordPress, themes, or plugins through the WordPress admin.
Version: 1.0
Author: John Ford
Author URI: http://johnford.is/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

function fuf_should_run() {
	global $wp_version;

 	return version_compare( $wp_version, '3.2', '<' );
}

// let the user know if they don't need the plugin any longer
function fuf_admin_notice() {
	if ( fuf_should_run() )
		return;

	global $wp_version;
	echo '<div id="uf-notice" class="updated fade"><p>' . sprintf( __( 'You are running WordPress %s which doesn\'t need the <strong>FTP Upgrade Fix</strong> plugin. You can <a href="%s">deactivate and delete</a> the plugin.' ), $wp_version, admin_url( 'plugins.php' ) ) . '</p></div>';
}
add_action( 'admin_notices', 'fuf_admin_notice' );

// use our custom filesytem if needed
function fuf_filesystem_method( $method, $args ) {
	if ( 'ftpext' == $method && fuf_should_run() && !empty( $args ) )
		return 'ftpext_fix';

	return $method;
}
add_filter( 'filesystem_method', 'fuf_filesystem_method', 10, 2 );

// use our custom filesystem file if needed
function fuf_filesystem_method_file( $file, $method ) {
	if ( 'ftpext_fix' == $method  && fuf_should_run() )
		return dirname( __FILE__ ) . '/class-wp-filesystem-ftpext-fix.php';

	return $file;
}
add_filter( 'filesystem_method_file', 'fuf_filesystem_method_file', 10, 2 );
