<?php
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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'grassho4_wp105');

/** MySQL database username */
define('DB_USER', 'grassho4_wp105');

/** MySQL database password */
#define('DB_PASSWORD', '0yF9ofwzt7');
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '5arzpioesxdmyv9z9vmklfe5oorenjmr7ljxwotev3cjszgrjbxocge49hxiyxft');
define('SECURE_AUTH_KEY',  'tbxwjte4zvws10b393wscvxrqnev8ip5kwyuq0ljqsxrnldozsheskuxu5qzzdpj');
define('LOGGED_IN_KEY',    'chfgvacl3imo1u3fmbpxugpohlg84esnkpaynpc9lscftha52tczyn9lqyf6c9zy');
define('NONCE_KEY',        'crtyc6hqotercygisdgl3n525vo4mg8lhnrgk81givq8fmwkqvxfpqkhqt9axbnm');
define('AUTH_SALT',        'wzmahbalooq7z9ermvz1ftsztc53c1ocfiyysqid8brhs2prkn382mj1bv9lekqn');
define('SECURE_AUTH_SALT', 'aaate4kvtold2hqmvycurdrydbrsatu5b9tszt7jgno2u1vuujirrexbnwfebbi3');
define('LOGGED_IN_SALT',   'u4jtqtlpo9zteqdsu5l3ghht2zfstvghfh0whzxlfepn62klemz4mzeqbjdhkovj');
define('NONCE_SALT',       'ccisyebmnjhjxnqeuhpuhuy4k3wibbkvl2qijpltg93augr92ex4jckcngm8wzey');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);
define( 'WP_MEMORY_LIMIT', '128M' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

# Disables all core updates. Added by SiteGround Autoupdate:
define( 'WP_AUTO_UPDATE_CORE', false );
