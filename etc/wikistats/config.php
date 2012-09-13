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

# global config for wikistats

$IP="/usr/share/php/wikistats";

# database connection
$dbhost="localhost";
$dbname="wikistats";
$dbuser="wikistatsuser";
$dbpass="<not included>";

# current stable/dev mediawiki versions (update regularly)
$goodversions=array('1.20wmf11','1.20wmf3','1.20wmf2','1.18wmf1','1.19wmf1','1.20wmf1','1.19.2','1.18.5');
$devversions=array('1.18alpha','1.19alpha','1.20alpha');

# maxlag parameter for API calls
$api_maxlag=5;
# API query to use for getting statistics
$api_query_stat="?action=query&meta=siteinfo&siprop=statistics&format=php&maxlag=${api_maxlag}";
# API query to use for getting siteinfo
$api_query_info="?action=query&meta=siteinfo&format=php&maxlag=${api_maxlag}";
# API query to use for human-readable links to statistics
$api_query_disp="?action=query&amp;meta=siteinfo&amp;siprop=statistics&amp;maxlag=${api_maxlag}";
# API query to use for human-readable links to siteinfo
$api_query_dispv="?action=query&amp;meta=siteinfo&amp;maxlag=${api_maxlag}";

# User Agent used by update functions
#$user_agent="http://wikistats.wmflabs.org";
$user_agent="Mozilla/5.0 (iPad; U; CPU OS 3_2_1 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Mobile/7B405";

# socket timeout used by update functions
$socket_timeout="10";

# list all tables (which should be displayed on index page and included in grand totals)
$listtables=array("wikipedias","wikiquotes","wikibooks","wiktionaries","wikinews","wikisources","wikia","editthis","wikitravel","mediawikis","uncyclomedia","anarchopedias","opensuse","richdex","gratiswiki","qweki","wikisite","gentoo","hyperwave","scoutwiki","wmspecials","qweki","wikiversity","wikifur","metapedias","neoseeker","shoutwiki","referata","pardus","rodovid","wikkii","lxde");

# list tables which are valid for our api.php - CHECKME
$valid_api_tables=array('wikipedias','mediawikis','wiktionaries','wikia','wikisources','wmspecials','uncyclomedia','wikibooks','wikiquotes','editthis','wikinews','wikisite','wikitravel','scoutwiki','anarchopedias','opensuse','gratiswiki','gentoo','wikimedias','metapedias','wikifur','neoseeker','wikiversity');

# list tables which should have language columns in the html tables
$tables_with_language_columns=array('wikipedias','wiktionaries','wikisources','uncyclomedia','wikibooks','wikiquotes','wikinews','wikitravel','anarchopedias','wikimedias','wikifur','wikiversity','pardus','rodovid','lxde');

# list tables with URLs like wikiname.domain.org/api.php
$tables_with_prefix_short=array('anarchopedias', 'wikisite', 'pardus', 'rodovid', 'opensuse','wikisite','scoutwiki');

# list tables with URLs like domain.org/wikiname/api.php
$tables_with_suffix_short=array('editthis','lxde');

# list tables for which we save a full statistics URL in db
$tables_with_statsurl=array('mediawikis','uncyclomedia','metapedias','wmspecials');

# cut off wiki name after X characters when showing it in HTML tables
$name_max_len="42";

# cut off wiki license name (rights) after X characters when showing it in HTML tables
$rights_max_len="46";

# wrap detail.php table to new table row after X columns
$table_width="8";

# display X wikis in table before wrapping to next page
$page_size="500";

# after X minutes an old timestamp is declared "warn" (and colored accordingly)
$ts_limit_warn=24*60;

# after X minutes an old timestamp is declared "crit" (and colored accordingly)
$ts_limit_crit=48*60;

# names for different methods to get statistics
$get_method[0]="file_get_contents() / raw";
$get_method[1]="file_get_contents() / text-en";
$get_method[2]="lynx -dump / raw";
$get_method[3]="file_get_contents() / text-de";
$get_method[4]="file_get_contents() / text-es";
$get_method[5]="file_get_contents() / text-fr";
$get_method[6]="";
$get_method[7]="";
$get_method[8]="file_get_contents() / API";
$get_method[9]="";
$get_method[10]="lynx -dump / text-fr";
$get_method[11]="curl / raw";

?>
