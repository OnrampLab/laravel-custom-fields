#!/bin/bash
set -e

vendor/bin/phpcs src tests  -s --report=summary || true
