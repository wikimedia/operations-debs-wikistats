<?php
/*
-----------------------------------------------------------------------------------------------
-- https://wikistats.wmcloud.org - MediaWiki statistics                                      --
-- (formerly wikistats.wmflabs.org)                                                          --
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

header('Last-Modified: ' . getlastmod());
header('Content-type: text/html; charset=utf-8');
# enable CORS (T193094)
header('Access-Control-Allow-Origin: *');

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <title>WikiStats - Mediawiki statistics</title>
        <meta name="description" content="various statistics tables about Mediawikis, Wikihives, Wikimedia in html,csv,ssv and wikisyntax" />
        <link href="./css/bootstrap-3.3.5.min.css" rel="stylesheet" type="text/css" />
        <link href="./css/dataTables-1.10.9.css" rel="stylesheet" type="text/css" />
        <link href="./css/main.css" rel="stylesheet" type="text/css" />
        <script src="./js/jquery-1.11.3.min.js"></script>
        <script src="./js/jquery.dataTables.min-1.10.9.js"></script>
        <script src="./js/dataTables.bootstrap.min-1.10.9.js"></script>
        <script>
        $(document).ready(function() {
            $('#table').DataTable();
        } );
        </script>
    </head>
    <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">Wikistats</a>
            </div>
        </div>
    </nav><br /><br />
    <div id="logos" style="float:left;padding-left:0.8em;width:10%;">
        <h2>
            <img style="border:1px;" src="./images/Wikistats-logo.png" width="150" height="127" alt="Wiki Stats" />
            Wikistats 2.2
        </h2>
    [<b>not</b>-Analytics-Wikistats]<p></p>
    </div>
<?php
$listname = "Statistics about Mediawikis";

# config
require_once("/etc/wikistats/config.php");

# Get "Last Updated" timestamps
# db connect
try {
    $wdb = new PDO("mysql:host=${dbhost};dbname=${dbname}", $dbuser, $dbpass);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br />";
    die();
}

foreach ($listtables as $listtable) {
    $query = "SELECT ts,TIMESTAMPDIFF(MINUTE, ts, now()) AS oldness FROM ${listtable} ORDER BY ts desc LIMIT 1";
    $fnord = $wdb->prepare($query);
    $fnord -> execute();

    while ($row = $fnord->fetch()) {
        $ts = $row['ts'];
        $timestamp[$listtable] = $ts;
        $oldness[$listtable] = round($row['oldness'] / 60);

        # color old timestamps
        if ($row['oldness'] > $ts_limit_crit){
            $tsclass[$listtable] = "timestamp-crit";
        } elseif ($row['oldness'] > $ts_limit_warn) {
            $tsclass[$listtable] = "timestamp-warn";
        } else {
            $tsclass[$listtable] = "timestamp-ok";
        }
    }
}
?>
<?php
echo "
<div id=\"main\" style=\"float:right;width:89%;padding-top:20px;\" class=\"container\">
    <table class=\"table table-striped table-bordered\" id=\"table\" >
        <thead>
            <tr>
                <th colspan=\"16\" class=\"head\">List of MediaWikis</th>
            </tr>
            <tr>
                <th class=\"sub\">&#8470;</th>
                <th class=\"sub\">Project</th>
                <th class=\"sub\">&#8470; of wikis</th>
                <th class=\"sub\">Good articles</th>
                <th class=\"sub\">Total pages</th>
                <th class=\"sub\">Edits</th>
                <th class=\"sub\">Files</th>
                <th class=\"sub\">Users</th>
                <th class=\"sub\">Active Users</th>
                <th class=\"sub\">Admins</th>
                <th class=\"sub\">Stub ratio</th>
                <th class=\"sub\" colspan=\"4\">Formats</th>
                <th class=\"sub\">Last update</th>
            </tr>
        </thead><tbody>
";


$count = 0;
$gtotal = 0;
$ggood = 0;
$gedits = 0;
$gadmins = 0;
$gusers = 0;
$gausers = 0;
$gimages = 0;
$gwikis = 0;

# main query
include("$IP/coalesced_query.php");

$fnord = $wdb->prepare($query);
$fnord -> execute();
while ($row = $fnord->fetch()) {
    $count++;
    $users = $row['gusers'];
    $ausers = $row['gausers'];
    $gwikis = $gwikis + $row['numwikis'];
    $gtotal = $gtotal + $row['gtotal'];
    $ggood = $ggood + $row['ggood'];
    $gedits = $gedits + $row['gedits'];
    $gadmins = $gadmins + $row['gadmins'];
    $gusers = $gusers + $users;
    $gausers = $gausers + $ausers;
    $gimages = $gimages + $row['gimages'];

    if ($row['gtotal'] == 0) {
        $stubratio = 0;
    } else {
        $stubratio = $row['ggood'] / $row['gtotal'];
    }

    $grandstubratio = 0;
    $grandstubratio = $grandstubratio + $stubratio;
    $stubratio = round($stubratio, 4);
    $stubratio = number_format($stubratio, 4);
    $name = $row['name'];
    $project = $row['project'];

    # Check existence of format links and color green or red

    $file_formats = array("html", "wiki");

    foreach ($file_formats as &$file_format) {
        $filename = $name . "_" . $file_format . ".php";

        if (file_exists($filename)) {
            $color[$file_format] = "#66CCAA";
        } else {
            $color[$file_format] = "#662266";
        }

    }

    echo "<tr>
            <td class=\"number\">${count}</td>
            <td class=\"text\"><a href=\"display.php?t=$project\">$name</a></td>
            <td class=\"text\">" . $row['numwikis'] . "</td>
            <td class=\"text\">" . $row['ggood'] . "</td>
            <td class=\"text\">" . $row['gtotal'] . "</td>
            <td class=\"text\">" . $row['gedits'] . "</td>
            <td class=\"text\">" . $row['gimages'] . "</td>
            <td class=\"text\">" . $users . "</td>
            <td class=\"text\">" . $ausers . "</td>
            <td class=\"text\">" .$row['gadmins'] . "</td>
            <td class=\"text\">" . $stubratio . "</td>
            <td class=\"formats\"><a href=\"api.php?action=dump&amp;table=$name&amp;format=csv\">csv</a></td>
            <td class=\"formats\"><a href=\"api.php?action=dump&amp;table=$name&amp;format=ssv\">ssv</a></td>
            <td class=\"formats\"><a href=\"./xml/${name}.xml\">xml</a></td>";

    if ($project == 'wp') {
        echo "<td class=\"formats\"><a href=\"wikipedias_wiki.php\">mwiki</a></td>";
    } else {
        echo "<td class=\"formats\"><a href=\"displayw.php?t=$project\">mwiki</a></td>";
    }

    echo "<td class=\"timestamp " . $tsclass[$name] . "\">" . $timestamp[$name] . " (&#126; " . $oldness[$name] . " hrs ago)</td>
        </tr>";
}
# Wikimedias

$default_fields="good,total,edits,admins,users,activeusers,images";

$query = <<<FNORD
(SELECT $default_fields} FROM wikipedias WHERE prefix IS NOT null)
 UNION ALL (SELECT ${default_fields} FROM wikisources)
 UNION ALL (SELECT ${default_fields} FROM wiktionaries)
 UNION ALL (SELECT ${default_fields} FROM wikiquotes)
 UNION ALL (SELECT ${default_fields} FROM wikibooks)
 UNION ALL (SELECT ${default_fields} FROM wikinews)
 UNION ALL (SELECT ${default_fields} FROM wmspecials)
 UNION ALL (SELECT ${default_fields} FROM wikivoyage)
 ORDER BY good;
FNORD;

$fnord = $wdb->prepare($query);
$fnord -> execute();

$wm_wikis =0;
$wm_good = 0;
$wm_total = 0;
$wm_edits = 0;
$wm_admins = 0;
$wm_users = 0;
$wm_ausers = 0;
$wm_images = 0;


while ($row = $fnord->fetch()) {
    $wm_wikis = $wm_wikis + 1;
    $wm_good = $wm_good + $row['good'];
    $wm_total = $wm_total + $row['total'];
    $wm_edits = $wm_edits + $row['edits'];
    $wm_admins = $wm_admins + $row['admins'];
    $wm_users = $wm_users + $row['users'];
    $wm_ausers = $wm_ausers + $row['activeusers'];
    $wm_images = $wm_images + $row['images'];
}

# close db connection
$wdb = null;

$wm_ratio = $wm_good / $wm_total;
$wm_ratio = round($wm_ratio,4);
$wm_ratio = number_format($wm_ratio, 4);

$wm_wikis = number_format($wm_wikis, 0, ',', ' ');
$wm_good = number_format($wm_good, 0, ',', ' ');
$wm_total = number_format($wm_total, 0, ',', ' ');
$wm_edits = number_format($wm_edits, 0, ',', ' ');
$wm_admins = number_format($wm_admins, 0, ',', ' ');
$wm_users = number_format($wm_users, 0, ',', ' ');
$wm_ausers = number_format($wm_ausers, 0, ',', ' ');
$wm_images = number_format($wm_images, 0, ',', ' ');

$grandstubratio = $grandstubratio / $count;
$grandstubratio = round($grandstubratio, 4);
$grandstubratio = number_format($grandstubratio, 4);


$gwikis = number_format($gwikis, 0, ',', ' ');
$ggood =number_format($ggood, 0, ',', ' ');
$gtotal = number_format($gtotal, 0, ',', ' ');
$gedits = number_format($gedits, 0, ',', ' ');
$gadmins = number_format($gadmins, 0, ',', ' ');
$gusers = number_format($gusers, 0, ',', ' ');
$gausers = number_format($gusers, 0, ',', ' ');
$gimages = number_format($gimages, 0, ',', ' ');


# Check existence of format links and color green or red


$list_names = array("largest", "wikimedias");
$file_formats = array("html", "wiki");


foreach ($list_names as &$list_name) {
    foreach ($file_formats as &$file_format) {
        $filename = $list_name . "_" . $file_format . ".php";

        if (file_exists($filename)) {
            $color[$file_format] = "#66CCAA";
        } else {
            $color[$file_format] = "#FF6600";
        }
    }
}


echo <<<TFOOT
        </tbody><tfoot><tr>
            <th class="sub">&#8470;</th>
            <th class="sub">Project</th>
            <th class="sub">&#8470; of wikis</th>
            <th class="sub">Good articles</th>
            <th class="sub">Total pages</th>
            <th class="sub">Edits</th>
            <th class="sub">Files</th>
            <th class="sub">Users</th>
            <th class="sub">Active Users</th>
            <th class="sub">Admins</th>
            <th class="sub">Stub ratio</th>
            <th class="sub" colspan="4">Formats</th>
            <th class="sub">Last update</th>
        </tr></tfoot>
</table></div>
TFOOT;

echo <<<ALSOSEE

<hr />
<ul><li><a href="./largest_html.php">largest (html)</a ></li></ul>
<ul><li><a href="./largest_csv.php">largest (csv)</a ></li></ul>
<ul><li><a href="./largest_wiki.php">largest (wiki)</a ></li></ul>
<ul><li><a href="./wikimedias_html.php">wikimedias (html)</a ></li></ul>
<ul><li><a href="./wikimedias_csv.php">wikimedias (csv)</a ></li></ul>
<ul><li><a href="./wikimedias_wiki.php">wikimedias (wiki)</a ></li></ul>
<ul><li><a href="./rank.php">ranks</a></li></ul>
<ul><li><a href="https://phabricator.wikimedia.org/tag/vps-project-wikistats/">bugs</a></li></ul>
ALSOSEE;

# Footer / W3C
echo <<<FOOTER
<ul><li><a href="http://validator.w3.org/check?uri=https://wikistats.wmcloud.org/index.php">validate html</a></li></ul>
<ul><li><a href="https://gerrit.wikimedia.org/r/admin/repos/operations/puppet">source (puppet)</a></li></ul>
<ul><li><a href="https://gerrit.wikimedia.org/r/admin/repos/operations/debs/wikistats">source (PHP)</a></li></ul>

FOOTER;
echo "<ul><li> Last modified:<br />";
echo " ".date("F d Y - H:i:s", getlastmod());
echo "</li></ul></body></html>";

?>

