#!/usr/bin/env sh

sleep 30

supervisord -c /etc/supervisor/conf.d/supervisord.conf
