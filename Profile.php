<?php

class Profile {

function __construct($fields = []) {
	foreach ($fields as $key => $value) {
		$this->{$key} = $value;
	}
}

// Derived values

function ramGB() { return floor($this->ramMB/1000); }

function osShortVersion() { return preg_replace('/\.\d+$/', '', $this->osVersion); }

function osInfo() {
	return isset(self::$osInfoMap[$this->osShortVersion()])
	? self::$osInfoMap[$this->osShortVersion()]
	: ["codeName"=>"$this->osVersion", "link"=>""];
}

function cputypeName() { return self::$cputypeMap[$this->cputype]; }

function displayVersion() {
	return isset($this->appShortVersion) ? $this->appShortVersion : $this->appVersion;
}

function modelInfo() {
	return isset(self::$modelInfoMap[$this->model])
		? self::$modelInfoMap[$this->model]
		: ["desc"=>$this->model];
}
function langName() {
	return isset(self::$langNameMap[$this->lang]) ? self::$langNameMap[$this->lang] : $this->lang;	
}

// Descriptive Tables/Maps....

public static $cputypeMap = [
	7 => "Intel"
];

public static $cpu64bitMap = [
	FALSE => "32-bit",
	TRUE => "64-bit"
];

public static $osInfoMap = [
	"10.6" => ["codeName"=>"Snow Leopard", "link"=>"https://en.wikipedia.org/wiki/Mac_OS_X_Snow_Leopard#Release_history"],
	"10.7" => ["codeName"=>"Lion", "link"=>"https://en.wikipedia.org/wiki/Mac_OS_X_Lion#Release_history"],
	"10.8" => ["codeName"=>"Mountain Lion", "link"=>"https://en.wikipedia.org/wiki/OS_X_Mountain_Lion#Release_history"],
	"10.9" => ["codeName"=>"Mavericks", "link"=>"https://en.wikipedia.org/wiki/OS_X_Mavericks#Releases"],
	"10.10" => ["codeName"=>"Yosemite", "link"=>"https://en.wikipedia.org/wiki/OS_X_Yosemite#Releases"],
	"10.11" => ["codeName"=>"El Capitán", "link"=>"https://en.wikipedia.org/wiki/OS_X_El_Capitan#Releases"],
];

// See: https://www.apple.com/osx/specs/
public static $langNameMap = [
	"en" => "English - 英語",
	"en-US" => "U.S. English - 'Merican!",
	"en-CA" => "Canadian English - Eh?",
	"en-GB" => "British English - What Ho!",
	"en-AU" => "Australian English - G'Day!",
	"ja" => "日本語 - Japanese",
	"fr" => "Français - French",
	"de" => "Deutsch - German",
	"de-CH" => "Schwyzerdütsch - Swiss German",
	"es" => "Español - Spanish",
	"it" => "Italiano - Italian",
	"nl" => "Nederlands - Dutch",
	"sv" => "Svenska - Swedish",
	"da" => "Dansk - Danish",
	"no" => "Norsk Bokmål - Norwegian Bokmål",
	"nb" => "Norsk Bokmål - Norwegian Bokmål",
	"fi" => "Suomi - Finnish",
	"zh_TW" => "繁體中文 - Chinese (Traditional)",
	"zh_CN" => "简体中文 - Chinese (Simplified)",
	"ko" => "한국어 - Korean",
	"pt" => "Português (Brasil) - Portuguese (Brazil)",
	"pt_PT" => "Português (Portugal) - Portuguese (Portugal)",
	"ru" => "Pусский - Russian",
	"pl" => "Polski - Polish",
	"cs" => "Čeština - Czech",
	"tr" => "Türkçe - Turkish",
	"hu" => "Magyar - Hungarian",
	"ar" => "العربية - Arabic",
	"ca" => "Català - Catalan",
	"hr" => "Hrvatski - Croatian",
	"el" => "Ελληνικά - Greek",
	"he" => "עברית - Hebrew",
	"ro" => "Română - Romanian",
	"sk" => "Slovenčina - Slovak",
	"th" => "ไทย - Thai",
	"uk" => "Українська - Ukrainian",
	"ms" => "Bahasa Melayu - Malay",
	"id" => "Bahasa Indonesia - Indonesian",
	"vi" => "Tiếng Việt - Vietnamese",
];

public static $modelInfoMap = [
"MacBook1,1" => [		"retina"=>FALSE, 	"proc"=>"Core i1", 	"desc"=>"MacBook 13\""],
"MacBook2,1" => [		"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook 13\""],
"MacBook3,1" => [		"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook 13\""],
"MacBook4,1" => [		"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook 13\""],
"MacBook5,1" => [		"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook 13\""],
"MacBook5,2" => [		"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook 13\""],
"MacBook6,1" => [		"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook 13\""],
"MacBook7,1" => [		"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook 13\""],
"MacBook8,1" => [		"retina"=>FALSE, 	"proc"=>"Core M", 	"desc"=>"MacBook 12\""],

"MacBookAir1,1" => [	"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook Air 13\""],
"MacBookAir2,1" => [	"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook Air 13\""],
"MacBookAir3,1" => [	"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook Air 11\""],
"MacBookAir3,2" => [	"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook Air 13\""],
"MacBookAir4,1" => [	"retina"=>FALSE, 	"proc"=>"Core i5/i7", 	"desc"=>"MacBook Air 11\""],
"MacBookAir4,2" => [	"retina"=>FALSE, 	"proc"=>"Core i5/i7", 	"desc"=>"MacBook Air 13\""],
"MacBookAir5,1" => [	"retina"=>FALSE, 	"proc"=>"Core i5/i7", 	"desc"=>"MacBook Air 11\""],
"MacBookAir5,2" => [	"retina"=>FALSE, 	"proc"=>"Core i5/i7", 	"desc"=>"MacBook Air 13\""],
"MacBookAir6,1" => [	"retina"=>FALSE, 	"proc"=>"Core i5/i7", 	"desc"=>"MacBook Air 11\""],
"MacBookAir6,2" => [	"retina"=>FALSE, 	"proc"=>"Core i5/i7", 	"desc"=>"MacBook Air 13\""],
"MacBookAir7,1" => [	"retina"=>FALSE, 	"proc"=>"Core i5/i7", 	"desc"=>"MacBook Air 13\""],
"MacBookAir7,2" => [	"retina"=>FALSE, 	"proc"=>"Core i5/i7", 	"desc"=>"MacBook Air 13\""],

"MacBookPro1,1" => [	"retina"=>FALSE, 	"proc"=>"Core i1", 	"desc"=>"MacBook Pro 15\""],
"MacBookPro1,2" => [	"retina"=>FALSE, 	"proc"=>"Core i1", 	"desc"=>"MacBook Pro 17\""],
"MacBookPro2,1" => [	"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook Pro 17\""],
"MacBookPro2,2" => [	"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook Pro 15\""],
"MacBookPro3,1" => [	"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook Pro 15\"/17\""],
"MacBookPro4,1" => [	"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook Pro 15\"/17\""],
"MacBookPro5,1" => [	"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook Pro 15\""],
"MacBookPro5,2" => [	"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook Pro 17\""],
"MacBookPro5,3" => [	"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook Pro 15\""],
"MacBookPro5,4" => [	"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook Pro 15\""],
"MacBookPro5,5" => [	"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook Pro 13\""],
"MacBookPro6,1" => [	"retina"=>FALSE, 	"proc"=>"Core i5/i7", 	"desc"=>"MacBook Pro 17\""],
"MacBookPro6,2" => [	"retina"=>FALSE, 	"proc"=>"Core i5/i7", 	"desc"=>"MacBook Pro 15\""],
"MacBookPro7,1" => [	"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"MacBook Pro 13\""],
"MacBookPro8,1" => [	"retina"=>FALSE, 	"proc"=>"Core i5/i7", 	"desc"=>"MacBook Pro 13\""],
"MacBookPro8,2" => [	"retina"=>FALSE, 	"proc"=>"Core i7", 	"desc"=>"MacBook Pro 15\""],
"MacBookPro8,3" => [	"retina"=>FALSE, 	"proc"=>"Core i7", 	"desc"=>"MacBook Pro 17\""],
"MacBookPro9,1" => [	"retina"=>FALSE, 	"proc"=>"Core i7", 	"desc"=>"MacBook Pro 15\""],
"MacBookPro9,2" => [	"retina"=>FALSE, 	"proc"=>"Core i5/i7", 	"desc"=>"MacBook Pro 13\""],
"MacBookPro10,1" => [	"retina"=>TRUE, 	"proc"=>"Core i7", 	"desc"=>"MacBook Pro 15\""],
"MacBookPro10,2" => [	"retina"=>TRUE, 	"proc"=>"Core i5/i7", 	"desc"=>"MacBook Pro 13\""],
"MacBookPro11,1" => [	"retina"=>TRUE, 	"proc"=>"Core i5/i7", 	"desc"=>"MacBook Pro 13\""],
"MacBookPro11,2" => [	"retina"=>TRUE, 	"proc"=>"Core i7", 	"desc"=>"MacBook Pro 15\""],
"MacBookPro11,3" => [	"retina"=>TRUE, 	"proc"=>"Core i7", 	"desc"=>"MacBook Pro 15\""],
"MacBookPro11,4" => [	"retina"=>TRUE, 	"proc"=>"Core i7", 	"desc"=>"MacBook Pro 15\""],
"MacBookPro11,5" => [	"retina"=>TRUE, 	"proc"=>"Core i7", 	"desc"=>"MacBook Pro 15\""],
"MacBookPro12,1" => [	"retina"=>TRUE, 	"proc"=>"Core i5/i7", 	"desc"=>"MacBook Pro 13\""],

"MacPro1,1" => [		"retina"=>FALSE, 	"proc"=>"Xeon", 	"desc"=>"Mac Pro"],
"MacPro2,1" => [		"retina"=>FALSE, 	"proc"=>"Xeon", 	"desc"=>"Mac Pro"],
"MacPro3,1" => [		"retina"=>FALSE, 	"proc"=>"Xeon", 	"desc"=>"Mac Pro"],
"MacPro4,1" => [		"retina"=>FALSE, 	"proc"=>"Xeon", 	"desc"=>"Mac Pro"],
"MacPro5,1" => [		"retina"=>FALSE, 	"proc"=>"Xeon", 	"desc"=>"Mac Pro"],
"MacPro6,1" => [		"retina"=>FALSE, 	"proc"=>"Xeon", 	"desc"=>"Mac Pro"],

"Macmini1,1" => [		"retina"=>FALSE, 	"proc"=>"Core i1", 	"desc"=>"Mac mini"],
"Macmini2,1" => [		"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"Mac mini"],
"Macmini3,1" => [		"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"Mac mini"],
"Macmini4,1" => [		"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"Mac mini"],
"Macmini5,1" => [		"retina"=>FALSE, 	"proc"=>"Core i5", 	"desc"=>"Mac mini"],
"Macmini5,2" => [		"retina"=>FALSE, 	"proc"=>"Core i5", 	"desc"=>"Mac mini"],
"Macmini5,3" => [		"retina"=>FALSE, 	"proc"=>"Core i7", 	"desc"=>"Mac mini"],
"Macmini6,1" => [		"retina"=>FALSE, 	"proc"=>"Core i5", 	"desc"=>"Mac mini"],
"Macmini6,2" => [		"retina"=>FALSE, 	"proc"=>"Core i7", 	"desc"=>"Mac mini"],
"Macmini7,1" => [		"retina"=>FALSE, 	"proc"=>"Core i5/i7", 	"desc"=>"Mac mini"],

"Xserve1,1" => [		"retina"=>FALSE, 	"proc"=>"Xeon", 	"desc"=>"Xserve"],
"Xserve2,1" => [		"retina"=>FALSE, 	"proc"=>"Xeon", 	"desc"=>"Xserve"],
"Xserve3,1" => [		"retina"=>FALSE, 	"proc"=>"Xeon", 	"desc"=>"Xserve"],

"iMac4,1" => [			"retina"=>FALSE, 	"proc"=>"Core i1", 	"desc"=>"iMac 17-20\""],
"iMac4,2" => [			"retina"=>FALSE, 	"proc"=>"Core i1", 	"desc"=>"iMac 17\""],
"iMac5,1" => [			"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"iMac 17-20\""],
"iMac5,2" => [			"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"iMac 17\""],
"iMac6,1" => [			"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"iMac 24\""],
"iMac7,1" => [			"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"iMac 20-24\""],
"iMac8,1" => [			"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"iMac 20-24\""],
"iMac9,1" => [			"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"iMac 20-24\""],
"iMac10,1" => [			"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"iMac 21-27\""],
"iMac11,1" => [			"retina"=>FALSE, 	"proc"=>"Core i5/i7", 	"desc"=>"iMac 27\""],
"iMac11,2" => [			"retina"=>FALSE, 	"proc"=>"Core i3/i5", 	"desc"=>"iMac 21.5\""],
"iMac11,3" => [			"retina"=>FALSE, 	"proc"=>"Core i3-i7", 	"desc"=>"iMac 27\""],
"iMac12,1" => [			"retina"=>FALSE, 	"proc"=>"Core i3-i7", 	"desc"=>"iMac 21.5\""],
"iMac12,2" => [			"retina"=>FALSE, 	"proc"=>"Core i5/i7", 	"desc"=>"iMac 27\""],
"iMac13,1" => [			"retina"=>FALSE, 	"proc"=>"Core i3-i7", 	"desc"=>"iMac 21.5\""],
"iMac13,2" => [			"retina"=>FALSE, 	"proc"=>"Core i5/i7", 	"desc"=>"iMac 27\""],
"iMac14,1" => [			"retina"=>FALSE, 	"proc"=>"Core i5", 	"desc"=>"iMac 21.5\""],
"iMac14,2" => [			"retina"=>FALSE, 	"proc"=>"Core i5/i7", 	"desc"=>"iMac 27\""],
"iMac14,3" => [			"retina"=>FALSE, 	"proc"=>"Core i5/i7", 	"desc"=>"iMac 21.5\""],
"iMac14,4" => [			"retina"=>FALSE, 	"proc"=>"Core i5", 	"desc"=>"iMac 21.5\""],
"iMac15,1" => [			"retina"=>TRUE, 	"proc"=>"Core i5/i7", 	"desc"=>"iMac 27\""],
"iMac16,1" => [			"retina"=>FALSE, 	"proc"=>"Core i5", 	"desc"=>"iMac 21.5\""],
"iMac16,2" => [			"retina"=>TRUE, 	"proc"=>"Core i5", 	"desc"=>"iMac 21.5\""],
"iMac17,1" => [			"retina"=>TRUE, 	"proc"=>"Core i5/i7", 	"desc"=>"iMac 27\""],

"VMware7,1" => [		"retina"=>FALSE, 	"proc"=>"Core i2", 	"desc"=>"VMWare Virtual Machine"],
];

// For demos, generate a list of profiles with all models, OSes, languages and random IPs
public static function studio() {
	function r() { return rand(0,255); }
	
	$modelKeys = array_keys(Profile::$modelInfoMap);
	$osKeys = array_keys(Profile::$osInfoMap);
	$langKeys = array_keys(Profile::$langNameMap);
	$now = time();
	
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
			"appName" => "Sparkle",
			"appVersion"=>"1.1",
			"cpuFreqMHz"=>"2200", "ramMB"=>"16384",
			"ip" => r().".".r().".".r().".".r(),
			"time" => $now
		]);
	}
	
	return $members;
}


}

?>