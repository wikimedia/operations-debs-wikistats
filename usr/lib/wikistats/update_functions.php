<?php

function updateWiki($mytable,$id) {

# config
include("/etc/wikistats/config.php");

# debug
#error_reporting(E_ERROR);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

# functions
require("/usr/share/php/wikistats/functions.php");

# init
$domain = substr($mytable, 0, strlen($mytable)-1);
$convert=false;
$updcount=0;
$convcount=0;
$impcount=0;
$extcount=0;

# ini_set
ini_set('user_agent','${user_agent}');
ini_set('default_socket_timeout', $socket_timeout);

# db connect
mysql_connect("$dbhost", "$dbuser", "$dbpass") or die(mysql_error());
#DEBUG# print "wikistats updater \n connected to mysql. \n";
mysql_select_db("$dbname") or die(mysql_error());

## main
switch ($mytable) {
    case "wp":
        $table="wikipedias";
        $domain="wikipedia.org";
    break;
    case "wt":
        $table="wiktionaries";
        $domain="wiktionary.org";
    break;
    case "ws":
        $table="wikisources";
        $domain="wikisource.org";
    break;
    case "wn":
        $table="wikinews";
        $domain="wikinews.org";
    break;
    case "wb":
        $table="wikibooks";
        $domain="wikibooks.org";
    break;
    case "wq":
        $table="wikiquotes";
        $domain="wikiquote.org";
    break;
    case "wv":
        $table="wikiversity";
        $domain="wikiversity.org";
    break;
    case "wy":
        $table="wikivoyage";
        $domain="wikivoyage.org";
    break;
    case "mw":
    case "mediawikis":
        $table="mediawikis";
        $domain="na";
    break;
    case "wx":
        $table="wmspecials";
        $domain="wikimedia.org";
    break;
    case "un":
        $table="uncyclomedia";
        $domain="na";
    break;
    case "sw":
        $table="shoutwiki";
        $domain="shoutwiki.com";
    break;
    case "sc":
        $table="scoutwiki";
        $domain="scoutwiki.org";
    break;
    case "wr":
        $table="wikitravel";
        $domain="wikitravel.org";
    break;
    case "wf":
        $table="wikifur";
        $domain="wikifur.com";
    break;
    case "an":
        $table="anarchopedias";
        $domain="anarchopedia.org";
    break;
    case "gt":
        $table="gentoo";
        $domain="gentoo-wiki.com";
    break;
    case "os":
        $table="opensuse";
        $domain="opensuse.org";
    break;
    case "ne":
        $table="neoseeker";
        $domain="neoseeker.com";
    break;
    case "et":
        $table="editthis";
        $domain="editthis.info";
    break;
    case "si":
        $table="wikisite";
        $domain="wiki-site.com";
    break;
    case "mt":
        $table="metapedias";
        $domain="metapedia.org";
    break;
    case "re":
        $table="referata";
        $domain="referata.com";
    break;
    case "pa":
        $table="pardus";
        $domain="pardus-wiki.org";
    break;
    case "ro":
        $table="rodovid";
        $domain="rodovid.org";
    break;
    case "wk":
        $table="wikkii";
        $domain="wikkii.com";
    break;
    case "lx":
        $table="lxde";
        $domain="wiki.lxde.org";
    break;
    case "w3":
        $table="w3cwikis";
        $domain="www.w3.org/community";
    break;
    case "ga":
        $table="gamepedias";
        $domain="gamepedia.com";
    case "sf":
        $table="sourceforge";
        $domain="sourceforge.net";
    break;
    default:
        $table="unknown";
        print "unknown table. exiting\n";
        exit;
}

        $query = "select * from ${table} where id=".$id;


$myresult = mysql_query("$query") or die(mysql_error());
#DEBUG#
#
print "sent query: '$query'.\n";

#want to know number of wikis and progress in logs
$mycount=0;
$totalcount=mysql_num_rows($myresult);

while($row = mysql_fetch_array( $myresult )) {
    $mycount++;

    if ($row['method']=="8") {

        if (in_array($table, $tables_with_statsurl)) {
            $url=$row['statsurl']."${api_query_stat}";
            $domain=$row['name'];
            $prefix=$table;
        } elseif (in_array($table, $tables_with_prefix_short)) {
            $prefix=$row['prefix'];
            $url="http://".$row['prefix'].".${domain}/api.php${api_query_stat}";
        } elseif (in_array($table, $tables_with_suffix_short)) {
            $prefix=$row['prefix'];
            $url="http://${domain}/".$row['prefix']."/api.php${api_query_stat}";
        } elseif (in_array($table, $tables_with_suffix_wiki)) {
            $prefix=$row['prefix'];
            $url="http://${domain}/wiki/".$row['prefix']."/api.php${api_query_stat}";
        } else {
            $prefix=$row['prefix'];
            $url="http://${prefix}.${domain}/w/api.php${api_query_stat}";
        }

        print "A(${mycount}/${totalcount}) - ${prefix}.${domain} - calling API: ${url}\n";

        if ($convert) { print "->CONVERSION MODE - tried alternate API URL on non-API wiki\n"; }

        # parsing is in ./includes/functions method9
        $result=method9($url);
        $parsing_answer=$result["returncode"];
        $statuscode=$result["statuscode"];

        if ($parsing_answer == 0) {

            $total=$result["pages"];
            $good=$result["articles"];
            $edits=$result["edits"];
            $images=$result["images"];
            $users=$result["users"];
            $ausers=$result["activeusers"];
            $activeusers=$result["activeusers"];
            $admins=$result["admins"];

            if (isset($import) && $import) {
                $wikiname=get_name_from_api($url);
            }
        } elseif ($parsing_answer == 3) {
            echo "\\n 991 error ! - http: ".$row['http']." method: ".$row['method']." url: ".$row['statsurl']." version: ".$row['version']." agent: $user_agent API: $url\n";
        }

        print "-> http answer: ${statuscode} -> parsing answer: ${parsing_answer}\n";

    } else {

        if (in_array($table, $tables_with_statsurl)) {
            $url=$row['statsurl'];
            $domain=$row['name'];
            $prefix=$table;
        } elseif ($table=="wikitravel") {
            $prefix=$row['prefix'];
            $url="http://${domain}/wiki/".$row['prefix']."/api.php";
        } elseif ($table=="rodovid") {
            $prefix=$row['prefix'];
            $url="http://${prefix}.${domain}/wk/Special:Statistics?action=raw";
        } elseif ($table=="wikisite") {
            $prefix=$row['prefix'];
            $url="http://${prefix}.${domain}/index.php/Special:Statistics?action=raw";
        } else {
            $prefix=$row['prefix'];
            $url="http://${prefix}.${domain}/wiki/Special:Statistics?action=raw";
        }

        if ($row['method'] == "7") {
            $url=$row['old_statsurl'];
            print "!(${mycount}/${totalcount}) - ${prefix}.${domain} - NO API URL! (method 7! selected 'old_statsurl'!) trying ${url}\n";
        } else {
            print "!(${mycount}/${totalcount}) - ${prefix}.${domain} - NO API URL! (method: ".$row['method'].") trying ${url}\n";
        }

        $buffer = file_get_contents($url);

        if (isset($http_response_header[0])) {
            $statuscode=explode(" ",$http_response_header[0]);
            $statuscode=$statuscode[1];
        } else {
            $statuscode="792";
        }


        if ($statuscode=="200") {

            $total = explode("total=",$buffer);
            if (isset($total[1])) { $total = explode(";",$total[1]); $total = $total[0]; }

            $good = explode("good=",$buffer);
            if (isset($good[1])) { $good = explode(";",$good[1]); $good = $good[0]; }
            # hack away overflow bug
            if ($good>2147483647) {
                print "--> NOTICE - overflow bug - good>2147483647 - setting to 0\n";
                $good=0;
            }

            #$views = explode("views=",$buffer);
            #if (isset($views[1])) { $views = explode(";",$views[1]); $views = $views[0]; }

            $edits = explode("edits=",$buffer);
            if (isset($edits[1])) { $edits = explode(";",$edits[1]); $edits = $edits[0]; }

            $users = explode("users=",$buffer);
            if (isset($users[1])) { $users = explode(";",$users[1]); $users = $users[0]; }

            $ausers = explode("activeusers=",$buffer);
            if (isset($ausers[1])) { $ausers = explode(";",$ausers[1]); $ausers = $ausers[0]; }
            # ausers may not exist on older wikis
            if (is_array($ausers)) {
                print "--> NOTICE - no activeusers column found - setting to 0\n";
                $ausers=0;
            }

            $admins = explode("admins=",$buffer);
            if (isset($admins[1])) { $admins = explode(";",$admins[1]); $admins = trim($admins[0]); }

            $images = explode("images=",$buffer);
            if (isset($images[1])) { $images = explode(";",$images[1]); $images = trim($images[0]); }
            # images  may not exist on older wikis
            if (is_array($images)) {
                print "--> NOTICE - no images column found - setting to 0\n";
                $ausers=0;
            }
            if (is_numeric($total)) {
                $parsing_answer=0;
            } else {
                $parsing_answer=2;
                $statuscode="997";
            }

        } else {
            $parsing_answer=1;
        }

        print "-> http answer: ${statuscode} -> parsing answer: ${parsing_answer}\n";
    }


    switch ($parsing_answer) {
        case 0:
            print "---> OK - total: ${total} good: ${good} views: FIX? edits: ${edits} users: ${users} active users: ${ausers} admins: ${admins} images: ${images}\n";
        $updatequery="update ${table} set total=\"${total}\",good=\"${good}\",edits=\"${edits}\",users=\"${users}\",activeusers=\"${ausers}\",admins=\"${admins}\",images=\"${images}\",http=\"${statuscode}\",ts=NOW() where id=\"".$row['id']."\";";

            if ($convert) {
                print "--> CONVERSION SUCCESSFUL. changing to API parsing.\n\n";
                $convquery="update ${table} set total=\"${total}\",good=\"${good}\",edits=\"${edits}\",users=\"${users}\",activeusers=\"${ausers}\",admins=\"${admins}\",images=\"${images}\",statsurl=\"${url}\",method=\"8\",http=\"${statuscode}\",ts=NOW() where id=\"".$row['id']."\";";
                print "---> ${convquery} \n\n";
                $convresult = mysql_query("$convquery") or die(mysql_error());
                $convcount++;
            }

            $name=$row['name'];

            if (isset($import) && $import && isset($wikiname) && $wikiname!="" && $wikiname!=$name) {
                print "--> IMPORT SUCCESSFUL. name: '${wikiname}'\nn";
                $impquery="update ignore ${table} set name=\"${wikiname}\",total=\"${total}\",good=\"${good}\",edits=\"${edits}\",users=\"${users}\",activeusers=\"${ausers}\",admins=\"${admins}\",images=\"${images}\",method=\"8\",http=\"${statuscode}\",ts=NOW() where id=\"".$row['id']."\";";
                print "---> ${impquery} \n\n";
                $impresult = mysql_query("$impquery") or die(mysql_error());
                $impcount++;
            }

        break;
        case 1:
            print "---> ERROR - fetching via HTTP failed: id ".$row['id']." (${url}) \n\n";
            $updatequery="update ${table} set http=\"${statuscode}\",ts=NOW() where id=\"".$row['id']."\";";
        break;
        case 2:
            print "---> ERROR - parsing failed for: id ".$row['id']." (${url}) \n\n";
            $updatequery="update ${table} set http=\"${statuscode}\",ts=NOW() where id=\"".$row['id']."\";";
        break;
    default:
        print "---> ERROR - unexpected error for: id ".$row['id']." (${url}) HTTP: ${statuscode} \n\n";
        $updatequery="update ${table} set http=\"${statuscode}\",ts=NOW() where id=\"".$row['id']."\";";
    break;
    }

    if (!$convert) {
        print "---> ${updatequery} \n\n";
        $updateresult = mysql_query("$updatequery") or die(mysql_error());
        #DEBUG# print "mysql result: $updateresult";
        $updcount++;
    }


    if (isset($extinfo) && $extinfo) {
        print "--> EXTENDED INFO MODE. adding to db..\n";

        $myextinfo=siteinfo($url);

        print_r($myextinfo);

        if ($myextinfo['siteinfo'] != "error" ) {
            $extquery="update mediawikis set ";

            foreach ($myextinfo['siteinfo'] as $myextkey => $myextvalue) {
                    $extquery.="`si_${myextkey}`='".mysql_escape_string($myextvalue)."', ";
            }

            $extquery=substr($extquery,0,-2);
            $statuscode=$myextinfo['statuscode'];
            $extquery.=", http=\"$statuscode\" where id=".$row['id'].";";
            echo "\n$extquery\n";

            if (isset($myextinfo['siteinfo'])) {
                $extresult = mysql_query("$extquery") or die(mysql_error());
                $extcount++;
            } else {
                echo "ext info query seemed invalid. skipping..\n";
            }
        } elseif (isset($myextinfo['statuscode'])) {
            $statuscode=$myextinfo['statuscode'];
            $extquery="update mediawikis set http='$statuscode' where id=".$row['id'].";";
            $extresult = mysql_query("$extquery") or die(mysql_error());
            $extcount++;
            echo "$extquery\n";
        } else {
            echo "siteinfo returned error unserializing data. skipping..\n";
        }
    }

}

if (isset($convert) && $convert) {
    print "\n\n${convcount} wikis succesfully converted to API parsing.\n";
} elseif (isset($import)) {
    print "\n\n${impcount} wikis succesfully imported.\n";
} elseif (isset($extinfo)) {
    print "\n\n${extcount} wikis succesfully added full siteinfo.\n";
} else {
    print "\n\n${updcount} wikis succesfully updated.\n";
}


}

?>
