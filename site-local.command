#!/bin/bash

set -eux

BASE=$(dirname $0)
SITE=$(basename "$BASE")
SITEROOT="$BASE"
URL=http://$SITE

cd "$BASE"

# Title the window
echo -n -e "\033]0;$SITE Logs\007"

IP=$(ifconfig | awk '/inet / && ! /127\.0\.0\.1/ { print $2 }')

dns-sd -P "$SITE Dev Site" _http._tcp local 80 $SITE $IP &

# If Dr Jekyll has drunk the potion, let Mr Hyde loose...
if [ -f "$BASE/_config.yml" ]
then
	SITEROOT="$BASE/_site"
	jekyll build --watch &
fi

sleep 1

# Open a window, if one isn't found
osascript -e "tell application \"Safari\" to if ((documents whose URL starts with \"$URL\") = {}) then open location \"$URL\""

# Auto-refresh using fswatch, if available...
if which fswatch
then
	fswatch -o "$SITEROOT" | xargs -n1 -I{} osascript -e "tell application \"Safari\" to do JavaScript \"location.reload(true)\" in documents whose URL starts with \"$URL\"" > /dev/null &
else
	echo "NOTE: Install fswatch (e.g. brew install fswatch) to allow auto-refresh"
fi

# Tail logs, colorizing lines that start with '[' (i.e. error log lines)
tail -q -f -n 0 /var/log/apache2/error_log /var/log/apache2/access_log \
| egrep -i --color '^\[.*|$'
