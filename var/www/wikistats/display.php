<?php
# wikistats - display html tables for all projects
header('Last-Modified: '.getlastmod());
header('Content-type: text/html; charset=utf-8');

$project = substr($_GET['t'], 0, 2);

switch ($project) {
	case "wp":
		$project_name="Wikipedias";
		$domain="wikipedia.org";
		$db_table="wikipedias";
	break;
	case "wb":
		$project_name="Wikibooks";
		$domain="wikibooks.org";
		$db_table="wikibooks";
	break;
	case "mw":
		$project_name="Mediawikis";
		$domain="na";
		$db_table="mediawikis";
	break;
	case "wn":
		$project_name="Wikinews";
		$domain="wikinews.org";
		$db_table="wikinews";
	break;
	case "wt":
		$project_name="Wiktionaries";
		$domain="wiktionary.org";
		$db_table="wiktionaries";
	break;
	case "wq":
		$project_name="Wikiquotes";
		$domain="wikiquote.org";
		$db_table="wikiquotes";
	break;
	case "ws":
		$project_name="Wikisources";
		$domain="wikisource.org";
		$db_table="wikisources";
	break;
	case "wv":
		$project_name="Wikiversities";
		$domain="wikiversity.org";
		$db_table="wikiversity";
	break;
	case "wx":
		$project_name="Wikimedia Special Projects";
		$domain="wikimedia.org";
		$db_table="wmspecials";
	break;
	case "un":
		$project_name="Uncyclo(pm)edias";
		$domain="na";
		$db_table="uncyclomedia";
	break;
	case "mt":
		$project_name="Metapedias";
		$domain="metapedia.org";
		$db_table="metapedias";
	break;
	case "os":
		$project_name="OpenSUSE wikis";
		$domain="opensuse.org";
		$db_table="opensuse";
	break;
	case "gt":
		$project_name="Gentoo wikis";
		$domain="gentoo-wiki.com";
		$db_table="gentoo";
	break;
	case "an":
		$project_name="Anarchopedias";
		$domain="anarchopedia.org";
		$db_table="anarchopedias";
	break;
	case "wf":
		$project_name="Wikifur wikis";
		$domain="wikifur.org";
		$db_table="wikifur";
	break;

	case "ne":
		$project_name="Neoseeker wikis";
		$domain="neoseeker.com";
		$db_table="neoseeker";
	break;
	case "et":
		$project_name="EditThis wikis";
		$domain="editthis.info";
		$db_table="editthis";
	break;
	case "sw":
		$project_name="Shoutwikis";
		$domain="shoutwiki.com";
		$db_table="shoutwiki";
	break;
	case "sc":
		$project_name="Scoutwikis";
		$domain="scoutwiki.org";
		$db_table="scoutwiki";
	break;
	case "wr":
		$project_name="Wikitravel wikis";
		$domain="wikitravel.org";
		$db_table="wikitravel";
	break;
	case "si":
		$project_name="Wiki-site wikis";
		$domain="wiki-site.com";
		$db_table="wikisite";
	break;
	case "wi":
		$project_name="Wikia wikis";
		$domain="wikia.com";
		$db_table="wikia";
	break;
	case "re":
		$project_name="Referata wikis";
		$domain="referata.com";
		$db_table="referata";
	break;
	case "pa":
		$project_name="Pardus wikis";
		$domain="pardus-wiki.org";
		$db_table="pardus";
	break;
	case "ro":
		$project_name="Rodovid wikis";
		$domain="rodovid.org";
		$db_table="rodovid";
	break;
	case "wk":
		$project_name="wikkii wikis";
		$domain="wikkii.com";
		$db_table="wikkii";
	break;
	case "lx":
		$project_name="LXDE wikis";
		$domain="wiki.lxde.org";
		$db_table="lxde";
	break;
default:

	$project_name="invalid";
	$domain="localhost";
	$db_table="";

print <<<INVALID
<html><p>invalid project key or still needs to be created. </p><ul>
<li><a href="${phpself}?t=wp">wp</a> (wikipedias)</li><a href="${phpself}?t=wt">wt</a> (wiktionaries)</li><li><a href="${phpself}?t=ws">ws</a> (wikisources)</li>
<li><a href="${phpself}?t=mw">mw</a> (mediawikis)</li><li><a href="${phpself}?t=wi">wi</a> (wikia)</li><li><a href="${phpself}?t=wx">wx</a> (wmspecials)</li>
<li><a href="${phpself}?t=un">un</a> (uncyclomedias)</li><li><a href="${phpself}?t=wn">wn</a> (wikinews)</li><li><a href="${phpself}?t=mt">mt</a> (metapedias)</li>
<li><a href="${phpself}?t=wb">wb</a> (wikibooks)</li><li><a href="${phpself}?t=wq">wq</a> (wikiquotes)</li><li><a href="${phpself}?t=et">et</a> (editthis)</li>
<li><a href="${phpself}?t=si">si</a> (wikisite)</li><li><a href="${phpself}?t=sw">sw</a> (shoutwiki)</li><li><a href="${phpself}?t=wr">wr</a> (wikitravel)</li>
<li><a href="${phpself}?t=ne">ne</a> (neoseeker)</li><li><a href="${phpself}?t=wv">wv</a> (wikiversity)</li><li><a href="${phpself}?t=sc">sc</a> (scoutwiki)</li>
<li><a href="${phpself}?t=wf">wf</a> (wikifur)</li><li><a href="${phpself}?t=an">an</a> (anarchopedias)</li><li><a href="${phpself}?t=gt">gt</a> (gentoo)</li>
<li><a href="${phpself}?t=os">os</a> (opensuse)</li><li><a href="${phpself}?t=re">re</a> (referata)</li><li><a href="${phpself}?t=pa">pa</a> (pardus)</li>
</ul></html>
INVALID;
exit;
}

$listname="List of ${project_name}";
$phpself=$_SERVER['PHP_SELF'];

$darr="<b style=\"font-size: 120%;\">&darr;</b>";
$uarr="<b style=\"font-size: 120%;\">&uarr;</b>";
$nodeco="text-decoration:none;";

require_once("config.php");
require_once("./includes/functions.php");
require_once("./includes/http_status_codes.php");

mysql_connect("$dbhost", "$dbname", "$dbpass") or die(mysql_error());
include("./includes/sortswitch.php");
mysql_select_db("$dbdatabase") or die(mysql_error());
$query = "select *,good/total as ratio,TIMESTAMPDIFF(MINUTE, ts, now()) as oldness from ${db_table} order by ${sort} limit 500";
$result = mysql_query("$query") or die(mysql_error());
#DEBUG# echo "Sent query: '$query'.<br /><br />";

print <<<DOCHEAD
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>WikiStats - ${listname}</title>
<link href="./css/wikistats_css.php" rel="stylesheet" type="text/css" />
</head>
<body>
DOCHEAD;

if (isset($_GET['th']) && is_numeric($_GET['th']) && $_GET['th'] >= 0 && $_GET['th'] < 10000000) {
	$threshold=$_GET['th'];
	$threshold=mysql_real_escape_string($threshold);
} else {
	$threshold=0;
}

if (isset($_GET['lines']) && is_numeric($_GET['lines']) && $_GET['lines'] > 0 && $_GET['lines'] < 10001) {
	$limit=$_GET['lines'];
	$limit=mysql_real_escape_string($limit);
} else {
	$limit="200";
}

print <<<THEAD_INTRO
<div id="main" style="float:left;width:90%;">
<table border="0"><tr>
<th class="head" colspan="10">${listname}</th>
</tr><tr><th class="sub">&#8470;</th>
THEAD_INTRO;

if (in_array($db_table, $tables_with_language_columns)) {

print <<<THEAD_LANG
<th class="sub">
Language (<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=lang_asc">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=lang_desc">${darr}</a>)
</th>

<th class="sub">
Language (local) (<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=loclang_asc">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=loclang_desc">${darr}</a>)
</th>

<th class="sub">
Wiki (<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=prefix_asc">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=prefix_desc">${darr}</a>)
</th>
THEAD_LANG;

} elseif ($project == "wx") {
	
print <<<THEAD_WX
<th class="sub">
Language
(<a style="${nodeco}" href="${phpself}"?t=${project}&amp;sort=lang_asc">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=lang_desc">${darr}</a>)
</th>

<th class="sub">
Description 
(<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=loclang_asc">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=loclang_desc">${darr}</a>)
</th>

<th class="sub">
Wiki 
(<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=prefix_asc">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=prefix_desc">${darr}</a>)
</th>";
THEAD_WX;

} else {
	
print <<<THEAD_DEFAULT
<th class="sub">
Name
(<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=name_asc">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=name_desc">${darr}</a>)
</th>
<th class="sub">
Language
(<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=lang_asc">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=lang_desc">${darr}</a>)
</th>
THEAD_DEFAULT;

}

print <<<THEAD_MAIN
<th class="sub">Good (<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=good_asc">
${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=good_desc">${darr}</a>)</th>
<th class="sub">Total (<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=total_asc">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=total_desc">${darr}</a>)</th>
<th class="sub">Edits (<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=edits_asc">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=edits_desc">${darr}</a>)</th>
<th class="sub">Admins (<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=admins_asc">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=admins_desc">${darr}</a>)</th>
<th class="sub">Users (<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=users_asc">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=users_desc">${darr}</a>)</th>
<th class="sub">Active Users (<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=ausers_asc">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=ausers_desc">${darr}</a>)</th>
<th class="sub">Images (<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=images_asc">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=images_desc">${darr}</a>)</th>
<th class="sub">Stub Ratio (<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=ratio_asc">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=ratio_desc">${darr}</a>)</th>
<th class="sub">Version (<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=version_asc&amp;th=${threshold}&amp;lines=${limit}">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=version_desc&amp;th=${threshold}&amp;lines=${limit}">${darr}</a>)</th>
<th class="sub">License (<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=rights_asc&amp;th=${threshold}&amp;lines=${limit}">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=rights_desc&amp;th=${threshold}&amp;lines=${limit}">${darr}</a>)</th>
<th class="sub">http (<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=http_asc&amp;th=${threshold}&amp;lines=${limit}">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=http_desc&amp;th=${threshold}&amp;lines=${limit}">${darr}</a>)</th>
<th class="sub">id (<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=id_asc&amp;th=${threshold}&amp;lines=${limit}">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=id_desc&amp;th=${threshold}&amp;lines=${limit}">${darr}</a>)</th>
<th class="sub">mt (<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=method_asc&amp;th=${threshold}&amp;lines=${limit}">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=method_desc&amp;th=${threshold}&amp;lines=${limit}">${darr}</a>)</th>
<th class="sub" align="right">Last update (<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=ts_asc">${uarr}</a>
<a style="${nodeco}" href="${phpself}?t=${project}&amp;sort=ts_desc">${darr}</a>)</th></tr>
THEAD_MAIN;


$count=1;
$gtotal=0;
$ggood=0;
$gedits=0;
$gadmins=0;
$gusers=0;
$gimages=0;

while($row = mysql_fetch_array( $result )) {
	$gtotal=$gtotal+$row['total'];
	$ggood=$ggood+$row['good'];
	$gedits=$gedits+$row['edits'];
	$gadmins=$gadmins+$row['admins'];
	$gusers=$gusers+$row['users'];
	$gimages=$gimages+$row['images'];

	if (isset($row['si_sitename']) && $row['si_sitename']!="" ) {
		$wikiname=htmlspecialchars($row['si_sitename']);
	} elseif (isset($row['name'])) {
		$wikiname=htmlspecialchars($row['name']);
	} else {
		$wikiname=htmlspecialchars($row['prefix']);
	}

	if (strlen($wikiname) > $name_max_len ) {
		$wikiname=substr($wikiname,0,$name_max_len-2);
		$wikiname.="..";
	}

	echo "<tr><td class=\"number\">${count}</td>";

	if (in_array($db_table, $tables_with_language_columns)) {
		echo "
		<td class=\"text\"><a href=\"http://en.wikipedia.org/wiki/".$row['lang']."_language\">".$row['lang']."</a></td>
		<td class=\"text\"><a href=\"http://en.wikipedia.org/wiki/".$row['lang']."_language\">".$row['loclang']."</a></td>";
	}

	if (in_array($db_table, $tables_with_prefix_short)) {

		$apilink="http://".$row['prefix'].".${domain}/api.php{$api_query_disp}";
		$wikilink="http://".$row['prefix'].".${domain}/wiki";
		$versionlink="${wikilink}Special:Version";

		echo "<td class=\"text\"><a href=\"http://".$row['prefix'].".${domain}/wiki/\">".$row['prefix']."</a></td>";

	} elseif (in_array($db_table, $tables_with_suffix_short)) {

                $apilink="http://${domain}/".$row['prefix']."/api.php{$api_query_disp}";
                $wikilink="http://${domain}/".$row['prefix'];
                $versionlink="${wikilink}Special:Version";
	
		echo "<td class=\"text\"><a href=\"http://${domain}/".$row['prefix']."/\">".$row['prefix']."</a></td>";

	} elseif ($project == "wx") {

		echo "
		<td class=\"text\"><a href=\"http://en.wikipedia.org/wiki/".$row['lang']."_language\">".$row['lang']."</a></td>
		<td class=\"text\">".$row['description']."</td>
		<td class=\"text\"><a href=\"http://".$row['prefix'].".${domain}/wiki/\">".$row['prefix']."</a></td>";

	} elseif (in_array($db_table, $tables_with_statsurl)) {

		if ($row['method']=="8") {
			if (isset($row['si_base']) && isset($row['si_server']) && isset($row['si_scriptpath'])) {
				$mainlink=$row['si_base'];
				$wikilink=$row['si_server'].$row['si_articlepath'];
				$wikilink=explode("$1",$wikilink);
				$wikilink=$wikilink[0];
				$apilink=$row['si_server'].$row['si_scriptpath']."/api.php".$api_query_disp;
				$versionlink=$row['si_server'].$row['si_scriptpath']."/api.php".$api_query_dispv;
			} else {
				$wikilink=explode("api.php",$row['statsurl']);
				$wikilink=$wikilink[0];
				$apilink=$wikilink."api.php".$api_query_disp;
				$versionlink=$wikilink."api.php".$api_query_dispv;
				$mainlink=$wikilink;
			}
		} elseif ($row['method']=="7") {
			$wikilink=explode("api.php",$row['statsurl']);
			$wikilink=$wikilink[0];
			$oldwikilink=explode("Special",$row['old_statsurl']);
			$oldwikilink=htmlspecialchars($oldwikilink[0]);
			$apilink=$row['old_statsurl'];
			$versionlink=$wikilink."api.php".$api_query_dispv;
			$mainlink=$wikilink;

		} else {
			$wikilink=explode("Special",$row['statsurl']);
			$wikilink=htmlspecialchars($wikilink[0]);
			$apilink=$row['statsurl'];
			$versionlink="${wikilink}Special:Version";
			$mainlink=$wikilink;
		}


		if (isset($row['lang']) && $row['lang']!="") {
			$wikilanguage=htmlspecialchars($row['lang']);
		} elseif (isset($row['si_lang']) && $row['si_lang']!="") {
			$wikilanguage=htmlspecialchars($row['si_lang']);
		} else {
			$wikilanguage="n/a";
		}

		echo "<td class=\"text\"><a href=\"${mainlink}\">".${wikiname}."</a></td><td class=\"text\"><a href=\"http://en.wikipedia.org/wiki/${wikilanguage}_language\">${wikilanguage}</a></td>";

	} else {

                $apilink="http://".$row['prefix'].".${domain}/w/api.php{$api_query_disp}";
                $wikilink="http://".$row['prefix'].".${domain}/wiki";
                $versionlink="${wikilink}Special:Version";
		
		echo "<td class=\"text\"><a href=\"http://".$row['prefix'].".${domain}/wiki/\">".${wikiname}."</a></td>";
	}

	if (isset($row['http'])) {
		$statuscode=$row['http'];
	} else {
		$statuscode="999";
	}


	# Color http status
	 if ($statuscode=="200" or $statuscode=="302") {
		 $statuscolor="#AAEEAA";
	 } elseif ($statuscode=="0") {
		 $statuscolor="#AAAAAA";
	 } elseif (substr($statuscode, 0, 1)=="4" or substr($statuscode, 0, 1)=="5") {
		 $statuscolor="#CC2222";
	 } elseif (substr($statuscode, 0, 1)=="9") {
		 $statuscolor="#FFCCCC";
	 } else {
		 $statuscolor="#FF6666";
	 }

	# Color old timestamps
	if ($row['oldness'] > 2879){
		$tscolor="#CC2222";
	} elseif ($row['oldness'] > 1439){
		$tscolor="#FF6666";
	} else {
		$tscolor="#AAEEAA";
	}

	if (isset($row['si_generator'])) {
		$wikiversion=explode("MediaWiki ",$row['si_generator']);
		$wikiversion=$wikiversion[1];
	} else {
		$wikiversion=$row['version'];
	}

	if (isset($row['si_rights']) && $row['si_rights']!="") {
		
		$wikilicense=$row['si_rights'];

		if (strlen($wikilicense) > $rights_max_len ) {
			$wikilicense=substr($wikilicense,0,$rights_max_len-2);
			$wikilicense.="..";
		}
	} else {
		$wikilicense="n/a";
	}

	echo "
	<td class=\"number\"><a href=\"${apilink}\">".$row['good']."</a></td>
	<td class=\"number\">".$row['total']."</td>
	<td class=\"number\"><a href=\"${wikilink}Special:Recentchanges\">".$row['edits']."</a></td>
	<td class=\"number\"><a href=\"${wikilink}Special:Listadmins\">".$row['admins']."</a></td>
	<td class=\"number\"><a href=\"${wikilink}Special:Listusers\">".$row['users']."</a></td>
	<td class=\"number\"><a href=\"${wikilink}Special:Listusers\">".$row['activeusers']."</a></td>
	<td class=\"number\"><a href=\"${wikilink}Special:Imagelist\">".$row['images']."</a></td>
	<td class=\"number\">".$row['ratio']."</td>
	<td style=\"background: ".version_color($wikiversion).";\" class=\"text\"><a href=\"${versionlink}\">${wikiversion}</a></td>
	<td class=\"number\">${wikilicense}</td>
	<td style=\"background: ".$statuscolor.";\" class=\"number\"><div title=\"$http_status[$statuscode]\">$statuscode</div></td>
	<td class=\"number\">".$row['id']."</td>
	<td class=\"number\">".$row['method']."</td>
	<td style=\"background: ".$tscolor.";\" class=\"timestamp\">".$row['ts']."</td></tr>\n";

	$count++;
}

echo "</table>\n\n";
include ("./includes/grandtotal.php");
include ("./includes/footer.php");
echo "</div></body></html>";
?>
