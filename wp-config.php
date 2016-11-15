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
define('DB_NAME', 'linten32_mmti-stage');

/** MySQL database username */
define('DB_USER', 'linten32_Tenille');

/** MySQL database password */
define('DB_PASSWORD', 'linten32');

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
define('AUTH_KEY',         ' ({(u(&6%,Ts)I1RF7FrduD>#?U}1W>PKB:(RE>shMQG0QP3*PD6@?}lqOO$8vov');
define('SECURE_AUTH_KEY',  'G9l=FXLvv#CsFM#v6,}qxzvf/*RmOH-{G{UaP03[SIYQ$_UqL+Ga9c^Uvbr:S].w');
define('LOGGED_IN_KEY',    '-+72Kv)=7l&rZC.6JAVh/Q*X!:%?7pbaOQ2f9mH2pH?CE6s+6vwv`p/yfkmj]Sc<');
define('NONCE_KEY',        'Fnflm=2S&gq576R6e[&r0r,<{GOREeI_ 2,GdMjYY>fyHuBS3,.3.VC1*?$#qF;O');
define('AUTH_SALT',        'Qu<U`cmQ+uC}@yC3IFg**HH(pP5|Za)Z1 N&$1h,+-2NmZ,B[?0DFIpC-C*Fc_n3');
define('SECURE_AUTH_SALT', 'u3o)9yw?}jy[H!m!5mL!eqcJtVGT&N%si~$P1c1q=+QjBX`6pD/^i)#:?K-+OGe$');
define('LOGGED_IN_SALT',   'J`b1;2X;_.#|7uI%_9}XsBOK+@zuH>~}FQr$r 4lU}U}:;ykEy..XX[7|#IOb&Li');
define('NONCE_SALT',       'v</s,bUyud)lo)ZOEc.O9j,3 jH1,m-qkyu8bN`pz(;KGI/t/<iR7lzYp8-3|!B0');

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
