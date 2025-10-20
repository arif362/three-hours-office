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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '1:ZxhU%QEa$W-8]*7(jIA(%>vq$L^_%B%WqjQ<^hStS%&SCug,xp@!@zh/5;`Zj5' );
define( 'SECURE_AUTH_KEY',   '}8DYx$H+%+a=EMdw7;-11[%#[:]eFRWhM$T#O_pOfq`e3),o#R8Eu$bmmF[g3yCG' );
define( 'LOGGED_IN_KEY',     '+V|#kG;+12{dg26?(Ay+?yUZ@=1Tqxcq/ME )U[1)Au0]][i:O~QxRJL0Bog_UrK' );
define( 'NONCE_KEY',         'Vm;SpSRSR=0bG#;e9j)K#+Y|z(}Px%dAn$3e|ry+Q$:$<?J/E-u;&T<aK)+/aks%' );
define( 'AUTH_SALT',         'vH!rEx{(mdn@d(:F@D)f1)!V)f&aXd7k?S4XhfoC<c=C~}a9I{Q1{W}Xp$c[$FZb' );
define( 'SECURE_AUTH_SALT',  '6JpcPcYPVOsZ|5!P)ANSi?s8.+x!X89QaI/Y/V=yp69L&e$P+ldomBIk&.Ph5mrK' );
define( 'LOGGED_IN_SALT',    ']LG1?/!];~%h]B5A|2]Pi*f*O|&r&yY59!Rl}pzT`_E9G7u6g7agLh{ rwxHQu-v' );
define( 'NONCE_SALT',        '*<*7Pe}KS]{w&mJS)0mJTq8,|4h72IP}92Y2yxzXDCZ+-=TNg?a7x/evxI0PTIC^' );
define( 'WP_CACHE_KEY_SALT', 'Qx<Rg~!:URS#uEt~Yh]JtDIZPk6P!Y]mk#6mZ7OvX`kT_W,aB73}##<+!bg%~;v:' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
