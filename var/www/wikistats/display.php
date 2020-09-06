<?php
/*
-----------------------------------------------------------------------------------------------
-- https://wikistats.wmcloud.org - MediaWiki statistics                                      --
-- (formerly wikistats.wmflabs.org)                                                          --
--                                                                                           --
-- based on "wikistats by s23.org" (https://www.s23.org/wiki/Wikistats)                       --
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
-- along with this program.  If not, see <https://www.gnu.org/licenses/>.                     --
-----------------------------------------------------------------------------------------------
*/

header('Last-Modified: ' . getlastmod());
header('Content-type: text/html; charset=utf-8');
# enable CORS (T193094)
header('Access-Control-Allow-Origin: *');

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
    case "wy":
        $project_name="Wikivoyages";
                $domain="wikivoyage.org";
                $db_table="wikivoyage";
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
    case "an":
        $project_name="Anarchopedias";
        $domain="anarchopedia.org";
        $db_table="anarchopedias";
    break;
    case "wf":
        $project_name="Wikifur wikis";
        $domain="wikifur.com";
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
        $domain="www.w3.org/community";
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
    $db_table="";

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
<li><a href="${phpself}?t=w3">w3</a> (w3c)</li>
<li><a href="${phpself}?t=ga">ga</a> (gamepedias)</li>
<li><a href="${phpself}?t=sf">sf</a> (sourceforge)</li>
</ul></html>
INVALID;
exit;
}

$listname="List of ${project_name}";
$phpself=htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES);

require_once("/etc/wikistats/config.php");
require_once("$IP/functions.php");
require_once("$IP/http_status_codes.php");

# db connect
try {
    $wdb = new PDO("mysql:host=${dbhost};dbname=${dbname}", $dbuser, $dbpass);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br />";
    die();
}

include("$IP/sortswitch.php");
$query = "SELECT *,good/total AS ratio,TIMESTAMPDIFF(MINUTE, ts, now()) AS oldness FROM ${db_table} order by ${msort} LIMIT 1000";
#DEBUG# echo "sending query: '$query'.<br /><br />";
$fnord = $wdb->prepare($query);
$fnord -> execute();

print <<<DOCHEAD
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>WikiStats - ${listname}</title>
<link href="./css/bootstrap-3.3.5.min.css" rel="stylesheet" type="text/css" />
<link href="./css/dataTables-1.10.9.css" rel="stylesheet" type="text/css" />
<link href="./css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="utf-8" src="./js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" charset="utf-8" src="./js/jquery.dataTables.min-1.10.9.js"></script>
<script type="text/javascript" charset="utf-8" src="./js/dataTables.bootstrap.min-1.10.9.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#table').DataTable( {
        "pageLength": 50,
        "paging": true,
    } );
});
</script>
</head>
<body>
DOCHEAD;

print <<<THEAD_INTRO
<div id="main" style="float:left;width:90%;padding:1%">
<table class="table table-striped table-bordered" id="table" cellpadding="1">
<thead><tr>
<th class="head" colspan="19">${listname}</th>
</tr><tr><th class="sub">&#8470;</th>
THEAD_INTRO;

if (in_array($db_table, $tables_https_only)) {
    $protocol="https";
} else {
    $protocol="http";
}

if (in_array($db_table, $tables_with_language_columns)) {
    print <<<THEAD_LANG
    <th class="sub">Language</th>
    <th class="sub">Language (local)</th>
    <th class="sub">Wiki</th>
THEAD_LANG;
} elseif ($project == "mw") {
    print <<<THEAD_MW
    <th class="sub">Wiki</th>
    <th class="sub">Language</th>
THEAD_MW;
} elseif ($project == "wx") {
    print <<<THEAD_WX
    <th class="sub">Language</th>
    <th class="sub">Description</th>
    <th class="sub">Wiki</th>
THEAD_WX;
} else {
    print <<<THEAD_DEFAULT
    <th class="sub">Name</th>
THEAD_DEFAULT;
}

print <<<THEAD_MAIN
<th class="sub" data-toggle="tooltip" title="number of real articles (per https://www.mediawiki.org/wiki/Manual:Article_count)">Good</th>
<th class="sub" data-toggle="tooltip" title="number of all pages, articles and others">Total </th>
<th class="sub" data-toggle="tooltip" title="number of edits on pages">Edits</th>
<th class="sub" data-toggle="tooltip" title="number of administrators">Admins</th>
<th class="sub" data-toggle="tooltip" title="number of users">Users</th>
<th class="sub" data-toggle="tooltip" title="number of active users (per https://www.mediawiki.org/wiki/Manual:$wgActiveUserDays)">Active Users</th>
<th class="sub" data-toggle="tooltip" title="number of files (images and others)">Files</th>
<th class="sub" data-toggle="tooltip" title="number of 'good' articles divided by number of total pages">Stub Ratio</th>
<th class="sub" data-toggle="tooltip" title="MediaWiki version">Version</th>
<th class="sub" data-toggle="tooltip" title="license wiki content is published under">License</th>
<th class="sub" data-toggle="tooltip" title="link to archive.org to download a dump of the wiki">Archive</th>
<th class="sub" data-toggle="tooltip" title="the HTTP status code (or a custom return code if it starts with 9)">HTTP</th>
<th class="sub" data-toggle="tooltip" title="internal ID of the wiki">ID</th>
<th class="sub" data-toggle="tooltip" title="internal code for the method used to get stats">mt</th>
<th class="sub" align="right" data-toggle="tooltip" title="last time data was updated (or an attempt failed)">Last update</th></tr></thead>
THEAD_MAIN;


$count = $offset + 1;
$gtotal = 0;
$ggood = 0;
$gedits = 0;
$gadmins = 0;
$gusers = 0;
$gausers = 0;
$gimages = 0;

while ($row = $fnord->fetch()) {
    # hack away the special entries in wp table for "milestones"
    if ($project == 'wp' && $row['method']=="99") {
        continue;
    }

    $gtotal=$gtotal+$row['total'];
    $ggood=$ggood+$row['good'];
    $gedits=$gedits+$row['edits'];
    $gadmins=$gadmins+$row['admins'];
    $gusers=$gusers+$row['users'];
    $gausers=$gausers+$row['activeusers'];
    $gimages=$gimages+$row['images'];

    if (isset($row['si_sitename']) && $row['si_sitename']!="" ) {
        $wikiname=htmlspecialchars($row['si_sitename'], ENT_QUOTES);
    } elseif (isset($row['name'])) {
        $wikiname=htmlspecialchars($row['name'], ENT_QUOTES);
    } elseif (isset($row['prefix'])) {
        $wikiname=htmlspecialchars($row['prefix'], ENT_QUOTES);
    } else {
        $wikiname="n/a";
    }

    if (strlen($wikiname) > $name_max_len ) {
        $wikiname=substr($wikiname,0,$name_max_len-2);
        $wikiname.="..";
    }

    echo "<tr><td class=\"number\">${count}</td>";

    if (in_array($db_table, $tables_with_language_columns)) {
        echo "
        <td class=\"text\"><a href=\"https://en.wikipedia.org/wiki/".$row['lang']."_language\">".$row['lang']."</a></td>
        <td class=\"text\"><a href=\"https://en.wikipedia.org/wiki/".$row['lang']."_language\">".$row['loclang']."</a></td>";
    }

    if (in_array($db_table, $tables_with_prefix_short)) {


        if ($project == "ro")  { 
          $apilink="${protocol}://".$row['prefix'].".${domain}/wk/Special:Statistics";
          $wikilink="${protocol}://".$row['prefix'].".${domain}/wk/";
          echo "<td class=\"text\"><a href=\"${protocol}://".$row['prefix'].".${domain}/\">".$row['prefix']."</a></td>";
        } else {
          $apilink="${protocol}://".$row['prefix'].".${domain}/api.php{$api_query_disp}";
          $wikilink="${protocol}://".$row['prefix'].".${domain}/wiki/";
          echo "<td class=\"text\"><a href=\"${protocol}://".$row['prefix'].".${domain}/wiki/\">".$row['prefix']."</a></td>";
        }

        $versionlink="${wikilink}Special:Version";

    } elseif (in_array($db_table, $tables_with_prefix_wiki)) {

        if ($row['statsurl']!='') {
            $wikilink=explode("api.php",$row['statsurl']);
            $wikilink=$wikilink[0]."index.php/";
            $apilink=$row['statsurl'].$api_query_disp;
        } else {
            $apilink="${protocol}//".$row['prefix'].".${domain}/wiki/api.php{$api_query_disp}";
            $wikilink="${protocol}//".$row['prefix'].".${domain}/wiki/";
        }

        $versionlink="${wikilink}Special:Version";
        echo "<td class=\"text\"><a href=\"${wikilink}\">".$row['prefix']."</a></td>";

    } elseif (in_array($db_table, $tables_with_prefix_m)) {
            $apilink="https://".$row['prefix'].".${domain}/m/api.php{$api_query_disp}";
            $wikilink="https://".$row['prefix'].".${domain}/wiki/";
            $versionlink="${wikilink}Special:Version";
            echo "<td class=\"text\"><a href=\"${wikilink}\">".$row['prefix']."</a></td>";

    } elseif (in_array($db_table, $tables_with_suffix_short)) {

        $apilink="${protocol}//${domain}/".$row['prefix']."/api.php{$api_query_disp}";
        $wikilink="${protocol}//${domain}/".$row['prefix']."/";
        $versionlink="${wikilink}Special:Version";

        echo "<td class=\"text\"><a href=\"${protocol}//${domain}/".$row['prefix']."/\">".$row['prefix']."</a></td>";

    } elseif (in_array($db_table, $tables_with_suffix_wiki)) {

        $apilink="${protocol}//${domain}/wiki/".$row['prefix']."/api.php{$api_query_disp}";
        $wikilink="${protocol}//${domain}/".$row['prefix']."/";
        $versionlink="${wikilink}Special:Version";

        echo "<td class=\"text\"><a href=\"${wikilink}\">".$row['prefix']."</a></td>";

    } elseif (in_array($db_table, $tables_with_suffix_wiki_last)) {

        $apilink="${protocol}//${domain}/".$row['prefix']."/wiki/api.php{$api_query_disp}";
        $wikilink="${protocol}//${domain}/".$row['prefix']."/wiki/";
        $versionlink="${wikilink}Special:Version";

        echo "<td class=\"text\"><a href=\"${wikilink}\">".$row['prefix']."</a></td>";

    # https://phabricator.wikimedia.org/T238801
    } elseif ($project == "wx") {

        $wikilink=explode("w/api.php",$row['statsurl']);
        $apilink=$wikilink[0]."w/api.php".$api_query_disp;
        $wikilink=$wikilink[0]."wiki/";
        $wikilink=htmlspecialchars($wikilink, ENT_QUOTES);
        $versionlink="${wikilink}Special:Version";

        echo "
        <td class=\"text\"><a href=\"https://en.wikipedia.org/wiki/".$row['lang']."_language\">".$row['lang']."</a></td>
        <td class=\"text\">".$row['description']."</td>
        <td class=\"text\"><a href=\"${wikilink}\">".$row['prefix']."</a></td>";


    # https://phabricator.wikimedia.org/T262070
    # https://phabricator.wikimedia.org/T262064
    } elseif (in_array($project, array('os','ga','an'))) {

        $apilink="${protocol}://".$row['prefix'].".${domain}/api.php{$api_query_disp}";
        $wikilink="${protocol}://".$row['prefix'].".${domain}/";
        $versionlink="${wikilink}Special:Version";
        echo "<td class=\"text\"><a href=\"${protocol}://".$row['prefix'].".${domain}/\">".$row['prefix']."</a></td>";

    } elseif (in_array($db_table, $tables_with_statsurl) && !in_array($db_table, $tables_with_language_columns)) {

        if ($row['method']=="8") {
            if (isset($row['si_base']) && isset($row['si_server']) && isset($row['si_scriptpath']) && ($row['si_base'] != '')) {
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
            $oldwikilink=htmlspecialchars($oldwikilink[0], ENT_QUOTES);
            $apilink=$row['old_statsurl'];
            $versionlink=$wikilink."api.php".$api_query_dispv;
            $mainlink=$wikilink;

        } else {
            $wikilink=explode("Special",$row['statsurl']);
            $wikilink=htmlspecialchars($wikilink[0], ENT_QUOTES);
            $apilink=$row['statsurl'];
            $versionlink="${wikilink}Special:Version";
            $mainlink=$wikilink;
        }


        if (isset($row['lang']) && $row['lang']!="") {
            $wikilanguage=htmlspecialchars($row['lang'], ENT_QUOTES);
        } elseif (isset($row['si_lang']) && $row['si_lang']!="") {
            $wikilanguage=htmlspecialchars($row['si_lang'], ENT_QUOTES);
        } else {
            $wikilanguage="n/a";
        }

        echo "<td class=\"text\"><a href=\"${mainlink}\">${wikiname}</a></td><td class=\"text\"><a href=\"https://en.wikipedia.org/wiki/${wikilanguage}_language\">${wikilanguage}</a></td>";

    } elseif (in_array($db_table, $tables_with_statsurl) && in_array($db_table, $tables_with_language_columns)) {


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

        echo "<td class=\"text\"><a href=\"${mainlink}\">${wikiname}</a></td>";

    } else {

        $apilink="${protocol}//".$row['prefix'].".${domain}/w/api.php{$api_query_disp}";
        $wikilink="${protocol}//".$row['prefix'].".${domain}/wiki/";
        $versionlink="${wikilink}Special:Version";

        echo "<td class=\"text\"><a href=\"${protocol}//".$row['prefix'].".${domain}/wiki/\">${wikiname}</a></td>";
    }

    if (isset($row['http'])) {
        $statuscode=$row['http'];
    } else {
        $statuscode="999";
    }


    # color http status
    if ($statuscode=="200" or $statuscode=="302") {
         $statusclass="status-ok";
    } elseif ($statuscode=="0") {
         $statusclass="status-null";
    } elseif (substr($statuscode, 0, 1)=="4" or substr($statuscode, 0, 1)=="5") {
         $statusclass="status-fourfive";
    } elseif (substr($statuscode, 0, 1)=="9") {
         $statusclass="status-nine";
    } else {
         $statusclass="status-default";
    }

    $oldness=round($row['oldness']/60);

    # color old timestamps
    if ($row['oldness'] > $ts_limit_crit){
        $tsclass="timestamp-crit";
    } elseif ($row['oldness'] > $ts_limit_warn){
        $tsclass="timestamp-warn";
    } else {
        $tsclass="timestamp-ok";
    }

    if (isset($row['si_generator'])) {
        $wikiversion=str_replace("MediaWiki ","",$row['si_generator']);
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

    $archivedomain = preg_replace('#^https?://#', '', rtrim($wikilink,'/'));
    $archivedomain = explode("/",ltrim($archivedomain,'/'));
    $archivedomain = $archivedomain[0];
    $archivelink="https://archive.org/search.php?query=%28${archivedomain}%29";

    echo "
    <td class=\"number\"><a href=\"${apilink}\">".$row['good']."</a></td>
    <td class=\"number\">".$row['total']."</td>
    <td class=\"number\"><a href=\"${wikilink}Special:Recentchanges\">".$row['edits']."</a></td>
    <td class=\"number\"><a href=\"${wikilink}Special:Listadmins\">".$row['admins']."</a></td>
    <td class=\"number\"><a href=\"${wikilink}Special:Listusers\">".$row['users']."</a></td>
    <td class=\"number\"><a href=\"${wikilink}Special:Listusers\">".$row['activeusers']."</a></td>
    <td class=\"number\"><a href=\"${wikilink}Special:ListFiles\">".$row['images']."</a></td>
    <td class=\"number\">".$row['ratio']."</td>
    <td class=\"number " .version_color($wikiversion)."\"><a href=\"${versionlink}\">${wikiversion}</a></td>
    <td class=\"number\">${wikilicense}</td>
    <td class=\"number\"><a href=\"${archivelink}\">archive</a></td>
    <td class=\"number ${statusclass}\"><div title=\"$http_status[$statuscode]\">$statuscode</div></td>
    <td class=\"number\"><a href=\"detail.php?t=${project}&amp;id=".$row['id']."\">".$row['id']."</a></td>
    <td class=\"number\">".$row['method']."</td>
    <td class=\"timestamp ${tsclass}\">".$row['ts']." (&#126; ".$oldness." hrs ago)</td></tr>\n";
    $count++;
}

echo "</table>\n\n";

# close db connection
$wdb = null;

$ppage=$page-1;
$npage=$page+1;

echo "<p class=\"nextpage\">(<a href=\"display.php?t=${project}&amp;s=${sort}&amp;p=${ppage}\">prev</a>) page: $page (<a href=\"display.php?t=${project}&amp;s=${sort}&amp;p=${npage}\">next</a>)</p>";

include ("$IP/grandtotal.php");

include ("$IP/footer.php");
echo "</div></body></html>";
?>
