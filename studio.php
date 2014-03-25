<?

require 'Profile.php';

require 'Mustache/Autoloader.php';
Mustache_Autoloader::register();

$m = new Mustache_Engine;


//89.221.172.162 - - [20/Mar/2014:01:35:19 -0700] "GET /download/validator-sac.xml?
//osVersion=10.9.2&cputype=7&cpu64bit=1&cpusubtype=4&model=MacBookPro8,2&ncpu=8&lang=en&appName=Validator%20S.A.C&appVersion=0.10.3&cpuFreqMHz=2200&ramMB=16384 HTTP/1.1" 200 1242 "-" "Validator S.A.C/0.10.3 Sparkle/313" 


$modelKeys = array_keys(Profile::$modelInfoMap);
$osKeys = array_keys(Profile::$osInfoMap);
$langKeys = array_keys(Profile::$langNameMap);

$members = [];

for ($i = 0; $i < count($modelKeys); $i++) {
	$members[] = new Profile([
		"model" => $modelKeys[$i],
		"lang"=> $langKeys[$i % count($langKeys)],
		"osVersion" => $osKeys[$i % count($osKeys)] . ".0",
		"cputype" => "7",
		"cpu64bit" => "1",
		"cpusubtype" => "4",
		"ncpu"=>"8",
		"appName" => "Example",
		"appVersion"=>"1.1",
		"cpuFreqMHz"=>"2200", "ramMB"=>"16384",
		"ip" => r().".".r().".".r().".".r(),
	]);
}
$d = [
	'appName' => 'Example App',
	"members" => $members
];

//print_r($d);

echo $m->render(file_get_contents("posse.html"), $d);

function r() { return rand(0,255); }
?>