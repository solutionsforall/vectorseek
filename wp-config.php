<?php


 // Added by WP Rocket


define('DISALLOW_FILE_MODS',false);
define('DISALLOW_FILE_MODS',false);
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'zarghamali_wp8291' );
/** MySQL database username */
define( 'DB_USER', 'zarghamali_wp8291' );
/** MySQL database password */
define( 'DB_PASSWORD', '1SX8D3@p2!' );
/** MySQL hostname */
define( 'DB_HOST', 'localhost' );
/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );
/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'flrcs7q3xucchet20emzdiisx2lu8so2p5dlcc9ln0lgxtx0z9lybxwbd4qane1p' );
define( 'SECURE_AUTH_KEY',  'ozbwyjyrlnswfow0h5to2yq3o0hl3bn3o0h4nkf4wuavkow7glso5ocx0kgbayhs' );
define( 'LOGGED_IN_KEY',    'ylstpsyuzfxctfhyhfmnykdfqrwtvhrzdvneosufbtjtgn8h2mx69ik7cc012u0t' );
define( 'NONCE_KEY',        'kusxbyn5r6hobfpniwsvszj13c3iops6abbdgipe0do7eumif1tb976ycpcfitp9' );
define( 'AUTH_SALT',        'hxl5gyheeibm49pnkwav87kzc9xermvptv87fjkjbrafbxzdtsiw7kyily9jhcqt' );
define( 'SECURE_AUTH_SALT', 'xkwi8e1vcf5rceljnoxno1wcs6qqpsqii7sn503dsou2azlj20wxervhtqnviuqg' );
define( 'LOGGED_IN_SALT',   'wz70yattplsc8yuwk5wcalrydfascppummkbusraeqjqndfvifnvlznva6es1pba' );
define( 'NONCE_SALT',       'hicdmjp7iozid6kce1danaycjwgcsdewqzpbm9uhjyuo09z4eilxgmbgarspudp2' );
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpko_';
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );
	
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';