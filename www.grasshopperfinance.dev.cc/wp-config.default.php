<?php
/**
 * Default config settings
 *
 * Enter any WordPress config settings that are default to all environments
 * in this file.
 * 
 * Please note if you add constants in this file (i.e. define statements) 
 * these cannot be overridden in environment config files so make sure these are only set once.
 * 
 * @package    Studio 24 WordPress Multi-Environment Config
 * @version    2.0.0
 * @author     Studio 24 Ltd  <hello@studio24.net>
 */
  

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
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * Increase memory limit. 
 */
define('WP_MEMORY_LIMIT', '64M');
