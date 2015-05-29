<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

date_default_timezone_set("UTC");

// 
$default_mode = 'weekly';
$default_template = 'posse';

//$default_mode = 'regulars';

//TODO check for autoload, and give decent message

require_once 'vendor/autoload.php';
require_once 'Profile.php';

if (file_exists('config.php')) {
	require_once 'config.php';
	if (!isset($config)) {
		exit("Error: log_glob_pattern not defined in config.php");
	}
} else {
	// Demo config
	$config = [
		'demo' => true,
		'members' => Profile::studio(),
		'appIcon' => "Sparkle.png",
		'ringName' => [
			"Sparkle",
			"   the",
			"Updater"
		],
	];
}

$m = new Mustache_Engine;

$mode = isset($_GET["mode"]) ? $_GET["mode"] : $default_mode;
$template = isset($_GET["template"]) ? $_GET["template"] : $default_template;

if (!isset($config['members'])) {

	// Sanity check glob pattern
	exec("ls " . $config['log_glob_pattern'] . " 2>&1", $lsoutput, $lsexitcode);
	if ($lsexitcode != 0) {
		echo("log_glob_pattern sanity check:<BR>" . implode('<BR>', $lsoutput) . "<BR>");
		exit("Error: file matching problem in log pattern: " . $config['log_glob_pattern']);
	}

	// Extract the profiles -- zgrep does all the heavy lifting
	exec("zgrep --no-filename 'osVersion=.*Sparkle/[0-9].*' " . $config['log_glob_pattern'], $output, $exitcode);
	if ($exitcode > 1) exit("Error: zgrep-ing failed with log pattern: " . $config['log_glob_pattern']);
	//print_r($output);	

	$profiles = [];

	foreach ($output as &$line) {
		preg_match('/^([\d\.]+).*\[(.*)\].*xml\?([^ ]+)/', $line, $match);
		parse_str($match[3], $p);
		$p["ip"] = $match[1];
		$p["time"] = strtotime($match[2]);
		$profiles[] = new Profile($p);
	}
	//print_r($profiles);


	switch ($mode) {
	case 'regulars':
	// filter to regulars
		$observed = array();
		foreach ($profiles as &$p) {
			$pi = clone $p;
			unset($pi->time);
			$pi = implode(":", (array)$pi);
			if (!array_key_exists($pi, $observed)) {
				$observed[$pi] = $p;
				$observed[$pi]->count = 1;
			} else if ($p->time > $observed[$pi]->time + 7*24*60*60) {
				$observed[$pi]->count += 1;
			}
		
			// Always update the time
			$observed[$pi]->time = $p->time;
		}
	//print_r($observed);
		function multicount($o) { return $o->count > 1; }
		$profiles = array_filter($observed, "multicount");
	//print_r($profiles);
		break;
	case 'weekly':
		$now = time();

		function weekling($p) {
			global $now;
			return $p->time > $now - 7 * 24 * 60 * 60;
		}
		function dayling($p) {
			global $now;
			return $p->time > $now - 24 * 60 * 60;
		}
	
		$profiles = array_filter($profiles, "weekling");
		break;
	}

	function rtime($a, $b) {
		return $a->time == $b->time ? 0 : ($a->time > $b->time ? -1 : 1);
	}

	// Sort with most recent first
	usort($profiles, "rtime");
	//print_r(count($profiles));
	$config['members'] = $profiles;
}

// When GeoIP is configured, lookup info on server
if (isset($config['geoip_city_db'])) {
// TODO check for GeoIP2 package and suggest installing
	$g = new GeoIp2\Database\Reader($config['geoip_city_db']);

	foreach ($config['members'] as &$p) {
		try {
			$r = $g->city($p->ip);

			$p->geo = [
				"city" => $r->city->name,
				"region" => $r->mostSpecificSubdivision->isoCode,
				"regionName" => $r->mostSpecificSubdivision->name,
				"country" => $r->country->name,
				"countryCode" => $r->country->isoCode,
				"zip" => $r->postal->code,
				"continent" => $r->continent->name,
				"lat" => $r->location->latitude,
				"lon" => $r->location->longitude,
				"timezone" => $r->location->timeZone,
			];
		} catch (Exception $e) {
			$p->geo = ["city" => "", "region" => "", "regionName" => "",
				"country" => "", "countryCode" => "", "zip" => "",
				"continent" => "", "lat" => "",	"lon" => "", "timezone" => "",];
		}
		
		// Generate a short summary
		$d = array();
		if ($p->geo['city']) $d[] = $p->geo['city'];
		if ($p->geo['countryCode'] == 'US' && $p->geo['region']) $d[] = $p->geo['region'];
		$d[] = count($d) ? $p->geo['countryCode'] : $p->geo['country'];
		$summary = implode(", ", $d);
		if (! $summary) $summary = "Earth";
		$p->geo['summary'] = $summary;
	}
}

// If needed, set appName based on first member appName
if (!isset($config['appName'])) {
	$firstp = reset($config['members']);
	$config['appName'] = $firstp ? $firstp->appName : "No detected";
}

if (!isset($config['ringName'])) {
	$config['ringName'] = [$config['appName'], "", ""];
}

echo $m->render(file_get_contents($template . ".html"), $config);
