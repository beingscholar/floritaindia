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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'xxplorea_floritaindia' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         'E)rm4_Gu%VpQV&f8O=S4Gn+)%LSX+TaeX4#H-B}Oo1G-%TI@wSO&t7jErDa*D6!)' );
define( 'SECURE_AUTH_KEY',  '2M2DiN!!psAmOqnMOR=XQ2{;)*heAZA; ZpF+{Oq~Gf[!-5#fWk: $M*<VW7}byU' );
define( 'LOGGED_IN_KEY',    '8vx5QUd3~dMsDI/0p8cgKAL)~X1|&(P{k>ZqM4%9CoNE_$/fc@>wtgFKn~ |jA/0' );
define( 'NONCE_KEY',        '@^;?jwCwEX %jTz]ZZwfQ)}QlAyTka`T]c@P(oWB ]??D+P;.AM<iXmsUo9Bs!<~' );
define( 'AUTH_SALT',        '}6 gdFg(gM;R;f(n053n5?_U,vH~^hC-?A{6AFG]I6,9S`uN+cr&F`|W$!b,>!yz' );
define( 'SECURE_AUTH_SALT', 'nkpD`A_}Cb.9j!.EpM?{U>6>)DSjrHK~Dig@CD3xhg1o}49LC:m3a|f:E=U;A7M!' );
define( 'LOGGED_IN_SALT',   'JC+G94Vab:.H]%fU}fiyq:SCm/K ~o}jGcg>W?hT|&MqN.Mhp:&ybU#~^ U`WQ4M' );
define( 'NONCE_SALT',       'M=pt|q8L`~gj2F5 tF$qGP/w=~>OV5h}HWAaqx^3(:uZMJ$[!dam/lh-T/s#7BAj' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'fi_';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

/** Sets up 'direct' method for wordpress, auto update without ftp */
define('FS_METHOD','direct');
