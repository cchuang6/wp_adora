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
define('DB_NAME', 'wordpress-db');

/** MySQL database username */
define('DB_USER', 'admin');

/** MySQL database password */
define('DB_PASSWORD', 'G3tAd0raD3v');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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

define('AUTH_KEY',         '}>3327g1;lhTM%nU2>M}XuZ}FcoW$dYx$S[H|i6wX$#_o2t<Zgje6:SKk<C ~]jZ');
define('SECURE_AUTH_KEY',  'at+5(fE4n]<Su$U()7Z38kmd*%;*?6F&l=}P(i5dq4t`P/PwA-X+>xzwbm^XTjzb');
define('LOGGED_IN_KEY',    '7|^*}sr+c@YJ}LH2$dQZxz^rEiPITqr=?+^qE>M2hDb`|-;= j-?/-8+t|Fb.A9T');
define('NONCE_KEY',        '5~|3dyEvBl!D~Q(eAm4w$#e|!^j-V%+)Fe@!g#gwD|Tj8C{aIl|aL^^AS^c|tbtc');
define('AUTH_SALT',        'w9y.bC?LZLs}hhwK`05^6+/[zv}|OtX5WIQbcHqr O+tguK=?vQBH{|JhD(m_rpa');
define('SECURE_AUTH_SALT', ']`#-Ag#|~Qk4eTj;EP.#9{YMId#&9g;1` !:w2MgH+2B1+XPs&%2p(,,?k_$_iK0');
define('LOGGED_IN_SALT',   '-sur0,2&cG_.-Cjs{v$=g=iYZDfZ:O4trC.R|KX2E,|I=P!cC0*D hx|4(uEIe!a');
define('NONCE_SALT',       'o#pZ[lCFT$JwP6Txn91<jn2g>KfICEY1qt}l)ScVM->NU6m^mu*)e5j<P2L11)Kt');

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
