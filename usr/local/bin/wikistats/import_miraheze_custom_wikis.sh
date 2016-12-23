#!/bin/bash
# import miraheze wikis with custom domain names
# Dzahn - https://phabricator.wikimedia.org/T153930

WORKDIR="/tmp"
INFILE="custom.txt"
URL="https://meta.miraheze.org/wstats/${INFILE}"
OUTFILE="${WORKDIR}/miraheze_custom_wikis.sql"


cd $WORKDIR
/bin/rm $INFILE
/usr/bin/wget $URL

while read -r line
  do

    wiki=$(echo $line|cut -d\| -f1)
    url=$(echo $line| cut -d\| -f2)

    echo "DELETE from miraheze where prefix='${wiki}';" | tee $OUTFILE
    echo "INSERT IGNORE INTO miraheze (prefix,method,statsurl) values ('${wiki}','8','${url}');" | tee $OUTFILE

done < "${INFILE}"

cat $OUTFILE

/usr/bin/mysql -u root wikistats < $OUTFILE

/bin/rm $WORKDIR/$INFILE $OUTFILE

