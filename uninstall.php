<?php
/**
 * @package    plugin-base-wpPwa
 */
/*
		@wordpress-plugin
		Version:           1.0.0
		Author:            mariolafuente.com
		Author URI:        mariolafuente.com
		License:           GPL-2.0+
		License URI:       http://www.gnu.org/licenses/gpl-2.0.txt

		Copyright YEAR PLUGIN_AUTHOR_NAME (email : admin@mariolafuente.com)
		(Plugin Name) is free software: you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation, either version 2 of the License, or
		any later version.

		(Plugin Name) is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
		GNU General Public License for more details.

*/
// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}


//Clear via wp
// $books = get_posts( array( 'post_type' => book, 'numberposts'=> -1) );
// foreach ($books as $book) {
// wp_delete_post( $book->ID, true);
// }

//Cler Database via SQL
// global $wpdb;
// $wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'book");
// $wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT if FROM wp_posts)" );$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT if FROM wp_posts)" );