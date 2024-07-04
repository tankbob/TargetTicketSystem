#!/bin/sh
service ssh start
exec /usr/local/bin/apache2-foreground
