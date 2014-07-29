#!/bin/bash

# jphase's backup script

BACKUPDIR="/backup/mysql"
DAYSBACK="14"

# Remove backups that are before our days back window
find $BACKUPDIR -mtime +$DAYSBACK -exec rm -f {} \;

# Get database list
databases=`ls some stuff`

# Loop through database list and create gzipped backups
for db in $databases; do
    if [[ "$db" != "information_schema" ]] && [[ "$db" != "performance_schema" ]] && [[ "$db" != _* ]] ; then
        echo "`date +%Y-%m-%d\ %I:%M%p`: Dumping database: $db"
        mysqldump --force --opt --user=$USER --password=$PASSWORD --databases $db > $BACKUPDIR/`date +%Y%m%d`.$db.sql
        gzip $BACKUPDIR/`date +%Y%m%d`.$db.sql
    fi
done