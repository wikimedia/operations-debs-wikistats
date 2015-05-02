<?php
# Wikistats - query to get data from all tables combined
# used in the "largest" tables

# some default sets of fields for different types of wiki farms
$number_fields = "total,good,edits,users,admins,images,ts,http,TIMESTAMPDIFF(MINUTE, ts, now()) AS oldness,good/total AS ratio";
$default_fields = "id,lang,prefix,si_generator as version,${number_fields}";
$fields_uncyclo = "id,lang,statsurl AS prefix,version,${number_fields}";
$fields_nolangs = "id,name AS lang,statsurl AS prefix,version,${number_fields}";
$fields_nolang2 = "id,name AS lang,statsurl,version,${number_fields}";
$fields_wikia   = "id,prefix as lang,prefix,version,${number_fields}";

# build the query to combine it all
$query = <<< FNORD

SELECT ${default_fields},"Wikipedia" AS type FROM wikipedias WHERE (good >= ${threshold}) AND edits IS not NULL

UNION SELECT ${default_fields},"Wiktionary" AS type FROM wiktionaries WHERE good >= ${threshold}

UNION SELECT ${default_fields},"Wikibooks" AS type FROM wikibooks WHERE good >= ${threshold}

UNION SELECT ${default_fields},"Wikinews" AS type FROM wikinews WHERE good >= ${threshold}

UNION SELECT ${default_fields},"Wikiquote" AS type FROM wikiquotes WHERE good >= ${threshold}

UNION SELECT ${default_fields},"Wikisource" AS type FROM wikisources WHERE good >= ${threshold}

UNION SELECT ${default_fields},"Wikitravel" AS type FROM wikitravel WHERE good >= ${threshold}

UNION SELECT id,url,prefix,si_generator,${number_fields},"Wmspecial" AS type FROM wmspecials WHERE good >= ${threshold}

UNION SELECT ${default_fields},'Wikiversity' AS type FROM wikiversity WHERE good >= ${threshold}

UNION SELECT ${fields_wikia},"Wikia" AS type FROM wikia WHERE good >= ${threshold} AND inactive IS NULL

UNION SELECT ${fields_nolang2},"Neoseeker" AS type FROM neoseeker WHERE good >= ${threshold} AND inactive IS NULL

UNION SELECT ${fields_uncyclo},"Uncyclomedia" AS type FROM uncyclomedia WHERE good >= ${threshold} AND statsurl not like "%wikia.com%"

UNION SELECT ${fields_nolangs},"Mediawiki" AS type FROM mediawikis WHERE  good >= ${threshold}

UNION SELECT ${fields_nolangs},"Gentoo" AS type FROM gentoo WHERE good >= ${threshold}

UNION SELECT ${fields_nolangs},"openSUSE" AS type FROM opensuse WHERE good >= ${threshold}

UNION SELECT ${fields_nolangs},"Editthis" AS type FROM editthis WHERE good >= ${threshold} AND inactive IS NULL

UNION SELECT id,lang,prefix AS statsurl,version,${number_fields},"Anarchopedia" AS type FROM anarchopedias WHERE good >= ${threshold}

UNION SELECT id,lang,statsurl,version,${number_fields},'Wikifur' AS type FROM wikifur WHERE good >= ${threshold}

UNION SELECT id,lang,prefix AS statsurl,version,${number_fields},"Wikisite" AS type FROM wikisite WHERE good >= ${threshold}

UNION SELECT ${fields_nolangs},"W3C" AS type FROM w3cwikis WHERE good >= ${threshold}

UNION SELECT ${fields_nolangs},"Gamepedia" AS type FROM gamepedias WHERE good >= ${threshold}

UNION SELECT ${fields_nolangs},"Sourceforge" AS type FROM sourceforge WHERE good >= ${threshold}

UNION SELECT ${fields_nolangs},"Orain" AS type FROM orain WHERE good >= ${threshold}

ORDER BY ${msort} LIMIT ${limit};

FNORD;
?>
