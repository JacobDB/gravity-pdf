#!/bin/bash

WP_VERSION=${WP_VERSION-latest}
WP_DEBUG=${WP_DEBUG-true}
SCRIPT_DEBUG=${SCRIPT_DEBUG-true}
DOCKER_COMPOSE_FILE_OPTIONS="-f .docker/docker-compose.yml"

CLI='cli'
CONTAINER='wordpress'
SITE_TITLE='Gravity PDF'
GF_LICENSE=$GF_LICENSE || $1

# Get the host details for the WordPress container.
HOST_IP='localhost'
MACHINE_IP='localhost'
HOST_PORT="$(docker-compose $DOCKER_COMPOSE_FILE_OPTIONS port $CONTAINER 80 | awk -F : '{printf $2}')"

# Add legacy support for older OS software
if [ command -v docker_machine > /dev/null 2>&1 ]; then
  MACHINE_IP="$(docker-machine inspect "$(docker-machine active)" --format '{{ .Driver.IPAddress }}')"
fi

# Add new variables / override existing if .env file exists
if [ -f ".env" ]; then
    set -a
    source .env
    set +a
fi