<? 

// Configuration

$app = "";
$appSite = "";
$appLogo = "XynkBetaHasAPosse.png";

$appLogo = "Validator-SAC.png";

$log_path = "demo-logs";
// $log_path = "~/logs/xynkapp.com/http";

$log_glob_pattern = "$log_path/access.log.2* $log_path/access.log";

// 
//$default_mode = 'weekly';
//$default_mode = 'regulars';

?><!DOCTYPE html>
<HTML>
<HEAD>
<META CHARSET="utf-8">
<META NAME="viewport" CONTENT="width=device-width, initial-scale=1">
<TITLE>Validator S.A.C. has a Posse</TITLE>
<SCRIPT SRC="//code.jquery.com/jquery-2.1.0.min.js"></SCRIPT>
<STYLE>
BODY {font: 100%/1.45 sans-serif;}
#logo { height: 160px; width: 160px; float: left; margin: 0 16px 16px 0; }
.member { float: left; position: relative; background-color: #eee; border-radius: 15px; overflow: hidden;
height: 160px; width: 160px; margin: 0 16px 16px 0; font-size: 13px;}
.member .mac { position: absolute; z-index: 10; left: 25%; bottom: 25%; width: 51.25%;}
.member .os { position: absolute;  z-index: 5; top: 0%; right: 0%; width: 44%; }
.member .retina { position: absolute;  top: 30%; right: 0; width: 44%; }
.member .no { display: none; }
.member .version { position: absolute; top: 0; left: 0; width: 38%; height: 38%; text-align: center; line-height: 60px;
font-size: 120%; background-color: white; border-radius: 50%; margin: 3%;}
.member .info { position: absolute; bottom:5%; text-align: center; width: 100%; margin: auto;
overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}

/* For iPhone's, resize to fit 2 members across the screen. */
@media screen and (max-device-width: 480px) {

	BODY { margin-left: 8px; margin-right: 0; }
	.member { height: 148px; width: 148px; margin: 0 8px 8px 0; }

}

</STYLE>
</HEAD>
<BODY>

<H1>Validator-SAC "Regulars" over the last Month</H1>
<P>(A "regular" is defined as 2+ identical weekly profiles collected in last 30 days)</P>

<PRE>
<?

$mode = $default_mode;

$cputype_desc = array (
	7 => "Intel"
);

$cpu64bit_desc = array (
	0 => "32-bit",
	1 => "64-bit"
);

$appVersion_desc = array (
	"692" => "β6",
	"679" => "β5",
	"659" => "β4",
	"629" => "β3"
);

$osShortVersion_link = array (
	"10.6" => "http://en.wikipedia.org/wiki/Mac_OS_X_Snow_Leopard#Release_history",
	"10.7" => "http://en.wikipedia.org/wiki/Mac_OS_X_Lion#Release_history",
	"10.8" => "http://en.wikipedia.org/wiki/OS_X_Mountain_Lion#Release_history",
	"10.9" => "http://en.wikipedia.org/wiki/OS_X_Mavericks#Releases",
);

function appVersionBeta($ver) {
	global $appVersion_desc;
	return isset($appVersion_desc[$ver]) ? $appVersion_desc[$ver] : $ver;
}

function hasRetinaDisplay($model) {
	$retinaModels = array (
		"MacBookPro10,1" => TRUE,
		"MacBookPro10,2" => TRUE,
		"MacBookPro11,1" => TRUE,
		"MacBookPro11,2" => TRUE,
		"MacBookPro11,3" => TRUE,
	);
	
	return isset($retinaModels[$model]) ? "yes" : "no";
}

	exec("zgrep --no-filename 'osVersion.*Sparkle' " . $log_glob_pattern, $output);
//print_r($output);	

date_default_timezone_set("UTC");

	foreach ($output as &$line) {
		preg_match('/^([\d\.]+).*\[(.*)\].*xml\?([^ ]+)/', $line, $match);
		parse_str($match[3], $p);
		$p["ip"] = $match[1];
		$p["time"] = strtotime($match[2]);
		$profiles[] = $p;
	}
//print_r($profiles);


switch ($mode) {
case 'regulars':
// filter to regulars
	$observed = array();
	foreach ($profiles as &$p) {
		$pi = $p;
		unset($pi["time"]);
		$pi = implode(":", $pi);
		if (!array_key_exists($pi, $observed)) {
			$observed[$pi] = $p;
			$observed["count"] = 1;
		} else if ($p["time"] > $observed[$pi]["time"] + 7*24*60*60) {
			$observed[$pi]["count"] += 1;
		}
		
		// Always update the time
		$observed[$pi]["time"] = $p["time"];
	}
	
	function multicount($o) { return $o["count"] > 1; }
	$profiles = array_filter($observed, "multicount");
//print_r($profiles);
	break;
case 'weekly':
default:
	$now = time();

	function weekling($p) {
		global $now;
		return $p["time"] > $now - 7 * 24 * 60 * 60;
	}
	function dayling($p) {
		global $now;
		return $p["time"] > $now - 24 * 60 * 60;
	}
	
	$profiles = array_filter($profiles, "weekling");
	break;
}
//print_r(count($profiles));
?>
</PRE>

<DIV ID="grid">
<IMG ID="logo" SRC="<?= $appLogo ?>">


<?
	foreach ($profiles as &$p) :
		extract($p);
		
//		$ipname = preg_replace('/^.*\.([^\.]+\.[^\.]+\.[^\.]+\.[^\.]+)$/', '$1',  gethostbyaddr($ip));
 $ipname = $ip;
		$osShortVersion = preg_replace('/\.\d+$/', '', $osVersion);
?>

<DIV CLASS="member">
	<!-- <A HREF="https://cortex.bcybernetics.com/websvn/log.php?repname=bc&path=%2FXynk%2F&isdir=1&showchanges=1&sr=<?= $appVersion ?>&er=1&max=40&search="> -->
	<A HREF="http://habilis.net/validator-sac/#<?= $appVersion ?>">
		<DIV CLASS="version" TITLE="<?= $appVersion ?>"><?= appVersionBeta($appVersion) ?></DIV>
	</A>
	<A HREF="http://www.everymac.com/ultimate-mac-lookup/?search_keywords=<?= $model ?>">
		<IMG CLASS="mac" SRC="mac/<?= $model ?>.png" TITLE="<?= $model ?>">
	</A>
	<A HREF="<?= $osShortVersion_link[$osShortVersion] ?>">
		<IMG CLASS="os" SRC="os/<?= $osShortVersion ?>.png" TITLE="<?= $osVersion ?>">
	</A>
	<IMG CLASS="retina <?= hasRetinaDisplay($model) ?>" SRC="retina-icon.png" TITLE="retina">
	<DIV CLASS="info">
		<?= $cputype_desc[$cputype] ?> 
		<?= $ncpu ?>-Core,
		<?= floor($ramMB/1000) ?> GB
		<BR>
		<SPAN CLASS="address"><?= $ipname ?></SPAN>:
		<SPAN CLASS="orginization"></SPAN>
	</DIV>
</DIV>

<?				
	endforeach;
?>

</DIV>

<HR STYLE="clear: both">
<P>
<STRONG>Explanation:</STRONG> The Sparkle Update framework sends detailed profile information at most once a week, even if the app is launched more frequently. Therefore, each profile received in any 7 day stretch is guaranteed to represent a unique user/install of the app (technically, a unique preference file, which hasn't been manually tampered with).
</P>
<SCRIPT>
$(function() {
	$('.info').each(function(i, info) {
		if (i > 50) return;
		$.ajax('http://ip-api.com/json/'+$('.address', info).text())
		 .done(function (geo) {
		 	var d = [];
		 	if (geo.city) d.push(geo.city);
		 	if (geo.countryCode == 'US' && geo.region) d.push(geo.region);
		 	d.push((d.length == 0) ? geo.country : geo.countryCode);
			$('.address', info).text(d.join(", "))
			.attr('TITLE', JSON.stringify(geo, undefined, 2));
			$('.orginization', info).text(geo.org);

		});
	});
});
</SCRIPT>

<!--
ip-api.com example:
{
  "status": "success",
  "country": "United States",
  "countryCode": "US",
  "region": "NY",
  "regionName": "New York",
  "city": "Ithaca",
  "zip": "14850",
  "lat": "42.4072",
  "lon": "-76.5159",
  "timezone": "America\/New_York",
  "isp": "Time Warner Cable",
  "org": "Time Warner Cable",
  "as": "AS11351 Time Warner Cable Internet LLC",
  "query": "67.249.201.173"
}


<TABLE>
<CAPTION>System Profiles over last 30 days</CAPTION>
<TR>
	<TH>IP</TH>
	<TH>OS Version</TH>
	<TH>CPU Type</TH>
	<TH>CPU Arch</TH>
	<TH>CPU Subtype</TH>
	<TH>Model</TH>
	<TH>CPU Cores</TH>
	<TH>Language</TH>
	<TH>Application</TH>
	<TH>Version</TH>
	<TH>CPU Speed</TH>
	<TH>RAM</TH>
</TR>
<?
	foreach ($unique_ip_query as &$line) :
		$match = explode("\t", $line);
		$ip = $match[0];
		parse_str($match[1]);
?>
<TR>
	<TD><?= gethostbyaddr($ip) ?></TD>
	<TD><?= $osVersion ?></TD>
	<TD><?= $cputype_desc[$cputype] ?></TD>
	<TD><?= $cpu64bit_desc[$cpu64bit] ?></TD>
	<TD><?= $cpusubtype ?></TD>
	<TD><?= $model ?></TD>
	<TD><?= $ncpu ?></TD>
	<TD><?= $lang ?></TD>
	<TD><?= $appName ?></TD>
	<TD><?= $appVersion ?></TD>
	<TD><?= $cpuFreqMHz ?> MHz</TD>
	<TD><?= $ramMB ?> MB</TD>
</TR>
<?				
	endforeach;
?>
</TABLE>
-->
</BODY>
</HTML>
