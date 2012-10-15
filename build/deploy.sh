#!/bin/bash


. props.sh


action=$(whiptail --clear --menu 'What do you want to do?' 13 30 5 'deploy' '' 'rollback' '' 'remove-maintenance-page' '' 'remove-deploy-lock' '' 3>&1 1>&2$
. $action;




