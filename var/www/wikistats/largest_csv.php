<?php
# Wikistats - output the CSV version of all tables combined

# header
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=largest_mediawikis.csv");
header("Pragma: no-cache");
header("Expires: 0");

# config
require_once("/etc/wikistats/config.php");

if (isset($_GET['semicolon'])) {
    $delim=";";
} else {
    $delim=",";
}

# MySQL connect
mysql_connect("$dbhost", "$dbuser", "$dbpass") or die(mysql_error());
mysql_select_db("$dbname") or die(mysql_error());

$threshold=0;
$msort="total desc,good desc";
$limit=5000;

# query
include("$IP/largest_query.php");

$result = mysql_query("$query") or die(mysql_error());
$count=1;
$cr = "\n";

# output header
echo "rank${delim}id${delim}name${delim}total${delim}good${delim}edits${delim}views${delim}admins${delim}users${delim}images${delim}ratio${delim}type${delim}url${delim}ts $cr";


# output data
while($row = mysql_fetch_array( $result )) {

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

        case "Mediawiki":
            $name=$row['lang'];
            $url=explode("S",$row['prefix']);
            $url=$url[0];
            $url=htmlspecialchars($url);
        break;

        case "Uncyclomedia":
            $name=$row['lang']." Uncylopedia";
            $url=$row['prefix'];
            $url=explode("/",$url);
            $url=$url[2];
            $url="http://".$url."/wiki/";
        break;

        case "Wikia":
            $name=$row['lang'].".wikia";
            $url="http://".$name.".wikia.com/wiki/";
        break;

        case "Wmspecial":
            $name=$row['prefix'].".wikimedia";
            $url="http://".$row['prefix'].".wikimedia.org/wiki/";
        break;

        case "Editthis":
            $name=$row['lang'].".editthis";
            $url=explode("index.php",$row['prefix']);
            $url=$url[0];
            $url=htmlspecialchars($url);
        break;

        case "Elwiki":
            $name=$row['lang'].".elwiki";
            $url="http://".$row['lang'].".elwiki.com/";
        break;

        case "Anarchopedia":
            $name=$row['lang']." Anarchopedia";
            $url="http://".$row['prefix'].".anarchopedia.org/index.php/";
        break;

        case "Qweki":
            $name=$row['prefix'].".qweki";
            $url="http://".$row['prefix'].".qweki.com/";
        break;

        default:
            $name=$row['lang']." ".$row['type'];
            if (isset($row['statsurl'])) {
                $url=$row['statsurl'];
            } else {
                $url="n/a";
            }

    }

    echo "$count${delim}".$row['id']."${delim}$name${delim}".$row['total']."${delim}".$row['good']."${delim}".$row['edits']."${delim}".$row['views']."${delim}".$row['admins']."${delim}".$row['users']."${delim}".$row['images']."${delim}".$row['ratio']."${delim}".$row['type']."${delim}$url${delim}".$row['ts']."$cr";

    $count++;
}

mysql_close();
?>
