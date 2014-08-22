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

# simple Wikistats API to output csv,ssv,xml dumps

require_once("/etc/wikistats/config.php");
require_once("$IP/functions.php");

if (isset($_GET['action'])) {
    
    $action=htmlspecialchars(strip_tags(trim(mysql_escape_string($_GET['action']))));

    switch ($action) {

        case "dump":

            $table=strip_tags(trim(mysql_escape_string($_GET['table'])));

            if (in_array($table,$valid_api_tables)) {

                $format=strip_tags(trim(mysql_escape_string($_GET['format'])));

                switch ($format) {
                    case "csv":
                        print data_dumper("$table","csv");
                        exit(0);
                    break;
                    case "ssv":
                        print data_dumper("$table","ssv");
                        exit(0);
                    case "xml":
                        print xml_dumper("$table");
                        exit(0);
                    default:
                        print "dump format not set or unknown. please specify a known format. f.e. &format=csv";
                    exit(1);
                }
            } else {
                print "table name not set or unknown. please specify a known table. f.e. &table=wikipedias";
            exit(1);
            }

        break;

        default:
            print "unknown action. please specify a valid action. f.e. ?action=dump";
            exit (1);
        break;

    }

} else {

print <<<FNORD
<pre>
Wikistats API

current actions:

-  action=dump
-- dump csv, ssv or xml data of all tables

option 1: format (csv|ssv|xml)
option 2: table (wikipedias|wiktionaries|...)

example: api.php?action=dump&table=wikipedias&format=csv
example: api.php?action=dump&table=wikiquotes&format=ssv
example: api.php?action=dump&table=neoseeker&format=xml

</pre>
FNORD;

exit(0);
}

echo "Error. How did we get here? Exiting.";
exit(1);

?>
