<?php
// Configuration

	/* Required Log glob pattern:
	     log_glob_pattern - a glob pattern to feed to zgrep to extract 1-4 weeks of logs.
	   
	   Patterns for common WebHosts:
	   
	     DreamHost: 
$root_path = explode('/', $_SERVER['DOCUMENT_ROOT']);
$user = $root_path[2]; $host = $root_path[3];
$log_path = "/home/$user/logs/$host/http";
$config['log_glob_pattern'] = "$log_path/access.log.2* $log_path/access.log";

	*/
$config['log_glob_pattern'] = "/var/log/apache2/access_log*";

/*
 * Optional "André the Giant has a posse" Parody Sticker:
 *   appIcon - Large (256px+) app icon to be rendered xerox-style in the sticker.
 *   ringName - Optional 3-line ring-name (wrestling alias) for app.
 *              (Use non-break spaces for indenting) 
*/
//$config['appIcon'] = "Sparkle.png";
//$config['ringName'] = ["Sparke", "   the", "Updater"];

/*
 * Optional Server-side GeoIP support:
 *   geoip_city_db - path to MaxMind's GeoIP2 database
*/
//$config['geoip_city_db'] = "/usr/local/var/GeoIP/GeoLite2-City.mmdb";
