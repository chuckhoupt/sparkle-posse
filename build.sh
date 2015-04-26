#!/bin/bash

set -eux

# Install Composer locally
curl -sS https://getcomposer.org/installer | php

# Install dependencies
php composer.phar install