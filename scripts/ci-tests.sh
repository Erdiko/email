#!/bin/sh

# Run unit tests inside of docker
cd /code/vendor/erdiko/email/tests/
phpunit AllTests
