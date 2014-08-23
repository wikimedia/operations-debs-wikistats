<?php
# Wikistats by mutante - 2006-02-08 - S23 Wiki - http://s23.org
#
require_once("/etc/wikistats/config.php");

mysql_connect("$dbhost", "$dbuser", "$dbpass") or die(mysql_error());
mysql_select_db("$dbname") or die(mysql_error());

if (isset($_GET['th']) && is_numeric($_GET['th']) && $_GET['th'] >= $default_threshold_min && $_GET['th'] < $default_threshold_max ) {
    $threshold=$_GET['th'];
    $threshold=mysql_escape_string($threshold);
} else {
    $threshold=0;
}

if (isset($_GET['lines']) && is_numeric($_GET['lines']) && $_GET['lines'] > $default_lines_min  && $_GET['lines'] < $default_lines_max) {
    $limit=$_GET['lines'];
    $limit=mysql_escape_string($limit);
} else {
        $limit=5000;
}

include("$IP/sortswitch.php");
include("$IP/largest_query.php");

$result = mysql_query("$query") or die(mysql_error());
?>

<pre>
{| border="1" cellpadding="2" cellspacing="0" style="background: #f9f9f9; border: 1px solid #aaaaaa; border-collapse: collapse; white-space: nowrap; text-align: left" class="sortable"
|-
! &#8470;
! Wiki
! Good
! Total
! Admins
! Users
! Edits
! Views
! Images
! Updated (CET)
<?php
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

    switch ($row['type']) {
        case "Wikipedia":
            $name=$row['prefix'].".wikipedia";
            $url="//".$row['prefix'].".wikipedia.org/wiki/";
            $color="#F2FC53";
        break;

        case "Wiktionary":
            $name=$row['prefix'].".wiktionary";
            $url="//".$row['prefix'].".wiktionary.org/wiki/";
            $color="#ff8080";
        break;

        case "Wikibooks":
            $name=$row['prefix'].".wikibooks";
            $url="//".$row['prefix'].".wikibooks.org/wiki/";
            $color="#ffffff";
        break;

        case "Wikinews":
            $name=$row['prefix'].".wikinews";
            $url="//".$row['prefix'].".wikinews.org/wiki/";
            $color="#ffffff";
        break;

        case "Wikisource":
            $name=$row['prefix'].".wikisource";
            $url="//".$row['prefix'].".wikisource.org/wiki/";
            $color="#ffffff";
        break;

        case "Wikitravel":
            $name=$row['prefix'].".wikitravel";
            $url="//wikitravel.org/".$row['prefix']."/";
            $color="#90EE90";
        break;

        case "Mediawiki":
            $name=$row['lang'];
            $url=explode("S",$row['prefix']);
            $url=$url[0];
            $url=htmlspecialchars($url);
            $color="#90EE90";
        break;

        case "openSUSE":
            $name=$row['lang'];
            $url=explode("S",$row['prefix']);
            $url=$url[0];
            $url=htmlspecialchars($url);
            $color="#90EE90";
        break;

        case "Richdex":
            $name=$row['lang'];
            $url=explode("S",$row['prefix']);
            $url=$url[0];
            $url=htmlspecialchars($url);
            $color="#00BFFF";
        break;

        case "Uncyclomedia":
            $name=$row['lang']." Uncyclopedia";
            $url=$row['prefix'];
            $url=explode("/",$url);
            $url=$url[2];
            $url="//".$url."/wiki/";
            $color="#bb77ff";
        break;

        case "Wikiquote":
            $name=$row['prefix'].".wikiquote";
            $url="//".$row['prefix'].".wikiquote.org/";
            $color="#ffffff";
        break;

        case "Wikia":
            $name=$row['lang'].".wikia";
            $url="//".$name.".com/wiki/";
            $color="#66cc11";
        break;

        case "Wmspecial":
            $name=$row['prefix'];
            $url="//".$row['lang']."/wiki/";
            $color="#ffffff";
        break;

        case "Editthis":
            $name=$row['lang'].".editthis";
            $url=explode("index.php",$row['prefix']);
            $url=$url[0];
            $url=htmlspecialchars($url);
            $color="#FF0033";
        break;

        case "Elwiki":
            $name=$row['lang'].".elwiki";
            $url="//".$row['lang'].".elwiki.com/";
            $color="#aa00aa";
        break;

        case "Anarchopedia":
            $name=$row['lang']." Anarchopedia";
            $url="//".$row['prefix'].".anarchopedia.org/index.php/";
            $color="#000000";
        break;

        case "Qweki":
            $name=$row['lang']." Qweki";
            $url="//".$row['prefix'].".qweki.com/";
            $color="#00BFFF";
        break;

        default:
            $name=$row['lang']." ".$row['type'];
        }

print <<<TABLEROW
|- style="text-align: right;"
| $count
| bgcolor=$color| [$url $name] 
| [$url."Special:Statistics?action=raw '''{$row['good']}''']
| {$row['total']}
| [$url."Special:Listadmins {$row['admins']}]
| [$url."Special:Listusers {$row['users']}]
| [$url."Special:Recentchanges {$row['edits']}]
| {$row['views']}
| [$url."Special:Imagelist {$row['images']}]
| style="font-size: 70%; white-space:nowrap" | {$row['ts']}
TABLEROW;

    $count++;
}

mysql_close();

echo "|}\n\n";
include ("grandtotal_wiki.php");

echo "\n=== Legend === \n{| border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"background: #f9f9f9; border: 1px solid #aaaaaa; border-collapse: collapse; white-space: nowrap;\"
|-
! color
|- style=\"color:black;background-color:#F2FC53\"
| Wikipedia
|- style=\"color:black;background-color:#ff8080\"
| Wiktionary
|- style=\"color:black;background-color:#ffffff\"
| Other Wikimedia Wiki
|- style=\"color:black;background-color:#66cc11\"
| Wikia
|- style=\"color:black;background-color:#bb77ff\"
| Uncyclomedia
|- style=\"color:black;background-color:#FF0033\"
| Editthis
|- style=\"color:white;background-color:#000000\"
| Anarchopedia
|- style=\"color:black;background-color:#aa00aa\"
| Elwiki
|- style=\"color:black;background-color:#00BFFF\"
| Richdex
|- style=\"color:black;background-color:#90ee90\"
| OpenSUSE
|- style=\"color:black;background-color:#00BFFF\"
| Qweki
|- style=\"color:black;background-color:#90ee90\"
| Other (private) Mediawiki
|}";
?>
</pre>
