<?php
# Wikistats by mutante of S23 Wiki - 2006
# List of largest Wikis
header('Last-Modified: '.getlastmod());
header('Content-type: text/html; charset=utf-8');

$listname="List of largest Mediawikis";
$listtable="wikistats";
$wikioutput="wikis_wiki.php";
$wikipage="http://meta.wikimedia.org/wiki/List_of_largest_wikis";

require_once("/etc/wikistats/config.php");
require_once("$IP/functions.php");

mysql_connect("$dbhost", "$dbuser", "$dbpass") or die(mysql_error());


if (isset($_GET['th']) && is_numeric($_GET['th']) && $_GET['th'] >= 0 && $_GET['th'] < 10000000) {
    $threshold=$_GET['th'];
    $threshold=htmlspecialchars(mysql_real_escape_string($threshold));
    $threshold_wp=$threshold;
} else {
    $threshold=0;
    $threshold_wp=0;
}

if (isset($_GET['lines']) && is_numeric($_GET['lines']) && $_GET['lines'] > 0 && $_GET['lines'] < 10001) {
    $limit=$_GET['lines'];
    $limit=htmlspecialchars(mysql_real_escape_string($limit));
} else {
    $limit="200";
}

include("$IP/sortswitch.php");

mysql_select_db("$dbname") or die(mysql_error());

$countquery = "SELECT count(id) AS count,'Wikipedia' AS type FROM wikipedias
UNION ALL
SELECT count(id) AS count,'Wiktionary' AS type FROM wiktionaries
UNION ALL
SELECT count(id) AS count,'Wikibooks' AS type FROM wikibooks
UNION ALL
SELECT count(id) AS count,'Wikinews' AS type FROM wikinews
UNION ALL
SELECT count(id) AS count,'Wikiquote' AS type FROM wikiquotes
UNION ALL
SELECT count(id) AS count,'Wikisource' AS type FROM wikisources
UNION ALL
SELECT count(id) AS count,'Wikitravel' AS type FROM wikitravel
UNION ALL
SELECT count(id) AS count,'Wmspecial' AS type FROM wmspecials
UNION ALL
SELECT count(id) AS count,'Wikia' AS type FROM wikia where inactive is null
UNION ALL
SELECT count(id) AS count,'Uncyclomedia' AS type FROM uncyclomedia where statsurl not like '%wikia.com%'
UNION ALL
SELECT count(id) AS count,'Mediawiki' AS type FROM mediawikis where statsurl not like '%opensuse%'
UNION ALL
SELECT count(id) AS count,'Gentoo' AS type FROM gentoo
UNION ALL
SELECT count(id) AS count,'Wikible' AS type FROM wikible
UNION ALL
SELECT count(id) AS count,'openSUSE' AS type FROM opensuse
UNION ALL
SELECT count(id) AS count,'Anarchopedia' AS type FROM anarchopedias
UNION ALL
SELECT count(id) AS count,'Editthis' AS type FROM editthis
UNION ALL
SELECT count(id) AS count,'Gratiswiki' AS type FROM gratiswiki
UNION ALL
SELECT count(id) AS count,'Wikisite' AS type FROM wikisite where inactive is null
UNION ALL
SELECT count(id) AS count,'Wikifur' AS type FROM wikifur
UNION ALL
SELECT count(id) AS count,'Neoseeker' AS type FROM neoseeker
UNION ALL
SELECT count(id) AS count,'Wikiversity' AS type FROM wikiversity
UNION ALL
SELECT count(id) AS count,'Wik.is' AS type FROM wikdotis
UNION ALL
SELECT count(id) AS count,'W3C' AS type FROM w3cwikis
UNION ALL
SELECT count(id) AS count,'Gamepedia' AS type FROM gamepedias
UNION ALL
SELECT count(id) AS count,'Sourceforge' AS type FROM sourceforge
UNION ALL
SELECT count(id) AS count,'Orain' AS type FROM orain
UNION ALL
SELECT count(id) AS count,'Elwiki' AS type FROM elwiki where inactive is null";

$result = mysql_query("$countquery") or die(mysql_error());

while($row = mysql_fetch_array( $result )) {
    $type=$row['type'];
    $wcount[$type]=$row['count'];
    # echo "$type:".$wcount[$type]." ";
}

$wcount['Mediawiki']=$wcount['Mediawiki']+$wcount['Wikitravel'];
# $wcount['Wikimedia'] = $wcount['Wikibooks'] + $wcount['Wikinews'] + $wcount['Wikiquote'] + $wcount['Wikisource'] + $wcount['Wmspecial'];
$wcount['Total'] = $wcount['Wikipedia'] + $wcount['Wiktionary'] + $wcount['Wikimedia'] + $wcount['Wikia'] + $wcount['Uncyclomedia'] + $wcount['Editthis'] + $wcount['Elwiki'] + $wcount['Mediawiki'] + $wcount['Gratiswiki'] + $wcount['Wikible'] + $wcount['openSUSE'] + $wcount['Wikisite'] + $wcount['Wik.is'] + $wcount['Gentoo'] + $wcount['Wikifur'] + $wcount['Neoseeker'] + $wcount['Wikiversity'];

include("$IP/largest_query.php");

$result = mysql_query("$query") or die(mysql_error());

echo <<<DOCHEAD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>WikiStats - ${listname}</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="description" content="various statistics tables about Wikis, Mediawikis, Wikihives, Wikimedia in html,csv,ssv and wikisyntax, updated several times daily" />
<meta name="keywords" content="wiki,statistics,wiki stats,mediawiki,wikimedia,wikipedia,wiki tables,wiki size,wiki growth,csv,ssv,wikisyntax,stats,excel,wikiquotes,wiktionaries,wiktionary,wikibooks,wikisource,wikicities,editthis,list of wikis,largest wikis,wikimedia projects" />
<link href="./css/wikistats_css.php" rel="stylesheet" type="text/css" />
</head>
<body>
DOCHEAD;

$sort=str_replace(" ","_",$sort);
$self=$_SERVER['PHP_SELF'];
$wtotal=$wcount['Total'];

echo <<<TABLEHEAD
<div class="mainleft">
<table><tr>
<th class="head" colspan="11">$listname
<div class="subhead">threshold: good &ge; ${threshold}
<a href="${self}?s=$sort&amp;th=1000000&amp;lines=${wtotal}">1.000.000</a>
<a href="${self}?s=$sort&amp;th=100000&amp;lines=${wtotal}">100.000</a>
<a href="${self}?s=$sort&amp;th=10000&amp;lines=${wtotal}">10.000</a>
<a href="${self}?s=$sort&amp;th=1000&amp;lines=${wtotal}">1.000</a>
<a href="${self}?s=$sort&amp;th=100&amp;lines=${wtotal}">100</a>
<a href="${self}?s=$sort&amp;th=0&amp;lines=${wtotal}">0</a> |
lines: ${limit} : <a href="${self}?s=$sort&amp;th=${threshold}&amp;lines=10">10</a>
 <a href="${self}?s=$sort&amp;th=${threshold}&amp;lines=50">50</a>
<a href="${self}?s=$sort&amp;th=${threshold}&amp;lines=100">100</a>
<a href="${self}?s=$sort&amp;th=${threshold}&amp;lines=250">250</a>
<a href="${self}?s=$sort&amp;th=${threshold}&amp;lines=500">500</a>
<a href="${self}?s=$sort&amp;th=${threshold}&amp;lines=750">750</a>
<a href="${self}?s=$sort&amp;th=${threshold}&amp;lines=1000">1000</a>
<a href="${self}?s=$sort&amp;th=${threshold}&amp;lines=2500">2500</a>
<a href="${self}?s=$sort&amp;th=${threshold}&amp;lines=5000">5000</a>
<a href="${self}?s=$sort&amp;th=${threshold}&amp;lines=${wtotal}">${wtotal}</a>
(max) | this view as <a href="largest_csv.php?s=$sort&amp;th=${threshold}&amp;lines=${limit}">csv</a>
<a href="largest_ssv.php?s=$sort&amp;th=${threshold}&amp;lines=${limit}">ssv</a>
<a href="largest_xml.php?s=$sort&amp;th=${threshold}&amp;lines=${limit}">xml</a>
<a href="largest_wiki.php?s=$sort&amp;th=${threshold}&amp;lines=${limit}">wiki</a>
</div></th></tr>
<tr><th class="sub">&#8470;</th>
<th class="sub">Type (<a class="nodeco" href="${self}?s=type_asc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&uarr;</b></a>
<a class="nodeco" href="${self}?s=type_desc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&darr;</b></a>)</th>
<th class="sub">Name </th>
<th class="sub">Good (<a class="nodeco" href="${self}?s=good_asc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&uarr;</b></a>
<a class="nodeco" href="${self}?s=good_desc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&darr;</b></a>)</th>
<th class="sub">Total (<a class="nodeco" href="${self}?s=total_asc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&uarr;</b></a>
<a class="nodeco" href="${self}?s=total_desc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&darr;</b></a>)</th>
<th class="sub">Edits (<a class="nodeco" href="${self}?s=edits_asc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&uarr;</b></a>
<a class="nodeco" href="${self}?s=edits_desc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&darr;</b></a>)</th>
<th class="sub">Admins (
<a class="nodeco" href="${self}?s=admins_asc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&uarr;</b></a>
<a class="nodeco" href="${self}?s=admins_desc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&darr;</b></a>)</th>
<th class="sub">Users (<a class="nodeco" href="${self}?s=users_asc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&uarr;</b></a>
<a class="nodeco" href="${self}?s=users_desc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&darr;</b></a>)</th>
<th class="sub">Images (<a class="nodeco" href="${self}?s=images_asc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&uarr;</b></a>
<a class="nodeco" href="${self}?s=images_desc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&darr;</b></a>)</th>
<th class="sub">Stub Ratio (<a class="nodeco" href="${self}?s=ratio_asc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&uarr;</b></a>
<a class="nodeco" href="${self}?s=ratio_desc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&darr;</b></a>)</th>
<th class="sub">Version (<a class="nodeco" href="${self}?s=version_asc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&uarr;</b></a>
<a class="nodeco" href="${self}?s=version_desc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&darr;</b></a>)</th>
<th class="sub" align="right">Last checked (<a class="nodeco" href="${self}?s=ts_asc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&uarr;</b></a>
<a class="nodeco" href="${self}?s=ts_desc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&darr;</b></a>)</th>
<th class="sub" align="right">HTTP (<a class="nodeco" href="${self}?s=http_asc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&uarr;</b></a>
<a class="nodeco" href="${self}?s=http_desc&amp;th=${threshold}&amp;lines=${limit}">
<b class="arrow">&darr;</b></a>)</th>
<th class="sub">ID</th>
</tr>
TABLEHEAD;

$count=1;
$gtotal=0;
$ggood=0;
$gedits=0;
$gadmins=0;
$gimages=0;
$gusers=0;

while($row = mysql_fetch_array( $result )) {

    $gtotal=$gtotal+$row['total'];
    $ggood=$ggood+$row['good'];
    $gedits=$gedits+$row['edits'];
    $gadmins=$gadmins+$row['admins'];
    $gusers=$gusers+$row['users'];
    $gimages=$gimages+$row['images'];

    switch ($row['type']) {
    case "Wikipedia":
        $name=$row['prefix'].".wikipedia";
        $url="http://".$row['prefix'].".wikipedia.org/wiki/";
    break;

    case "Wiktionary":
        $name=$row['prefix'].".wiktionary";
        $url="http://".$row['prefix'].".wiktionary.org/wiki/";
    break;

    case "Wikibooks":
        $name=$row['prefix'].".wikibooks";
        $url="http://".$row['prefix'].".wikibooks.org/wiki/";
    break;

    case "Wikinews":
        $name=$row['prefix'].".wikinews";
        $url="http://".$row['prefix'].".wikinews.org/wiki/";
    break;

    case "Wikisource":
        $name=$row['prefix'].".wikisource";
        $url="http://".$row['prefix'].".wikisource.org/wiki/";
    break;

    case "Wikitravel":
        $name=$row['prefix'].".wikitravel";
        $url="http://wikitravel.org/".$row['prefix']."/";
    break;

    case "Wikiquote":
        $name=$row['prefix'].".wikiquote";
        $url="http://".$row['prefix'].".wikiquote.org/wiki/";
    break;

    case "Mediawiki":
        $name=$row['lang'];
        $surl=htmlspecialchars($row['prefix']);
        $url=explode("S",$row['prefix']);
        $url=$url[0];
        $url=htmlspecialchars($url);
    break;

    case "Wikifur":
        $name=$row['lang'];
        $surl=htmlspecialchars($row['prefix']);
        $url=explode("S",$row['prefix']);
        $url=$url[0];
        $url=htmlspecialchars($url);
    break;

    case "Gentoo":
        $name=$row['lang'];
        $surl=htmlspecialchars($row['prefix']);
        $url=explode("S",$row['prefix']);
        $url=$url[0];
        $url=htmlspecialchars($url);
    break;

    case "Wikible":
        $name=$row['lang'];
        $surl=htmlspecialchars($row['prefix']);
        $url=explode("S",$row['prefix']);
        $url=$url[0];
        $url=htmlspecialchars($url);
    break;

    case "openSUSE":
        $name=$row['lang'];
        $url=explode("S",$row['prefix']);
        $url=$url[0];
        $url=htmlspecialchars($url);
    break;

    case "Uncyclomedia":
        $name=$row['lang']." Uncyclopedia";
        $url=$row['prefix'];
        $url=explode("/",$url);
        $url=$url[2];
        $url="http://".$url."/wiki/";
    break;

    case "Wikia":
        $name=$row['lang'].".wikia";
        $url="http://".$name.".com/wiki/";
    break;

    case "Neoseeker":
        $name=$row['lang'];
        $url="http://".$row['lang'].".neoseeker.com/wiki/";
    break;

    case "Wik.is":
        $name=$row['lang'].".wik.is";
        $url="http://".$row['lang'].".wik.is/";
    break;

    case "Wmspecial":
        $name=$row['prefix'];
        $url="http://".$row['lang']."/wiki/";
    break;

    case "Editthis":
        $name=$row['lang'].".editthis";
        $url=explode("index.php",$row['prefix']);
        $url=$url[0];
        $url=htmlspecialchars($url)."/";
    break;

    case "Elwiki":
        $name=$row['lang'].".elwiki";
        $url="http://".$row['lang'].".elwiki.com/";
    break;

    case "Gratiswiki":
        $name=$row['lang'].".gratis-wiki";
        $url="http://www.gratis-wiki.com/".$row['lang']."/index.php";
    break;

    case "Wikisite":
        $name=$row['prefix'].".wiki-site";
        $url="http://".$row['prefix'].".wiki-site.com/index.php/";
    break;

    case "Anarchopedia":
        $name=$row['lang']." Anarchopedia";
        $url="http://".$row['prefix'].".anarchopedia.org/";
    break;

    case "Wikiversity":
        $name=$row['lang']." Wikiversity";
        $url="http://".$row['prefix'].".wikiversity.org/";
    break;

    case "Qweki":
        $name=$row['lang']." Qweki";
        $url="http://".$row['prefix'].".qweki.com/";
    break;

    default:
        $name=$row['lang']." ".$row['type'];
    }

    # color old timestamps
    if ($row['oldness'] > $ts_limit_crit){
        $tsclass="timestamp-crit";
    } elseif ($row['oldness'] > $ts_limit_warn){
        $tsclass="timestamp-warn";
    } else {
        $tsclass="timestamp-ok";
    }

    $typeclass=strtolower($row['type']);

    echo "
    <tr><td class=\"number\">${count}</td>
    <td class=\"${typeclass}\">".$row['type']."</td>
    <td class=\"text\"><a href=\"".$url."\">".$name."</a></td>";

    if ($row['type'] == "Mediawiki") {
        echo "<td class=\"number\"><a href=\"".$surl."\">".$row['good']."</a></td>";
    } elseif ($row['type'] == "Gratiswiki" OR $row['type'] == "Anarchopedia") {
        echo "<td class=\"number\"><a href=\"".$url."?title=Special:Statistics&amp;action=raw\">".$row['good']."</a></td>";
    } elseif ($row['type'] == "Wikia") {
        echo "<td class=\"number\"><a href=\"".$url."Special:Statistics&amp;action=raw\">".$row['good']."</a></td>";
    } else {
        echo "<td class=\"number\"><a href=\"".$url."Special:Statistics?action=raw\">".$row['good']."</a></td>";
    }

    if (isset($row['si_generator'])) {
        $wikiversion=str_replace("MediaWiki ","",$row['si_generator']);
    } else {
        $wikiversion=str_replace("MediaWiki ","",$row['version']);;
    }

    echo "
<td class=\"number\">".$row['total']."</td>
<td class=\"number\"><a href=\"${url}Special:Recentchanges\">".$row['edits']."</a></td>
<td class=\"number\"><a href=\"${url}Special:Listadmins\">".$row['admins']."</a></td>
<td class=\"number\"><a href=\"${url}Special:Listusers\">".$row['users']."</a></td>
<td class=\"number\"><a href=\"${url}Special:Imagelist\">".$row['images']."</a></td>

<td class=\"number\"> ".$row['ratio']." </td>
<td class=\"number " .version_color($wikiversion)."\"><a href=\"${url}Special:Version\">${wikiversion}</a></td>
<td class=\"timestamp ${tsclass}\">".$row['ts']."</td><td class=\"number\">".$row['http']."</td><td class=\"number\">".$row['id']."</td></tr>\n";

    $count++;
}

print <<<LEGEND
</table><br />
<div id="legend" class="legend">
<table>
<tr><th class="head" colspan="2">Legend / Totals</th></tr>
<tr><th class="sub"> color </th>
<th class="sub"> class </th>
<th class="sub"> in db </th></tr>

<tr><td class="wikipedia"></td>
<td>Wikipedias</td>
<td align="right">{$wcount['Wikipedia']}</td></tr>

<tr><td class="wiktionary"></td>
<td>Wiktionaries</td>
<td align="right">{$wcount['Wiktionary']}</td></tr>

<tr><td class="wikibooks"></td>
<td>Wikibooks</td>
<td align="right">{$wcount['Wikibooks']}</td></tr>

<tr><td class="wikinews"></td>
<td>Wikinews</td>
<td align="right">{$wcount['Wikinews']}</td></tr>

<tr><td class="wikiquote"></td>
<td>Wikiquotes</td>
<td align="right">{$wcount['Wikiquote']}</td></tr>

<tr><td class="wikibooks"></td>
<td>Wikisources</td>
<td align="right">{$wcount['Wikisource']}</td></tr>

<tr><td class="special"></td>
<td>Wikimedia Special</td>
<td align="right">{$wcount['Wmspecial']}</td></tr>

<tr><td class="wikia"></td>
<td>Wikia Wiki</td><td align="right">{$wcount['Wikia']}</td></tr>

<tr><td class="uncyclomedia"></td>
<td>Uncyclomedia</td><td align="right">{$wcount['Uncyclomedia']}</td></tr>

<tr><td class="editthis"></td>
<td>Editthis</td><td align="right">{$wcount['Editthis']}</td></tr>

<tr><td class="elwiki"></td>
<td>Elwiki</td><td align="right">{$wcount['Elwiki']}</td></tr>

<tr><td class="gratiswiki"></td>
<td>Gratiswiki</td><td align="right">{$wcount['Gratiswiki']}</td></tr>

<tr><td class="wiki-site"></td>
<td>Wiki-Site</td><td align="right">{$wcount['Wikisite']}</td></tr>

<tr><td class="anarchopedia"></td>
<td>Anarchopedia</td><td align="right">{$wcount['Anarchopedia']}</td></tr>

<tr><td class="opensuse"></td>
<td>openSUSE</td><td align="right">{$wcount['openSUSE']}</td></tr>

<tr><td class="wikitravel"></td>
<td>Wikitravel</td><td align="right">{$wcount['Wikitravel']}</td></tr>

<tr><td class="wikible"></td>
<td>Wikible</td><td align="right">{$wcount['Wikible']}</td></tr>

<tr><td class="wikidotis"></td>
<td>Wik.is</td><td align="right">{$wcount['Wik.is']}</td></tr>

<tr><td class="wikiversity"></td>
<td>Wikiversity</td><td align="right">{$wcount['Wikiversity']}</td></tr>

<tr><td class="wikifur"></td>
<td>Wikifur</td><td align="right">{$wcount['Wikifur']}</td></tr>

<tr><td class="neoseeker"></td>
<td>Neoseeker</td><td align="right">{$wcount['Neoseeker']}</td></tr>

<tr><td class="mediawiki"></td>
<td>Other (private) Mediawiki</td><td align="right">{$wcount['Mediawiki']}</td>
</tr>

<tr><th></th><th>Total:</th>
<th class="sub">{$wcount['Total']}</th></tr>
</table><br /></div>
LEGEND;

include("$IP/grandtotal.php");
include("$IP/footer.php");
?>
</div>
</body>
</html>
