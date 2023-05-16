#!/bin/bash
set -e

files=`git diff --name-only --cached | grep '\.php$' | wc -l`

if (( $files > 0 )); then
  git diff --name-only --cached | grep '\.php$' | xargs vendor/bin/phpstan analyse --memory-limit=4G
fi

RESULT=$?

[ $RESULT -ne 0 ] && exit 1
exit 0
