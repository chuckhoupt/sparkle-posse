<?php
/*

Sparkle Posse Configuration

The only required configuration parameter is log_glob_pattern. The default below is
for a typical plain vanila Apache webhost setup (such as on OS X Server). The exact glob
pattern will depend on your server/webhost and log-rotation setup.

Sparkle Posse uses the glob pattern to z-grep the logs for Sparkle profile checks.
In a shell, you can test your glob pattern the same way in order to check that the
glob lists at least 7 days:

% zgrep Sparkle /my-log-path/access.*

Log glob patterns for common WebHosts:

DreamHost:

$user = 'me';
$host = 'example.com';
$log_path = "/home/$user/logs/$host/http";
$config['log_glob_pattern'] = "$log_path/access.log.2* $log_path/access.log";

*/

/*
 * Required Log glob pattern:
 *	     log_glob_pattern - a glob pattern to feed to zgrep to extract 1-4 weeks of logs.
*/
$config['log_glob_pattern'] = "/var/log/apache2/access_log*";

/*
 * Optional Shepard Fairey style "André the Giant Has a Posse" parody sticker:
 *   appIcon - URL of large (256px+) app icon to be rendered xerox-style in the sticker.
 *   ringName - Optional 3-line ring-name (wrestling alias) for app.
 *              (Use non-break spaces for indenting)
*/
//$config['appIcon'] = "Sparkle.png";
//$config['ringName'] = ["Sparke", "   the", "Updater"];

/*
 * Optional Server-side GeoIP support:
 *   geoip_city_db - path to MaxMind's GeoIP2 database
 *
 * Note: requires GeoIP2 package and DB. See https://github.com/maxmind/GeoIP2-php
*/
//$config['geoip_city_db'] = "/usr/local/var/GeoIP/GeoLite2-City.mmdb";
