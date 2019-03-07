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
define('DB_NAME', 'tecdoc_db');

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
define('AUTH_KEY',         'Z}h#Da?[/i]1VigM3z q-p}5rhTZ%UaDNg]gJ~Al1Q,e`+/GhGGB0>hU4RcJ$Hjp');
define('SECURE_AUTH_KEY',  'QEno;lk){Hawg6(/_3+Qbk+7DqcNawr=k+]zYTkO*sl[ogW6RZ&?pT_$E5LdMI*e');
define('LOGGED_IN_KEY',    'z<$LG6yq5z+OhBTZ!UGN~<^SU0PUif]wx,IxF9y)f),|92%ejS:W+XFksYa=PCL_');
define('NONCE_KEY',        '-TVaF:7q%C+x>bTvG*nl]YdT&3<VnPDo-*Uj p<?Bq!}$?;Cs-:Sql@.GGw;ur$+');
define('AUTH_SALT',        '&wM-S*!FY7|#VHrh@&D0C@sr3[W?xJE$ oq~qJ*u!H!;,5OF(xz9+T=yBw(/9n<h');
define('SECURE_AUTH_SALT', 'IOEz!xr=mr2k2qCFYOOMry@|8Z]/<>yoqw<6o>5</ZNh72/0Avt.ye,0x5Q~gwiU');
define('LOGGED_IN_SALT',   '+F+)ryKM`)`KD&q*9U$rwQMY`SG[#?%fcGCook2B!f.,~Qd:i{^ZCN;@!NXo4AGY');
define('NONCE_SALT',       '2//(6j;p-V(.VR@3l[SKj0jI3~3Etku*w_e>vM) %_P?bQ<Vz_5dlN;ydM,SkuwH');

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
