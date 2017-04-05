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
define('DB_NAME', 'AuditOne');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'J#?WMW]/G_>/u/zR0S_)yBoQMy{<T!I2xJ)i%&E*Bz=ILCWL#SI}jmj/`2lqFiQL');
define('SECURE_AUTH_KEY',  'U8wPmut0qP[PM46mErGMeJ8XpY>l,O/x1QZV&ynfZ}J|;hLH3Bi-(e1]_v,:Fxw@');
define('LOGGED_IN_KEY',    '}B#FRzL&#FTykvrYN7mv#<71-u6vh#o6aloH_X*E`c9kMXORQr:}{K&YRP)/f]>6');
define('NONCE_KEY',        '5P- @j.cPdO79<d[-dKFH6<CucMj;U Kjb$,|g>$dw!h%TXZW5Xk/D:/=Dp5t[P;');
define('AUTH_SALT',        ':{u{M2(E-d-}#m#jfMo1=~XM^fvTJ!HJHBy^8%kXJsT`!K5d<KzpyF&M8%wf+!IY');
define('SECURE_AUTH_SALT', '@X?H+|RTYx} @IC!Mo}N1R_!}_0WkP4l`T~G)U49Nhu|<tcl}!cXW[B>$Dt2 K(9');
define('LOGGED_IN_SALT',   'l ^g)kTY>`iazpRFU**H4[=oNTPmxqn1alimNjlvHZ==V{ku-WQ&(;:!z03XM+c/');
define('NONCE_SALT',       'RgyU^+u2X7Q3kR^ZRoFE-+T}/- c?;j`#K<bvGhD[JCbZb~A>a,4y_&vH_}T1!4Q');

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
