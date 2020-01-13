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
define( 'DB_NAME', 'derinwebsite_db' );

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
define( 'AUTH_KEY',         'f},K)]?ciz^x?P(!JB^}y{echOA9|T3Z=@.jt9!1>K;lWr/oZH5$_O-t6559~[Nv' );
define( 'SECURE_AUTH_KEY',  'Ey8FTO-~c=_;j,%Va=H;,%:<V]+OeS]U+~8I}8S`VMj;{6!(JlAA$y]=!^CbI&l,' );
define( 'LOGGED_IN_KEY',    ')`F{A+`*@Ib+K=oHN0G%pTC}y`Kanns,DTe:6[16,F*AZT=H5M9kJ[/|;:q~n7`c' );
define( 'NONCE_KEY',        'O9~;R^xu,zMnC];Nfin.Be5afqDI1TG26V6^P_#!:SD^*qjMywnUXdDaffEH]-%6' );
define( 'AUTH_SALT',        'OK+x]Z@Tj3i]Y2N1*Ui?$TxN|5?h_wqUe1S#_M%:~MaS`^NPA&gGTN@b+*Y0wcz%' );
define( 'SECURE_AUTH_SALT', 'N`9f/e#/#sCK},%n$w_k.k4fy0(+!&|<j-^Yqc`P`zCM,O?0NOY+Jh:D&3?y}Jg@' );
define( 'LOGGED_IN_SALT',   '9()6YkN$Tb>n^AhdjqaNPlnLQ).f9,>!a7FV%tz3`cV^OcqG*.o;uSQ=?qf?Tic8' );
define( 'NONCE_SALT',       '7x8Pc4/[iG2<6qO6Z#6Ssa>>Wq3iJ4U?D>cA;w]L}u,zi}f;O|[32<dlMw3)l xK' );

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
