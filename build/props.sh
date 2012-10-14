#!/bin/bash

basedir=/var/www/phpenv.com/
build_dir=${basedir}build/
deploy_dir=${basedir}deploy/
webroot=${basedir}www/
overlays=/var/overlays/phpenv.com/

app_dir=${webroot}protected/
yiic=${app_dir}libs/yii/yiic.php

