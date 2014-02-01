<!DOCTYPE html>
<HTML>
<HEAD>
<META CHARSET=utf-8>
<TITLE>Xynk Beta has a Posse</TITLE>
<STYLE>

#logo { height: 336px; float: left; margin: 0 16px 16px 0; }
.member { float: left; position: relative; background-color: #eee; border-radius: 15px; height: 160px; width: 160px; margin: 0 16px 16px 0;}
.member .mac { position: absolute; z-index: 10; left: 40px; bottom: 40px; margin: auto;}
.member .os { position: absolute;  top: 0; right: 0; width: 70px; }
.member .version { position: absolute; lop: 0; left: 0; width: 60px; text-align: center; line-height: 60px;
font-size: 180%; background-color: white; border-radius: 41px; margin: 7px;}
.member .ip { position: absolute; bottom:0; text-align: center; width: 100%; margin: auto; }
</STYLE>
</HEAD>
<BODY>
<PRE>
<?
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

function appVersionBeta($ver) {
	global $appVersion_desc;
	return isset($appVersion_desc[$ver]) ? $appVersion_desc[$ver] : $ver;
}

	exec("zgrep --no-filename osVersion $(ls ~/logs/xynkapp.com/http/access.log.*.gz | tail -7)", $output);
//print_r($output);	
	foreach ($output as &$line) {
		preg_match('/^([\d\.]+).*xml\?([^ ]+)/', $line, $match);
		array_shift($match);
		$ip_query[] = implode("\t", $match);
	}
	$unique_ip_query = array_unique($ip_query);
	sort($unique_ip_query);
?>
</PRE>


<IMG ID="logo" SRC="XynkBetaHasAPosse.png">


<?
	foreach ($unique_ip_query as &$line) :
		$match = explode("\t", $line);
		$ip = $match[0];
		parse_str($match[1]);
		
		$ipname = preg_replace('/^.*\.([^\.]+\.[^\.]+\.[^\.]+\.[^\.]+)$/', '$1',  gethostbyaddr($ip));
?>

<DIV CLASS="member">
<DIV CLASS="version"><?= appVersionBeta($appVersion) ?></DIV>
<IMG CLASS="mac" SRC="mac/<?= $model ?>.png">
<IMG CLASS="os" SRC="os/<?= preg_replace('/\.\d+$/', '', $osVersion) ?>.png">
<DIV CLASS="ip">
<?= $cputype_desc[$cputype] ?> 
<?= $ncpu ?>-Core,
<?= floor($ramMB/1000) ?> GB
<br>
<?= $ipname ?>
</DIV>
</DIV>

<?				
	endforeach;
?>


<HR STYLE="clear: both">
<P>
Xynk Beta users active in the last 7 days (excluding today).
</P>
<P>
<STRONG>Explaination:</STRONG> The Sparkle Update framework sends detailed profile information at most once a week, even if the app is launched more frequently. Therefore, each profile received in any 7 day stretch is guarenteed to represent a unique user/install of the app (techincally, a unique preference file, which hasn't been manually tampered with).
</P>

<!--
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
