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

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'store_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         '5}uMIFu]u-U6hWVNnc!M|#g v<p*m2#3!=7JxpR5]<o,:_& wnQ-cVXm_ q?dBCs' );
define( 'SECURE_AUTH_KEY',  '*UQ2ggSt/h8;=4C}5#KwqIesR?mw2&-X)TW#fTrJrsLd[7HM$V<N^tfd1~V<wNqQ' );
define( 'LOGGED_IN_KEY',    'HEa$2s9;&.gi;1!3 TYj87Lb$Y}b}F3/_}$gsB<zOLYow|}rUp[97q(?(xhY]:Aw' );
define( 'NONCE_KEY',        'JZP%r!&A >rq b? BB:#rFqg,vs1MAsq,#6`2Gld}VTfoDqe}RGF8lB}.OBxs|X ' );
define( 'AUTH_SALT',        '57Tp]04&,G47`qFYBWq1qz.?=stnym]yJB}IGh+>2P,oc_ZWyU0fE#hvQmrNpPe#' );
define( 'SECURE_AUTH_SALT', '%q18y E)p@1(D21qOuYD8,R3D H4c*c(AB7GHBCA.eLG~Z(}m|[!O3dlI+BnDp6&' );
define( 'LOGGED_IN_SALT',   'Wu:df_3m;n5!GD>yb(*m8(TW1+cL(l=CB^O?_fx(4ams{jvWa r3VJYPJa`#di[$' );
define( 'NONCE_SALT',       'KqTi}vF4k4l/I+=NW@vIM/[q~a2a:kH0N=(z-kwa*jlr?Fz%nZaSfEV;U1+/Uqy;' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

define ('CONCATENATE_SCRIPTS', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
