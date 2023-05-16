#!/bin/bash
set -e

vendor/bin/phpstan analyse --level=5 --memory-limit=4G || true

