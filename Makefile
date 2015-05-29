vendor : composer.phar
	php composer.phar install

composer.phar : 
	curl -sS https://getcomposer.org/installer | php

sparkle-posse.xip : vendor
	rsync -av --delete --exclude='.git*' --exclude=composer.phar --exclude=sparkle-posse.xip --exclude=config.php . /tmp/sparkle-posse
	xip --sign 'Developer ID Installer' --timestamp /tmp/sparkle-posse sparkle-posse.xip

dist : sparkle-posse.xip

clean :
	rm -rf vendor composer.lock composer.phar sparkle-posse.xip
