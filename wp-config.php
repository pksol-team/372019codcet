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
define( 'DB_NAME', 'tecdoc_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'a<%E@uZ06Hd?;<S)NWd^kwX>tzfne3RumY,IKw]$~_LQ4<^ TrX%MY~=L^[4{-kR' );
define( 'SECURE_AUTH_KEY',  ')z*:/$+40}YV]S$,pO3ES=8}LYR/dt6iM7u ?7^GVpE)AeJ3B2G{^@B>h#P1%T0<' );
define( 'LOGGED_IN_KEY',    'w-aUtr!Y4p9]2w8mmBaIdYK8)1fg[zZ9^s,St7h0VL_j?ZA9aFA?<r@)uF/3TEX|' );
define( 'NONCE_KEY',        '5QF*:o*T<K[D#/]u0%m 4#mK.ywx,XF3B.oJ Le.KaqZcn0)Gmx5;jM^LHRW6p39' );
define( 'AUTH_SALT',        'NIfdP.9.~i]2WQ?T(-c,b%a$$r?x<SpIi;``,t!C(FupAl9_j=e>7feh-xofqurX' );
define( 'SECURE_AUTH_SALT', 'D.E7Vk2XI|l,pIA`BzZC~RN.jr-hq/ D<(`Ik.Ok xmAe*7~e?,40_l$&!H<vZ6k' );
define( 'LOGGED_IN_SALT',   '(E%m{F:Dw@OmTN,ONg]kXgN7&$po<qw0RU<tQ`bG:)kN$Ma/`tgARL84`a!rwsO>' );
define( 'NONCE_SALT',       '(+^S}yQ1?[t(5(Jg;%.[ZW(1Ec7Ctv<z2P?!EA)h@}k2C(N-7}*kNpfwxis-wW`r' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
