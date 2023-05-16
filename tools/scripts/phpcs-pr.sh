#!/bin/bash
set -e

files=`git diff main HEAD --name-only --diff-filter ACMR | grep '\.php$' | wc -l`

if (( $files > 0 )); then
  git diff main HEAD --name-only --diff-filter ACMR | grep '\.php$' | xargs php -d memory_limit=4G vendor/bin/phpcs
fi

RESULT=$?

[ $RESULT -ne 0 ] && exit 1
exit 0
