<? 

// Configuration

$appLogo = "XynkBetaHasAPosse.png";

$appLogo = "Validator-SAC.png";

// 
//$appLogoClass="double-size";

$log_path = "demo-logs";
// $log_path = "~/logs/xynkapp.com/http";

$log_glob_pattern = "$log_path/access.log.2* $log_path/access.log";

// 
$default_mode = 'weekly';
$default_template = 'posse';

//$default_mode = 'regulars';

// Code

require 'Profile.php';

require 'Mustache/Autoloader.php';
Mustache_Autoloader::register();

date_default_timezone_set("UTC");

$m = new Mustache_Engine;

$mode = isset($_GET["mode"]) ? $_GET["mode"] : $default_mode;
$template = isset($_GET["template"]) ? $_GET["template"] : $default_template;

exec("zgrep --no-filename 'osVersion=.*Sparkle/\d.*' " . $log_glob_pattern, $output);
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
	return $a->time == $b->time ? 0 : ($a->time < $b->time ? -1 : 1);
}

usort($profiles, "rtime");
//print_r(count($profiles));

$firstp = reset($profiles);
$appName = $firstp->appName;

$d = [
	regulars => ($mode == "regulars"), 
	appName => $firstp->appName,
	members => $profiles
];
//print_r($d);

echo $m->render(file_get_contents($template . ".html"), $d);



?>