#!/usr/bin/env sh

sleep 20

supervisord -c /etc/supervisor/conf.d/supervisord.conf
