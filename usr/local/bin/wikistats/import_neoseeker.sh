#!/bin/bash

WIKI_LIST="https://neowiki.neoseeker.com/wiki/Special:WikiList"
MYSQL="/usr/bin/mysql -u root wikistats"

echo -e "deleting existing table\n"
echo -e "DELETE from neoseeker;\n" | $MYSQL

echo -e "fetching new wikis\n"

for wiki in $(\
wget -qO - ${WIKI_LIST} \
| grep -io '<a href=['"'"'"][^"'"'"']*['"'"'"]' \
| grep neoseeker.com \
| cut -d\/ -f3 \
| cut -d. -f1 \
| sort \
| uniq\
)
do echo "INSERT INTO neoseeker (prefix) values ('${wiki}');"
done | $MYSQL

echo -e "updating method\n"
echo "UPDATE neoseeker set method='8';" | $MYSQL

echo -e "running update\n"

/usr/bin/php /usr/lib/wikistats/update.php ne
