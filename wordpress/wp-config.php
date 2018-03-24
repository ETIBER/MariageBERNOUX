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
define('DB_NAME', 'mariagedb');

/** MySQL database username */
define('DB_USER', 'ebernoux');

/** MySQL database password */
define('DB_PASSWORD', '=4[S9|T)BJfM');

/** MySQL hostname */
define('DB_HOST', 'wordpressdb.cab8s8wltgv7.eu-west-3.rds.amazonaws.com');

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
define('AUTH_KEY',         'm%lF!uL:Lx8 WJzf,Y3/KSC9t8*I(;;iSh@)JA]a;^oI$Yj2vY.J3]^1fn!Wk|Y`');
define('SECURE_AUTH_KEY',  'VDB7~+(iBUjETWlq:qupoJ]63u[u9;~g`@<-,^]B=VzFxt}l42]?IEKI}sy+G{qI');
define('LOGGED_IN_KEY',    'HbP&HccPg^BdyUho:ipIsX2[%F0aK[7}J;/Q{gy8CI/_4R;L^wb`CR$W[rl0F!Uq');
define('NONCE_KEY',        'n~a:<|WDHvZH!=lf%cAxZ#<Iv@(Q%G{/F5.f5VqWAy5$7d!<GhgFPTD8@I**;C@a');
define('AUTH_SALT',        '9rXE;0HgMC.xi#D|3B:DYOxp]=@g9|_546J^yed?#RYVqF*S{T?1uh{u&MkH+=pt');
define('SECURE_AUTH_SALT', 'U,p=b^s:)E{)LFhlNp3(=w29T+.F:Cq4lkVXp<m_6w3&/eE^IN~j#[XI]%2f1.(u');
define('LOGGED_IN_SALT',   'H4pk<u6R,?X%{B8<cl^&<W]g1/MSaoAgGHdGo~wcN?@JeYM[ymjg373&)*p`2,lf');
define('NONCE_SALT',       '`{NX8N+- |+<:0)0CU{PcK)c@JB#P JW5U?E?Cr(p}6mqfB2PkuLeW/&45O7ozFf');

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
