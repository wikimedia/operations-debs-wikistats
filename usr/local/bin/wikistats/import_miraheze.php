<?php
// Import Miraheze wikis
// Only public wikis are selected in importurl
// Dzahn - 2016 - https://phabricator.wikimedia.org/T153930
// John Lewis - 2018 - https://phabricator.miraheze.org/T191245
$counter = 0;
$importurl = "https://meta.miraheze.org/w/api.php?action=wikidiscover&wdstate=public&format=php";
$buffer = file_get_contents($importurl);
$mydata = unserialize($buffer);
foreach ( $mydata['wikidiscover'] as $wiki ) {
        $counter++;
        $my_wiki = substr( $wiki['dbname'], 0, -4 );
        if ( substr( $wiki['url'], -12 ) == "miraheze.org" ) {
                echo "INSERT IGNORE INTO miraheze (prefix,method) values ('${my_wiki}','8');\n";
        } else {
                echo "INSERT IGNORE INTO miraheze (prefix,method,statsurl) values ('${my_wiki}',8,'${wiki['url']}');\n";
        }
}
?>
