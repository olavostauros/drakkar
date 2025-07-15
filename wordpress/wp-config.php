<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_db' );

/** Database username */
define( 'DB_USER', 'wp-user' );

/** Database password */
define( 'DB_PASSWORD', '7592' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '.G$AzyOKQj<k{3yC6[E6).Lq(z<y60CNP{VrF~r P,_Irke1`y0<% +!EW{UUc5H');
define('SECURE_AUTH_KEY',  '?n-=GIo4Lbav.wcgvtU,TviE<@?L>)W|+luD5-00i!=~>xXz!d#@{iem837POA3$');
define('LOGGED_IN_KEY',    'vqMz.iZKJY2l?OlwbKDRMT}rcSd:3,{|(-MRz=#pNyF6O_PKQ>Yka`[5Wll5qz,{');
define('NONCE_KEY',        'Zb@ }]e)%yjR!lAD#uYi_3@|`c~Md9e8QB K4MeP}:$hz_vL&_W!Fr{9C~5^!)wR');
define('AUTH_SALT',        'L_A[6vLD`>QX!>fl%dh^M#,Fx?Hm9dhym#Ot^N@~|IHPTA[.@iJg`:tOl.oR+0&W');
define('SECURE_AUTH_SALT', 'RFfde)&It.~4cXI>X9=0>z[X~F@L0nt8LOxo]TZG,|L?RB%S`>+eV7-t$~kT|H+-');
define('LOGGED_IN_SALT',   '6|J|WS!D} Zf$mBk(~ONK?E9FlR|Ti3!@_+&S4E,wAz*]skR6oZ|{;j!5B.jBl2~');
define('NONCE_SALT',       'I[,SnGly<O>0,z`PgXwe6ip`H^bj73{!DBzNm->]!HcSyRX)]c4=y7hI3/!PV8)6');
/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
