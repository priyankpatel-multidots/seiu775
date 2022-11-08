<?php
define( 'WP_CACHE', false ); // By SiteGround Optimizer

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
define( 'DB_NAME', 'db7bs2dmifgeog' );

/** MySQL database username */
define( 'DB_USER', 'u4lxvb7k0n0jy' );

/** MySQL database password */
define( 'DB_PASSWORD', 'g#$3:11Ai32h' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'yPfuT5cYuhWJl9v8hhXKkG/E1uolXKCVQDpAMqhsMR8O3/36D3Yjh8sY7XCIMM3xjapeHp0ceOGW0bErHaIZNQ==');
define('SECURE_AUTH_KEY',  'qjZUgekuH1ObaZ2z9+heZ5r/WOEZ5g7Y3+X2lv/XGrgqj/Bo1WXLjyTThZhr8m0yWgBUqnifIQhLbrwBoD+Cjw==');
define('LOGGED_IN_KEY',    'NAKlU3AhdLRet4f/9TSmWGvD1Jf3YYJElJivt5KqLwBPouhuAxrv085ExFKVKdrxj9j8q4RmIECk1ccDShpJBQ==');
define('NONCE_KEY',        'nJrfrFN/N6FBmEpgXu7vXZdlwha0h27TsebuFR47PQACkUDFaJ/JRAxwgDVaMR53p1/bfcBJrXYN3NDZ019JRg==');
define('AUTH_SALT',        'sGGe3PtW74LCPza6ff0q3gPM36ABwRK4zIsae4lncwGA0PB0ApI/U3CI9tNb4Kc86ZGxMNPJhhQqLzJ5F0oZ/A==');
define('SECURE_AUTH_SALT', 'pEaeVFraYmr5/AQ/QLXuoqDLsRRfUhwcP7J/aeY7N9gru8lCr6rgShLD0PNL9rOa/gMnZUjMMPXxYxF1BKn2Iw==');
define('LOGGED_IN_SALT',   'CrxQ51hY0wLdPoEvg5GRSi7Epr5EjJ2uRwrHxKjQKwtDcjkQ7qczI0Ey6yQPN4/Nt3nge5zQcE8dQOFNDBR9gg==');
define('NONCE_SALT',       '91G1fDxU3vuS/wMfkf0/JtakWQp6vYxw9XHGV//w0+7ZRsSwY94QSfpNvDYcBcJSW13rP6JxgZY5D+BuGUqfVw==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
