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
# rank feature as requested by Danny B.
# "position of such wiktionary in all wiktionaries <space> number of all wiktionaries <space>
# position of such wiktionary in all wmf wikis <space> number of all wmf wikis"
#
# the second wish was for the following behavior:
# position.php?family=wiktionaries&position=42 RETURN: cs
# position.php?family=wmfwikis&position=1 RETURN: enwiki

require_once("/etc/wikistats/config.php");

# enable CORS (T193094)
header('Access-Control-Allow-Origin: *');

# db connect
try {
    $wdb = new PDO("mysql:host=${dbhost};dbname=${dbname}", $dbuser, $dbpass);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br />";
    die();
}

$count=0;
$arcount=0;
$lang_check="FALSE";
$languages=array();

if (isset($_GET['lang'])) {
    $lang=$_GET['lang'];
    $lang=htmlspecialchars($lang, ENT_QUOTES);
}

$query = "select prefix,lang,loclang from wikipedias where prefix is not null order by prefix asc";
$fnord = $wdb->prepare($query);
$fnord -> execute();

while ($row = $fnord->fetch()) {

    $languages[$arcount]=$row[prefix]." - ".$row[loclang];
    $arcount++;
    if ($row[prefix]==$lang) {
        $lang_check="OK";
    }

}

if (isset($_GET['lang']) AND $lang_check=="OK"){
    $lang=$lang;
} elseif (isset($_GET['lang']) AND $lang_check!="OK") {
    echo "This language does not exist (as a wikipedia).";
    exit(1);
} else {
    echo "<html><body><h4>This script returns the ranking of a Wikimedia foundation project when sorted by size.</h4>
    <p>usage: <pre>?family=[project family]\n\n?lang=[language]</pre></p>
    <p><form action=rank.php method='get'>project family can be one of: \n<b>w, wikt, n, b, q, s, v, voy</b>\n\n(<a href=\"http://meta.wikimedia.org/wiki/Help:Interwiki_linking#Project_titles_and_shortcuts\">interwiki shortcuts</a>) ";
    echo "<select name=\"family\">
    <option value=\"w\">w - wikipedia</option>
    <option value=\"wikt\">wikt - wiktionary</option>
    <option value=\"n\">n - wikinews</option>
    <option value=\"b\">b - wikibooks</option>
    <option value=\"q\">q - wikiquote</option>
    <option value=\"s\">s - wikisource</option>
    <option value=\"v\">v - wikiversity</option>
    <option value=\"voy\">voy - wikivoyage</option>
    </select>";
    echo "<br /><br />language should be a language prefix that exists as a wikipedia subdomain: <select name=\"lang\">";

    foreach ($languages as $language) {
        $langprefix=explode(" - ",$language);
        $langprefix=$langprefix[0];
        echo "<option value=\"$langprefix\">$language</option>\n";
    }

    echo "</select><br /><input type='submit' value='submit' /></form><p>output:<pre>&lt;lang.project&gt; &lt;rank within project&gt; &lt;number of wikis in project&gt; &lt;global rank&gt; &lt;global number of wikis&gt;</pre>en.wikipedia 1 272 1 761</p><p>examples:<br /><a href=\"rank.php?family=w&lang=es\">?family=w&amp;lang=en</a> (Spanish Wikipedia)<br /><a href=\"rank.php?family=wikt&lang=en\">?family=wikt&amp;lang=de</a> (English Wiktionary)<br /><a href=\"rank.php?family=v&lang=ru\">?family=v&amp;lang=ru</a> (Russian Wikiversity)</b></p><p>Complete tables can be found in <a href=\"index.php\">wikistats</a>";
    exit(0);
}

if (isset($_GET['family'])) {

    switch ($_GET['family']){
        case "w":
            $table="wikipedias";
            $family="wikipedia";
        break;
        case "wikt":
            $table="wiktionaries";
            $family="wiktionary";
        break;
        case "n":
            $table="wikinews";
            $family="wikinews";
        break;
        case "b":
            $table="wikibooks";
            $family="wikibooks";
        break;
        case "q":
            $table="wikiquotes";
            $family="wikiquote";
        break;
        case "s":
            $table="wikisources";
            $family="wikisource";
        break;
        case "v":
            $table="wikiversity";
            $family="wikiversity";
        break;
        case "voy":
            $table="wikivoyage";
            $family="wikivoyage";
        break;
        case "special":
            $table="wmspecials";
            $family="wmf";
        break;
    default:
    echo "<pre>project family does not exist.\n\nplease use one of: w, wikt, n, b, q, s, v.\n\nlike the shortcuts from http://meta.wikimedia.org/wiki/Help:Interwiki_linking";
    exit(1);
    }

    } else {
        $table="wiktionaries";
        $family="wiktionary";
}

$table=htmlspecialchars($table, ENT_QUOTES);
$family=htmlspecialchars($family, ENT_QUOTES);

$query = "select id,prefix from ${table} where prefix is not null order by good desc,total desc";
$fnord = $wdb->prepare($query);
$fnord -> execute();

while ($row = $fnord->fetch()) {

    $count++;
    if ($row[prefix]==$lang) {
        $rank_project=$count;
    }
}

$number_project=$count;

$count=0;

$query = <<<FNORD
(select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikipedias' as type from wikipedias where prefix is not null)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikisources' as type from wikisources)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wiktionaries' as type from wiktionaries)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikiquotes' as type from wikiquotes)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikibooks' as type from wikibooks)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikinews' as type from wikinews)
 union all (select url,good,lang,loclang,total,edits,admins,users,images,ts,'wmspecials' as type from wmspecials)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikiversity' as type from wikiversity)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikivoyage' as type from wikivoyage)
 order by good desc,total desc;
FNORD;

$fnord = $wdb->prepare($query);
$fnord -> execute();

while ($row = $fnord->fetch()) {
    $count++;
    if ($row[prefix]==$lang AND $row[type]==$table) {
        $rank_global=$count;
        $type=$row[type];
    }
}

$number_global=$count;

echo "$lang.$family $rank_project $number_project $rank_global $number_global\n\n";
#echo "debug: lang.family $lang.$family rank_project: $rank_project number_project: $number_project rank_global: $rank_global number_global: $number_global\n";
if ($rank_project==""){
    echo "\n! this language version does not seem to exist yet in this project";
}

# close db connection
$wdb = null;
?>
