#!/bin/bash

MYSQL_HOSTNAME="172.16.207.133"
MYSQL_USERNAME="ggoral" 
MYSQL_DATABASE="fba_db"

#uncomment next line
mysql -h $MYSQL_HOSTNAME -u $MYSQL_USERNAME -p $MYSQL_DATABASE < $1

#Add privileges to user mysql
#GRANT ALL PRIVILEGES ON *.* TO 'MYSQL_USER'@'localhostIDENTIFIED BY 'MYSQL_PASS' WITH GRANT OPTION;
#GRANT ALL PRIVILEGES ON *.* TO 'MYSQL_USER'@'%' IDENTIFIED BY 'MYSQL_PASS' WITH GRANT OPTION;
#FLUSH PRIVILEGES;