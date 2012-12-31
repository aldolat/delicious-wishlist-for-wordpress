<?php
/*
 * Delicious Wishlist for WordPress uninstallation
 *
 * @since 0.5
 */


// Check for the 'WP_UNINSTALL_PLUGIN' constant, before executing
if( !defined( 'ABSPATH' ) && !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

// Delete options from the database
delete_option( 'wdw_options' );
delete_option( 'widget_wdw-widget' );
