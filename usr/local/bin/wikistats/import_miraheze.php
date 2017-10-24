<?php
# import new wikis from miraheze
# this only covers regular wikis in the miraheze.org domain
# wikis with custom domain names are not included
# import_miraheze_custom_wikis.sh gets the custom ones

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
    if (array_key_exists( 'private', $wiki )) {
        continue;
    }
    echo "INSERT IGNORE INTO miraheze (prefix,method) values ('${my_wiki}','8');\n";
}

?>
