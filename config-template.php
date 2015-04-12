<?php
// Configuration

$config = [

	/* Required Log glob pattern:
	     log_glob_pattern - a glob pattern to feed to zgrep to extract 1-4 weeks of logs.
	   
	   Patterns for common WebHosts:
	   
	     DreamHost: 
	*/
	'log_glob_pattern' => "/var/log/apache2/access_log*",

	/* Optional "André the Giant has a posse" Parody Sticker:
	     appIcon - Large (256px+) app icon to be rendered xerox-style in the sticker.
	     ringName - Optional 3-line ring-name (wrestling alias) for app.
	*/
	//'appIcon' => "Sparkle.png",
	/*
	'ringName' => [
		"Sparke",
		"   the",
		"Updater"
	],
	*/

	/* Optional Server-side GeoIP support:
	     geoip_city_db - path to MaxMind's GeoIP2 database
	*/
	//'geoip_city_db' => "/usr/local/var/GeoIP/GeoLite2-City.mmdb",

];
