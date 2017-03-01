#!/bin/bash
# import miraheze wikis, both regular and custom domain wikis
# Dzahn - https://phabricator.wikimedia.org/T153930

WORKDIR="/tmp"
OUTFILE="${WORKDIR}/miraheze_wikis_combined.sql"

cd $WORKDIR

if [ -f $OUTFILE ]; then
    echo -e "$OUTFILE exists. deleting to cleanup"
    rm $OUTFILE
fi

echo -e "DELETE from miraheze;" >> $OUTFILE

echo -e "fetching miraheze wikis with custom domains.. \n"

/bin/bash /usr/local/bin/wikistats/import_miraheze_custom_wikis.sh >> $OUTFILE

echo -e "appended to $OUTFILE\n"
echo -e "fetching regular miraheze wikis.. \n"

/usr/bin/php /usr/local/bin/wikistats/import_miraheze.php >> $OUTFILE

echo -e "appended to $OUTFILE\n"

num_wikis=$(wc -l $OUTFILE | cut -d " " -f1)

echo -e "$num_wikis wikis detected. deleting table contents .. importing new data to mysql ..\n"

/usr/bin/mysql -u root wikistats < $OUTFILE

echo -e "cleaning up temp files and starting regular table update script\n"

/bin/rm $OUTFILE

/usr/bin/php /usr/lib/wikistats/update.php mh

exit

