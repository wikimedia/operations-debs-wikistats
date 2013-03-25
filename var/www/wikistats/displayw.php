<?php
/*
-----------------------------------------------------------------------------------------------
-- wikistats.wmflabs.org - mediawiki statistics                                              --
--                                                                                           --
-- based on "wikistats by s23.org" (http://www.s23.org/wiki/Wikistats)                       --
-- Copyright 2005-2011 - Daniel Zahn, Sven Grewe, Mattis Manzel, et.al.                      --
--                                                                                           --
-- which was released under Attribution-NonCommercial-ShareAlike 2.5 and inspired by:        --
-- - "BiggestWiki" on Meatball wiki (meatballwiki.org/ usemod.com) by Robert Werner Hanke    --
-- - "one big soup" / wiki-net lightning talks at 21C3 congress (2004) by Mattis Manzel      --
-- thanks for: endless task managing: R.W. Hanke  years of hosting: the s23.org community    --
--                                                                                           --
-- This rewrite is now Copyright 2012 - Wikimedia Foundation, Inc. (<dzahn@wikimedia.org>)   --
-- and released under GNU General Public License with the consent of the original authors.   --
--                                                                                           --
-- This program is free software: you can redistribute it and/or modify it under the terms   --
-- of the GNU General Public License as published by the Free Software Foundation,           --
-- either version 3 of the License, or (at your option) any later version.                   --
--                                                                                           --
-- This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; --
-- without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. --
-- See the GNU General Public License for more details.                                      --
--                                                                                           --
-- You should have received a copy of the GNU General Public License                         --
-- along with this program.  If not, see <http://www.gnu.org/licenses/>.                     --
-----------------------------------------------------------------------------------------------
*/

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

require_once("/etc/wikistats/config.php");
require_once("$IP/functions.php");
require_once("$IP/http_status_codes.php");

if (isset($_GET['p']) && is_numeric($_GET['p']) && $_GET['p'] > 1 && $_GET['p'] < 100) {
	$page=$_GET['p'];
	$page=mysql_escape_string($page);
	$offset=($page-1)*${page_size};
} else {
	$page="1";
	$offset=0;
}

mysql_connect("$dbhost", "$dbuser", "$dbpass") or die(mysql_error());
include("$IP/sortswitch.php");
mysql_select_db("$dbname") or die(mysql_error());
$query = "select *,good/total as ratio,TIMESTAMPDIFF(MINUTE, ts, now()) as oldness from ${db_table} order by ${msort} limit ${page_size} offset ${offset}";
#DEBUG# echo "sending query: '$query'.<br /><br />";
$result = mysql_query("$query") or die(mysql_error());

echo "<pre>";

print <<<THEAD_INTRO
{| border="1" cellpadding="2" cellspacing="0" style="background: #f9f9f9; border: 1px solid #aaaaaa; border-collapse: collapse; white-space: nowrap; text-align: left" class="sortable"
|-
! &#8470;

THEAD_INTRO;

if (in_array($db_table, $tables_with_language_columns)) {

print <<<THEAD_LANG
! Language
! Language (local)

THEAD_LANG;

} elseif ($project == "wx") {

print <<<THEAD_WX
FIX FIX FIX FIX ME
THEAD_WX;

} else {

print <<<THEAD_DEFAULT
! Name

THEAD_DEFAULT;

}

print <<<THEAD_MAIN
! Wiki
! Good
! Total
! Edits
! Admins
! Users
! Active Users
! Images
! Updated

THEAD_MAIN;


$count=1+$offset;
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
	} elseif (isset($row['prefix'])) {
		$wikiname=htmlspecialchars($row['prefix']);
	} else {
		$wikiname="n/a";
	}

	if (strlen($wikiname) > $name_max_len ) {
		$wikiname=substr($wikiname,0,$name_max_len-2);
		$wikiname.="..";
	}

echo "|- style=\"text-align: right;\"\n| ${count}\n";

	if (in_array($db_table, $tables_with_language_columns)) {

print <<<LANGCOLS
| [[w:{$row['lang']} language|{$row['lang']}]]
| [[w:{$row['lang']} language|{$row['loclang']}]]

LANGCOLS;

	}

	if (in_array($db_table, $tables_with_prefix_short)) {

		$apilink="http://".$row['prefix'].".${domain}/api.php{$api_query_disp}";
		$wikilink="http://".$row['prefix'].".${domain}/wiki";
		$versionlink="${wikilink}Special:Version";

		echo "[http://".$row['prefix'].".${domain}/wiki/ '''".$row['good']."''']";

	} elseif (in_array($db_table, $tables_with_suffix_short)) {

		$apilink="http://${domain}/".$row['prefix']."/api.php{$api_query_disp}";
		$wikilink="http://${domain}/".$row['prefix'];
		$versionlink="${wikilink}Special:Version";

		echo "[http://${domain}/".$row['prefix']." '''".$row['good']."''']";

	} elseif ($project == "wx") {

		echo "FIX FIX FIX FIX ME";

	} elseif (in_array($db_table, $tables_with_statsurl) && !in_array($db_table, $tables_with_language_columns)) {

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

		echo "| [http://".$row['prefix'].".$domain/wiki/ ".$row['prefix']."]";

	} else {

		$apilink="http://".$row['prefix'].".${domain}/w/api.php{$api_query_disp}";
		$wikilink="http://".$row['prefix'].".${domain}/wiki";
		$versionlink="${wikilink}/Special:Version";

		echo "| [//".$row['prefix'].".$domain/wiki/ ".$row['prefix']."]";
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

	$oldness=round($row['oldness']/60);

	# Color old timestamps
	if ($row['oldness'] > $ts_limit_crit){
		$tsclass="timestamp-crit";
	} elseif ($row['oldness'] > $ts_limit_warn){
		$tsclass="timestamp-warn";
	} else {
		$tsclass="timestamp-ok";
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

print <<<TABLEMAIN

| [//{$row['prefix']}.${domain}/wiki/Special:Statistics?action=raw '''{$row['good']} ''']
| {$row['total']}
| [//{$row['prefix']}.${domain}/wiki/Special:Recentchanges {$row['edits']} ]
| [//{$row['prefix']}.${domain}/wiki/Special:Listadmins {$row['admins']} ]
| [//{$row['prefix']}.${domain}/wiki/Special:Listusers {$row['users']} ]
| [//{$row['prefix']}.${domain}/wiki/Special:ActiveUsers {$row['activeusers']} ]
| [//{$row['prefix']}.${domain}/wiki/Special:Imagelist {$row['images']} ]
| style="font-size: 70%;" | {$row['ts']} 

TABLEMAIN;
$count++;
}

echo "|}\n\n";

$ggood=number_format($ggood);
$gtotal=number_format($gtotal);
$gedits=number_format($gedits);
$gadmins=number_format($gadmins);
$gusers=number_format($gusers);
$gimages=number_format($gimages);

mysql_close();

print <<<GRANDTOTAL
=== Grand Total ===
{| border="1" cellpadding="2" cellspacing="0" style="width:75%; background: #f9f9f9; border: 1px solid #aaaaaa; border-collapse: collapse; white-space: nowrap;"
|-
! Articles
! Total
! Edits
! Admins
! Users
! Images
|- style=\"text-align: right;\"
|'''$ggood'''
|'''$gtotal'''
|'''$gedits'''
|'''$gadmins'''
|'''$gusers'''
|'''$gimages'''
|}
GRANDTOTAL;
?>
