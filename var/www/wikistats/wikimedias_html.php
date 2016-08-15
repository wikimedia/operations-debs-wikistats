<?php
# Wikistats by mutante - 2006-03 - S23 Wiki - http://s23.org
header('Last-Modified: '.getlastmod());
header('Content-type: text/html; charset=utf-8');

$listname="All Wikimedia Projects by Size";
$listtable="wikimedias";
$wikioutput="wikimedias_wiki.php";
$wikipage="none_yet";

require_once("/etc/wikistats/config.php");
require_once("$IP/functions.php");

mysql_connect("$dbhost", "$dbuser", "$dbpass") or die(mysql_error());

if (isset($_GET['th']) && is_numeric($_GET['th']) && $_GET['th'] >= 0 && $_GET['th'] < 10000000) {
    $threshold=$_GET['th'];
    $threshold=htmlspecialchars(mysql_real_escape_string($threshold));
} else {
    $threshold=0;
}

if (isset($_GET['lines']) && is_numeric($_GET['lines']) && $_GET['lines'] > 0 && $_GET['lines'] < 10001) {
    $limit=$_GET['lines'];
    $limit=htmlspecialchars(mysql_real_escape_string($limit));
} else {
    $limit="200";
}

include("$IP/sortswitch.php");

mysql_select_db("$dbname") or die(mysql_error());

$countquery = "SELECT count(id) AS count,'Wikipedia' AS type FROM wikipedias where prefix is not null
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
SELECT count(id) AS count,'Wikiversity' AS type FROM wikiversity
UNION ALL
SELECT count(id) AS count,'Wikivoyage' AS type FROM wikivoyage
UNION ALL
SELECT count(id) AS count,'Wmspecial' AS type FROM wmspecials";

$result = mysql_query("$countquery") or die(mysql_error());

while($row = mysql_fetch_array( $result )) {
    $type=$row['type'];
    $wcount[$type]=$row['count'];
    # echo "$type:".$wcount[$type]." ";
}

$wcount['Total'] = $wcount['Wikipedia'] + $wcount['Wiktionary'] + $wcount['Wikibooks'] + $wcount['Wikinews'] + $wcount['Wikiquote'] + $wcount['Wikisource'] + $wcount['Wmspecial'] + $wcount['Wikiversity'] + $wcount['Wikivoyage'];

$query = <<<FNORD
(SELECT prefix,good,lang,loclang,loclanglink,total,edits,admins,users,images,si_generator,version,ts,'wikipedia' AS type,good/total AS ratio,method FROM wikipedias where prefix is not null and good >= ${threshold})
 UNION ALL (SELECT prefix,good,lang,loclang,loclanglink,total,edits,admins,users,images,si_generator,version,ts,'wikisource' AS type,good/total AS ratio,method FROM wikisources where good >= ${threshold})
 UNION ALL (SELECT prefix,good,lang,loclang,loclanglink,total,edits,admins,users,images,si_generator,version,ts,'wiktionary' AS type,good/total AS ratio,method FROM wiktionaries where good >= ${threshold})
 UNION ALL (SELECT prefix,good,lang,loclang,loclanglink,total,edits,admins,users,images,si_generator,version,ts,'wikiquote' AS type,good/total AS ratio,method FROM wikiquotes where good >= ${threshold})
 UNION ALL (SELECT prefix,good,lang,loclang,loclanglink,total,edits,admins,users,images,si_generator,version,ts,'wikiversity' AS type,good/total AS ratio,method FROM wikiversity where good >= ${threshold})
 UNION ALL (SELECT prefix,good,lang,loclang,loclanglink,total,edits,admins,users,images,si_generator,version,ts,'wikibooks' AS type,good/total AS ratio,method FROM wikibooks where good >= ${threshold})
 UNION ALL (SELECT prefix,good,lang,loclang,loclanglink,total,edits,admins,users,images,si_generator,version,ts,'wikinews' AS type,good/total AS ratio,method FROM wikinews where good >= ${threshold})
 UNION ALL (SELECT prefix,good,lang,loclang,loclanglink,total,edits,admins,users,images,si_generator,version,ts,'wikivoyage' AS type,good/total AS ratio,method FROM wikivoyage where good >= ${threshold})
 UNION ALL (SELECT url,good,lang,loclang,loclanglink,total,edits,admins,users,images,si_generator,version,ts,'special' AS type,good/total AS ratio,method FROM wmspecials where good >= ${threshold})
 ORDER BY ${msort} LIMIT ${limit};
FNORD;

# echo "query: '$query'.<br /><br />";
$result = mysql_query("$query") or die(mysql_error());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<?php
echo "<title>WikiStats - $listname</title>\n<link href=\"./css/wikistats_css.php\" rel=\"stylesheet\" type=\"text/css\" /></head>\n\n<body>\n";

$sort=str_replace(" ","_",$sort);
$self=$_SERVER['PHP_SELF'];

print <<<TABLE_HEAD

<div id="main" style="float:left;width:80%;">
<table>
<tr><th class="head" colspan="11">${listname}
<div style="font-size: 60%">threshold: good &ge; ${threshold}
<a href="${self}?s=${sort}&amp;th=1000000&amp;lines=${wcount['Total']}">1.000.000</a>
<a href="${self}?s=${sort}&amp;th=100000&amp;lines=${wcount['Total']}">100.000</a>
<a href="${self}?s=${sort}&amp;th=10000&amp;lines=${wcount['Total']}">10.000</a>
<a href="${self}?s=${sort}&amp;th=1000&amp;lines=${wcount['Total']}">1.000</a>
<a href="${self}?s=${sort}&amp;th=100&amp;lines=${wcount['Total']}">100</a>
<a href="${self}?s=${sort}&amp;th=0&amp;lines=${wcount['Total']}">0</a>
|  lines: $limit : <a href="${self}?s=${sort}&amp;th=0&amp;lines=10">10</a>
<a href="${self}?s=${sort}&amp;th=0&amp;lines=50">50</a>
<a href="${self}?s=${sort}&amp;th=0&amp;lines=100">100</a>
<a href="${self}?s=${sort}&amp;th=0&amp;lines=250">250</a>
<a href="${self}?s=${sort}&amp;th=0&amp;lines=500">500</a>
<a href="${self}?s=${sort}&amp;th=0&amp;lines=${wcount['Total']}">${wcount['Total']}</a>
(max)</div></th></tr>
<tr><th class="sub">&#8470;</th>
<th class="sub">Project (<a style="text-decoration:none;" href="${self}?s=prefix_asc">
<b style="font-size: 120%;">&uarr;</b></a><a style="text-decoration:none;" href="${self}?s=prefix_desc">
<b style="font-size: 120%;">&darr;</b></a>)
/ Type (<a style="text-decoration:none;" href="${self}?s=type_asc">
<b style="font-size: 120%;">&uarr;</b></a>
<a style="text-decoration:none;" href="${self}?s=type_desc">
<b style="font-size: 120%;">&darr;</b></a>)</th>
<th class="sub">Language (<a style="text-decoration:none;" href="${self}?s=lang_asc">
<b style="font-size: 120%;">&uarr;</b></a><a style="text-decoration:none;" href="${self}?s=lang_desc">
<b style="font-size: 120%;">&darr;</b></a>)</th>
<th class="sub">Language (local) (
<a style="text-decoration:none;" href="${self}?s=loclang_asc">
<b style="font-size: 120%;">&uarr;</b></a>
<a style="text-decoration:none;" href="${self}?s=loclang_desc">
<b style="font-size: 120%;">&darr;</b></a>)</th>
<th class="sub">Good (<a style="text-decoration:none;" href="${self}?s=good_asc">
<b style="font-size: 120%;">&uarr;</b></a>
<a style="text-decoration:none;" href="${self}?s=good_desc">
<b style="font-size: 120%;">&darr;</b></a>)</th>
<th class="sub">Total (<a style="text-decoration:none;" href="${self}?s=total_asc">
<b style="font-size: 120%;">&uarr;</b></a>
<a style="text-decoration:none;" href="${self}?s=total_desc">
<b style="font-size: 120%;">&darr;</b></a>)</th>
<th class="sub">Edits (<a style="text-decoration:none;" href="${self}?s=edits_asc">
<b style="font-size: 120%;">&uarr;</b></a>
<a style="text-decoration:none;" href="${self}?s=edits_desc">
<b style="font-size: 120%;">&darr;</b></a>)</th>
<th class="sub">Admins (<a style="text-decoration:none;" href="${self}?s=admins_asc">
<b style="font-size: 120%;">&uarr;</b></a>
<a style="text-decoration:none;" href="${self}?s=admins_desc">
<b style="font-size: 120%;">&darr;</b></a>)</th>
<th class="sub">Users (<a style="text-decoration:none;" href="${self}?s=users_asc">
<b style="font-size: 120%;">&uarr;</b></a>
<a style="text-decoration:none;" href="${self}?s=users_desc">
<b style="font-size: 120%;">&darr;</b></a>)</th>
<th class="sub">Files (<a style="text-decoration:none;" href="${self}?s=images_asc">
<b style="font-size: 120%;">&uarr;</b></a>
<a style="text-decoration:none;" href="${self}?s=images_desc">
<b style="font-size: 120%;">&darr;</b></a>)</th>
<th class="sub">Stub Ratio (<a style="text-decoration:none;" href="${self}?s=ratio_asc">
<b style="font-size: 120%;">&uarr;</b></a>
<a style="text-decoration:none;" href="${self}?s=ratio_desc">
<b style="font-size: 120%;">&darr;</b></a>)</th>
<th class="sub">Version (<a style="text-decoration:none;" href="${self}?s=version_asc&amp;th=${threshold}&amp;lines=${limit}">
<b style="font-size: 120%;">&uarr;</b></a>
<a style="text-decoration:none;" href="${self}?s=version_desc&amp;th=${threshold}&amp;lines=${limit}">
<b style="font-size: 120%;">&darr;</b></a>)</th>
<th class="sub">mt (<a style="text-decoration:none;" href="${self}?s=stype_asc&amp;th=${threshold}&amp;lines=${limit}">
<b style="font-size: 120%;">&uarr;</b></a>
<a style="text-decoration:none;" href="${self}?s=stype_desc&amp;th=${threshold}&amp;lines=${limit}">
<b style="font-size: 120%;">&darr;</b></a>)</th>
<th class="sub" align="right">Last checked (<a style="text-decoration:none;" href="${self}?s=ts_asc">
<b style="font-size: 120%;">&uarr;</b></a>
<a style="text-decoration:none;" href="${self}?s=ts_desc"><b style="font-size: 120%;">&darr;</b></a>)
</th></tr>

TABLE_HEAD;

$count=1;
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

    if (isset($row['si_generator'])) {
        $wikiversion=str_replace("MediaWiki ","",$row['si_generator']);
    } else {
        $wikiversion=$row['version'];
    }

    switch ($row['type']) {
        case "wikipedia":
            $color="#ffffff";
        break;
        case "wiktionary":
            $color="#ff8080";
        break;
        case "wikisource":
            $color="#ffcc11";
        break;
        case "wikiquote":
            $color="blue";
        break;
        case "wikibooks":
            $color="purple";
        break;
        case "wikinews":
            $color="green";
        break;
        case "special":
            $color="red";
        break;
        case "wikiversity":
            $color="#bb77ff";
        break;
        case "wikivoyage":
            $color="#e56717";
        break;
    default:
        $color="white";
    }

    $stype=$row['method'];

    #$domain=$row['type'].".org";
    #$vurl="http://".$row['prefix'].".$domain/wiki/Special:Version";
    $vurl="http://".$row['prefix']."/wiki/Special:Version";

    if ($row['type'] == "special") {
        $pieces = explode(".", $row['prefix']);
        $label = $pieces[0].".".$pieces[1];
        $prefix = $pieces[0];
        if ($prefix == "wikimediafoundation") {
            $prefix = "foundation";
        }

    echo "<tr><td class=\"number\">$count</td>
<td style=\"color:black;background-color:$color;\"><a href=\"http://".$row['prefix']."/wiki/\">$label</a></td>
<td class=\"text\"><a href=\"http://en.wikipedia.org/wiki/".str_replace(" ","_",$row['lang'])."_language\">".$row['lang']."</a></td>
<td class=\"text\"><a href=\"http://".$row['prefix'].".wikipedia.org/wiki/".$row['loclanglink']."\">".$row['loclang']."</a></td>
<td class=\"number\"><a href=\"http://".$row['prefix']."/wiki/Special:Statistics?action=raw\">".$row['good']."</a></td>
<td class=\"number\">".$row['total']."</td>
<td class=\"number\"><a href=\"http://".$row['prefix']."/wiki/Special:Recentchanges\">".$row['edits']."</a></td>
<td class=\"number\"><a href=\"http://".$row['prefix']."/wiki/Special:Listadmins\">".$row['admins']."</a></td>
<td class=\"number\"><a href=\"http://".$row['prefix']."/wiki/Special:Listusers\">".$row['users']."</a></td>
<td class=\"number\"><a href=\"http://".$row['prefix']."/wiki/Special:ListFiles\">".$row['images']."</a></td>
<td class=\"number\">".$row['ratio']."</td>
<td class=\"number " .version_color($wikiversion)."\"><a href=\"${vurl}\">${wikiversion}</a></td>
<td class=\"text\"><div title=\"$get_method[$stype]\">".$stype."</div></td>
<td style=\"font-size: 80%;\" class=\"timestamp\">".$row['ts']."</td></tr>\n";

    } else {

    echo "<tr><td class=\"number\">$count</td><td style=\"color:black;background-color:$color;\"><a href=\"http://".$row['prefix'].".$domain/wiki/\">".$row['prefix'].".".$row['type']."</a></td>
<td class=\"text\"><a href=\"http://en.wikipedia.org/wiki/".str_replace(" ","_",$row['lang'])."_language\">".$row['lang']."</a></td>
<td class=\"text\"><a href=\"http://".$row['prefix'].".wikipedia.org/wiki/".$row['loclanglink']."\">".$row['loclang']."</a></td>
<td class=\"number\"><a href=\"http://".$row['prefix'].".$domain/wiki/Special:Statistics?action=raw\">".$row['good']."</a></td>
<td class=\"number\">".$row['total']."</td>
<td class=\"number\"><a href=\"http://".$row['prefix'].".$domain/wiki/Special:Recentchanges\">".$row['edits']."</a></td>
<td class=\"number\"><a href=\"http://".$row['prefix'].".$domain/wiki/Special:Listadmins\">".$row['admins']."</a></td>
<td class=\"number\"><a href=\"http://".$row['prefix'].".$domain/wiki/Special:Listusers\">".$row['users']."</a></td>
<td class=\"number\"><a href=\"http://".$row['prefix'].".$domain/wiki/Special:ListFiles\">".$row['images']."</a></td>
<td class=\"number\">".$row['ratio']."</td>
<td class=\"number " .version_color($wikiversion)."\"><a href=\"${vurl}\">${wikiversion}</a></td>
<td class=\"text\"><div title=\"$get_method[$stype]\">".$stype."</div></td>
<td style=\"font-size: 80%;\" class=\"timestamp\">".$row['ts']."</td></tr>\n";
    }
$count++;
}

print <<<LEGEND
</table>

<div id="legend" style="float:right;width:20%;">
<table style="margin: 10px;">
<tr><th class="head" colspan="2">Legend</th>
</tr><tr>
<th class="sub">color</th>
<th class="sub">class</th>
</tr><tr>
<td class="text" style="color:black;background-color:#ffffff"></td>
<td>Wikipedia</td>
</tr><tr>
<td class="text" style="color:black;background-color:#ff8080"></td>
<td>Wiktionary</td>
</tr><tr>
<td class="text" style="color:black;background-color:#ffcc11"></td>
<td>Wikisource</td>
</tr><tr>
<td class="text" style="color:black;background-color:blue"></td>
<td>Wikiquote</td>
</tr><tr>
<td class="text" style="color:black;background-color:purple"></td>
<td>Wikibooks</td>
</tr><tr>
<td class="text" style="color:black;background-color:green"></td>
<td>Wikinews</td>
</tr><tr>
<td class="text" style="color:black;background-color:#bb77ff"></td>
<td>Wikiversity</td>
</tr><tr>
<td class="text" style="color:black;background-color:#e56717"></td>
<td>Wikivoyage</td>
</tr><tr>
<td class="text" style="color:black;background-color:red"></td>
<td>Special</td>
</tr></table></div>

LEGEND;

include ("$IP/grandtotal.php");
include ("$IP/footer.php");
?>
</div>
</body></html>
