#!/bin/bash
# import miraheze wikis
# Dzahn - https://phabricator.wikimedia.org/T153930
# John Lewis - modified for https://phabricator.wikimedia.org/T191245

WORKDIR="/tmp"
OUTFILE="${WORKDIR}/miraheze_wikis.sql"

cd $WORKDIR

if [ -f $OUTFILE ]; then
  echo -e "$OUTFILE exists. deleting to cleanup"
  rm $OUTFILE
fi

echo -e "DELETE from miraheze;" >> $OUTFILE

echo -e "importing miraheze wikis\n"

/usr/bin/php /usr/local/bin/wikistats/import_miraheze.php >> $OUTFILE

echo -e "appended to $OUTFILE\n"

num_wikis=$(wc -l $OUTFILE | cut -d " " -f1)

echo -e "$num_wikis wikis detected. deleting table contents .. importing new data to mysql ..\n"

/usr/bin/mysql -u root wikistats < $OUTFILE

echo -e "cleaning up temp files and starting regular table update script\n"

/bin/rm $OUTFILE

/usr/bin/php /usr/lib/wikistats/update.php mh

exit
