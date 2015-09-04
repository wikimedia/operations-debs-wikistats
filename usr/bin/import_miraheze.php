<?php
# import new wikis from miraheze

$counter=0;
$importurl="https://meta.miraheze.org/w/api.php?action=sitematrix&format=php";

# echo "\nTrying to import from ${importurl}\n\n";
$buffer=file_get_contents($importurl);
# print_r($buffer);

$mydata=unserialize($buffer);
# print_r($mydata);

$my_count=$mydata['sitematrix']['count'];
# echo "Found ${my_count} wikis on miraheze. \n\n";

foreach ($mydata['sitematrix']['specials'] as $wiki) {
    $counter++;
    $my_wiki=$wiki['code'];
    # echo "[${counter}] ${my_wiki}\n";

    # skip private wikis
    if ( isset( $wiki['private'] ) ) {
        continue;
    }
    echo "INSERT IGNORE INTO miraheze (prefix,method) values ('${my_wiki}','8');\n";
}

?>
