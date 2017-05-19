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
    case "wy":
        $project_name="Wikivoyages";
        $domain="wikivoyage.org";
        $db_table="wikivoyage";
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
        $project_name="ShoutWikis";
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
    case "ro":
        $project_name="Rodovid wikis";
        $domain="rodovid.org";
        $db_table="rodovid";
    break;
    case "lx":
        $project_name="LXDE wikis";
        $domain="wiki.lxde.org";
        $db_table="lxde";
    break;
    case "w3":
        $project_name="W3C wikis";
        $domain="www.w3.org";
        $db_table="w3cwikis";
    break;
    case "ga":
        $project_name="Gamepedias";
        $domain="gamepedia.com";
        $db_table="gamepedias";
    break;
    case "sf":
        $project_name="Sourceforge";
        $domain="sourceforge.net";
        $db_table="sourceforge";
    break;
    case "mh":
        $project_name="Miraheze";
        $domain="miraheze.org";
        $db_table="miraheze";
    break;
default:

    $project_name="invalid";
    $domain="localhost";
    $db_table="invalid";

print <<<INVALID
<html><p>invalid project key or still needs to be created. </p><ul>
<li><a href="${phpself}?t=wp">wp</a> (wikipedias)</li><a href="${phpself}?t=wt">wt</a> (wiktionaries)</li><li><a href="${phpself}?t=ws">ws</a> (wikisources)</li>
<li><a href="${phpself}?t=mw">mw</a> (mediawikis)</li><li><a href="${phpself}?t=wi">wi</a> (wikia)</li><li><a href="${phpself}?t=wx">wx</a> (wmspecials)</li>
<li><a href="${phpself}?t=un">un</a> (uncyclomedias)</li><li><a href="${phpself}?t=wn">wn</a> (wikinews)</li><li><a href="${phpself}?t=mt">mt</a> (metapedias)</li>
<li><a href="${phpself}?t=wb">wb</a> (wikibooks)</li><li><a href="${phpself}?t=wq">wq</a> (wikiquotes)</li><li><a href="${phpself}?t=et">et</a> (editthis)</li>
<li><a href="${phpself}?t=si">si</a> (wikisite)</li><li><a href="${phpself}?t=sw">sw</a> (shoutwiki)</li><li><a href="${phpself}?t=wr">wr</a> (wikitravel)</li>
<li><a href="${phpself}?t=ne">ne</a> (neoseeker)</li><li><a href="${phpself}?t=wv">wv</a> (wikiversity)</li><li><a href="${phpself}?t=sc">sc</a> (scoutwiki)</li>
<li><a href="${phpself}?t=wf">wf</a> (wikifur)</li><li><a href="${phpself}?t=an">an</a> (anarchopedias)</li>
<li><a href="${phpself}?t=os">os</a> (opensuse)</li><li><a href="${phpself}?t=re">re</a> (referata)</li>
</ul></html>
INVALID;
exit;
}

$listname="List of ${project_name}";
$phpself=$_SERVER['PHP_SELF'];

require_once("/etc/wikistats/config.php");
require_once("$IP/functions.php");
require_once("$IP/http_status_codes.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $wikiid=$_GET['id'];
} else {
    $wikiid="123";
    # echo "You need to specify wiki id to get details. (&id=123)\n";
    # exit(1);
}

# db connect
try {
    $wdb = new PDO("mysql:host=${dbhost};dbname=${dbname}", $dbuser, $dbpass);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br />";
    die();
}

# calculate ranking
$query = "SELECT id FROM ${db_table} ORDER BY good desc,total desc";
$fnord = $wdb->prepare($query);
$fnord -> execute();

$num_project=$wdb->query($query)->fetchColumn();
$count=1;

while ($row = $fnord->fetch()) {
    if ($row['id']=="$wikiid") {
        $rank_project_g=$count;
    }
        $count++;
}

$query = "SELECT id FROM ${db_table} ORDER BY total desc,good desc";
$fnord = $wdb->prepare($query);
$fnord -> execute();
$num_project=$wdb->query($query)->fetchColumn();
$count=1;

while ($row = $fnord->fetch()) {
    if ($row['id']=="$wikiid") {
        $rank_project_t=$count;
    }
        $count++;
}

$query = "SELECT id FROM ${db_table} ORDER BY edits desc";
$fnord = $wdb->prepare($query);
$fnord -> execute();

$num_project=$wdb->query("SELECT count(*) FROM ${db_table}")->fetchColumn();
$count=1;

while ($row = $fnord->fetch()) {
    if ($row['id']=="$wikiid") {
        $rank_project_e=$count;
    }
        $count++;
}

$query = "SELECT id FROM ${db_table} ORDER by users desc";
$fnord = $wdb->prepare($query);
$fnord -> execute();
$count=1;

while ($row = $fnord->fetch()) {
    if ($row['id']=="$wikiid") {
        $rank_project_u=$count;
    }
        $count++;
}

# format for ranking (st/nd/rd/th/...)
$rank_project_g=ordinal($rank_project_g);
$rank_project_t=ordinal($rank_project_t);
$rank_project_e=ordinal($rank_project_e);
$rank_project_u=ordinal($rank_project_u);

$query = "SELECT *,good/total AS ratio,TIMESTAMPDIFF(MINUTE, ts, now()) AS oldness from ${db_table} WHERE id=:wikiid";
$fnord = $wdb->prepare($query);
$fnord -> execute(['wikiid' => $wikiid]);
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


if (isset($row['si_sitename']) && $row['si_sitename']!="" ) {
    $wikiname=htmlspecialchars($row['si_sitename']);
} elseif (isset($row['name'])) {
    $wikiname=htmlspecialchars($row['name']);
} elseif (isset($row['prefix'])) {
    $wikiname=htmlspecialchars($row['prefix']);
} else {
    $wikiname="n/a";
}

print <<<THEAD_INTRO
<div id="main" class="mainleft">
<table><tr>
<th class="head" colspan="10">${db_table} - id: ${wikiid}</th>
</tr><tr><th class="sub">&#8470;</th>
THEAD_INTRO;

if (in_array($db_table, $tables_with_language_columns)) {

print <<<THEAD_LANG
<th class="sub">Language</th>
<th class="sub">Language (local)</th>
<th class="sub">Wiki</th>
THEAD_LANG;

} elseif ($project == "wx") {

print <<<THEAD_WX
<th class="sub">Language</th>
<th class="sub">Description</th>
<th class="sub">Wiki</th>";
THEAD_WX;

} else {

print <<<THEAD_DEFAULT
<th class="sub">Name</th>
<th class="sub">Language</th>
THEAD_DEFAULT;

}

print <<<THEAD_MAIN
<th class="sub">Good</th>
<th class="sub">Total</th>
<th class="sub">Edits</th>
<th class="sub">Admins</th>
<th class="sub">Users</th>
<th class="sub">Active Users</th>
<th class="sub">Files</th>
<th class="sub">Stub Ratio</th>
<th class="sub">Version</th>
<th class="sub">License</th>
<th class="sub">http</th>
<th class="sub">id</th>
<th class="sub">mt</th>
<th class="sub" align="right">Last update</th>
</tr>
THEAD_MAIN;


$count=1;
$gtotal=0;
$ggood=0;
$gedits=0;
$gadmins=0;
$gusers=0;
$gimages=0;

while ($row = $fnord->fetch()) {

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

echo "<tr><td class=\"number\">${rank_project_g}</td>";

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

echo "<td class=\"text\"><a href=\"${mainlink}\">${wikiname}</a></td><td class=\"text\"><a href=\"http://en.wikipedia.org/wiki/${wikilanguage}_language\">${wikilanguage}</a></td>";

} else {

$apilink="http://".$row['prefix'].".${domain}/w/api.php{$api_query_disp}";
$wikilink="http://".$row['prefix'].".${domain}/wiki";
$versionlink="${wikilink}/Special:Version";

echo "<td class=\"text\"><a href=\"http://".$row['prefix'].".${domain}/wiki/\">${wikiname}</a></td>";
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

if (!empty($row['si_generator'])) {
$wikiversion=$row['si_generator'];
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
<td class=\"number\"><a href=\"${wikilink}Special:ListFiles\">".$row['images']."</a></td>
<td class=\"number\">".$row['ratio']."</td>
<td style=\"background: ".version_color($wikiversion).";\" class=\"text\"><a href=\"${versionlink}\">${wikiversion}</a></td>
<td class=\"number\">${wikilicense}</td>
<td style=\"background: ".$statuscolor.";\" class=\"number\"><div title=\"$http_status[$statuscode]\">$statuscode</div></td>
<td class=\"number\">".$row['id']."</td>
<td class=\"number\">".$row['method']."</td>
<td style=\"background: ".$tscolor.";\" class=\"timestamp\">".$row['ts']."</td></tr>\n";

echo "</table></div>\n\n";

# detailed table

echo "<div class=\"mainleft\"><h2 class=\"dt-header\">${wikiname}</h2>\n";
echo "<p class=\"ranking\">There are <span class=\"bold\">${num_project}</span> wikis in table '<span class=\"bold\">${db_table}</span>'. '<span class=\"bold\">${wikiname}</span>' is ranked <span class=\"bold\">${rank_project_g}</span> by good pages, <span class=\"bold\">${rank_project_t}</span> by total pages, <span class=\"bold\">${rank_project_e}</span> by edits and <span class=\"bold\">${rank_project_u}</span> by users.</p>\n\n";

# separate columns into different tables
$offset=0;
ksort($row);

$stats_keys=array("total","good","edits","admins","users","activeusers","images");
$conf_keys=array("id","name","statsurl","method","lang","loclang","version","versionurl");
$ts_keys=array("http","ts","added_ts","oldness","added_sc");

foreach ($row as $mykey => &$myvalue) {

    if (substr($mykey, 0, 3) == "si_") {
        $api_rows[$mykey]=$myvalue;
    } elseif (in_array($mykey, $stats_keys)) {
        $stat_rows[$mykey]=$myvalue;
    } elseif (in_array($mykey, $conf_keys)) {
        $conf_rows[$mykey]=$myvalue;
    } elseif (in_array($mykey, $ts_keys)) {
        $ts_rows[$mykey]=$myvalue;
    } else {
        $misc_rows[$mykey]=htmlspecialchars($myvalue);
    }
}

echo "<h2 class=\"dt-header\">main statistics</h2>\n";
print detailtable($stat_rows);

echo "<h2 class=\"dt-header\">(manual) config</h2>\n";
print detailtable($conf_rows);

echo "<h2 class=\"dt-header\">extended info from API</h2>\n";
print detailtable($api_rows);

echo "<h2 class=\"dt-header\">status &amp; timestamps</h2>\n";
print detailtable($ts_rows);

echo "<h2 class=\"dt-header\">misc columns</h2>\n";
print detailtable($misc_rows);

}
# close db connection
$wdb = null;

echo "</div><div class=\"mainleft\">";
include ("$IP/footer.php");
echo "</div></body></html>";
?>
