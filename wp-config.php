<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// Detect HTTPS reverse proxy (important for cloud environments like Railway)
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', getenv('MYSQLDATABASE') ?: 'authorpad_wp979' );

/** Database username */
define( 'DB_USER', getenv('MYSQLUSER') ?: 'authorpad_wp979' );

/** Database password */
define( 'DB_PASSWORD', getenv('MYSQLPASSWORD') ?: 'tSz(]67pJ9' );

/** Database hostname */
define( 'DB_HOST', getenv('MYSQLHOST') ? (getenv('MYSQLHOST') . ':' . getenv('MYSQLPORT')) : 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'psqhconq8jerr3lvlx5mmhk14nyypzdgf1isl1a7pvhef3npaevphlqscftav7kv' );
define( 'SECURE_AUTH_KEY',  'gohndcmimncneheho4whhp4h9kcdv7b5ewzcdlqkybucy1zgem3ijjrobq9fvul4' );
define( 'LOGGED_IN_KEY',    'duvq21fqeydjmoinbrmhupgamrqzxaul9ajnoz4wd33s431sqmpmqc7cr8cmtzab' );
define( 'NONCE_KEY',        'n0ferr1am702y1dvhetl962vdqpsw22ki8fj0rw5pnmkox1rh6s8kjzqee2ij1ow' );
define( 'AUTH_SALT',        'fzyj5vzmkasapyc7zfwrcmiwvpfop5gavrrwnkdkma7tuewhssbbgrg0cppgcybs' );
define( 'SECURE_AUTH_SALT', 'tjonkc4x70com2mrfntmgq1fpkwbjvp3bbilhq1szczcg2lf9soae4zpff9qibxv' );
define( 'LOGGED_IN_SALT',   'tnwukvlgtri0sjsc9xiqclpziw1qrk4pbs3a0dxvtwhfaslcse4wlp9smf53a45s' );
define( 'NONCE_SALT',       '1gmhougge22s9is2axkogomsx6yj7d8b0eramhwsriyorifx83xlwuawt3d6svmb' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp4m_';

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

/* Add any custom values between this line and the "stop editing" line. */



define('DISABLE_WP_CRON', true);

// Dynamically set Site URL to whatever domain is currently being used
if (isset($_SERVER['HTTP_HOST'])) {
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
    define('WP_HOME', $protocol . $_SERVER['HTTP_HOST']);
    define('WP_SITEURL', $protocol . $_SERVER['HTTP_HOST']);
}
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
