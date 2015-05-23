<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'tier5');

/** MySQL database username */
define('DB_USER', 'wdcdev');

/** MySQL database password */
define('DB_PASSWORD', '$wdc@wp#15');

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
define('AUTH_KEY',         '[yl3jVurzYZrTr~;|Rc5F?i3x[681*+lH54Yu3_oo+@S~7faQL{Qx8.Vol+E;=2Y');
define('SECURE_AUTH_KEY',  'cLo|kkAmlT?Gr.q~-@dQ=ar[XUXb(Gc|AdgX|}Ot5wa^3QphN0RHeXtSlazbAA@d');
define('LOGGED_IN_KEY',    '_{;B[9!G82XQUI8:FefyMQ<6mZ8<wrodKyKw>yd?NR+DTt3KC+g)foqhI/Bc_9<Z');
define('NONCE_KEY',        '-O<8{-CGP-kt5=!t]>Z/8=d60>%!B4GDrMS0pY~R$|;;+$:q)f.Kh5}WP/Rr~7*y');
define('AUTH_SALT',        'Y2@g];k{+^O<o5x28K+2vj%?;R_7VUB MAyf>A;Nizwx>`3}zc}Hq-Y|B8n&>c{)');
define('SECURE_AUTH_SALT', 'Cx0eo~MQR+MVvSYg&BFj[D@y5.JE6&yCA3g=6;.hi/-vQaDf7V4AV*D&=RAZNDD}');
define('LOGGED_IN_SALT',   'LBz`,w&},2&-3JdCy ohEazVJezA{f^;-1-p-u/$4:Y_+8+m/^sI{$vLWj)f^,*q');
define('NONCE_SALT',       'g4v{C)#sVaN5PwA^Z=#^mI=*oek@/CNZ&_%eiIh;OIc=B9hUnH_g:kA<QLb[c<<c');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
