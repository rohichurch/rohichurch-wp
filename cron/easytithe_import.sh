#!/bin/bash

# Script for importing contributions from EasyTithe to BreezeChMS.
# Logs into EasyTithe and imports contributions into BreezeChMS using
# the Python Breeze API. This script is used by the heroku-scheduler (cron).

set -e

YESTERDAY_DATE=$(date +%m/%d/%Y -d "yesterday")
EASYTITHE_IMPORT_TMP_DIR=/tmp/$$.easytithe_import
PYTHON_BIN=$(which python)
PIP_BIN=pip

function clean_up() {
    echo "Cleaning up directory: ${EASYTITHE_IMPORT_TMP_DIR}"
    if [[ -d "$EASYTITHE_IMPORT_TMP_DIR" ]]
    then
        rm -rf "$EASYTITHE_IMPORT_TMP_DIR"
    fi
}

function setup_environment() {
  local working_dir=$1
  echo "Setting up environment in directory: ${working_dir}"

  # Download pip and install.
  if hash pip 2>/dev/null; then
    echo "pip is installed."
  else
    echo "Installing pip..."
    /usr/bin/curl --silent --show-error --retry 5  \
        https://bootstrap.pypa.io/get-pip.py -o get-pip.py
    $PYTHON_BIN get-pip.py --user
    PIP_BIN=~/.local/bin/pip
  fi

  # Clone pyBreezeChMS repository to temp directory.
  echo "Cloning https://github.com/alexortizrosado/pyBreezeChMS.git ..."
  /usr/bin/git clone https://github.com/alexortizrosado/pyBreezeChMS.git $working_dir

  # Install dependencies.
  echo "Installing dependencies..."
  cd $working_dir
  /usr/bin/git submodule update --init --recursive
  $PIP_BIN install --user  -r requirements.txt
  echo "Environment has been setup."
}

trap clean_up EXIT

echo "Creating directory: ${EASYTITHE_IMPORT_TMP_DIR}"
mkdir "$EASYTITHE_IMPORT_TMP_DIR"
setup_environment $EASYTITHE_IMPORT_TMP_DIR

cd $EASYTITHE_IMPORT_TMP_DIR/samples/

echo "Running easytithe_importer..."
$PYTHON_BIN easytithe_importer.py \
    --username $EASYTITHE_USERNAME \
    --password $EASYTITHE_PASSWORD \
    --breeze_api_key $BREEZE_API_KEY \
    --breeze_url $BREEZE_API_URL \
    --start_date $YESTERDAY_DATE \
    --end_date $YESTERDAY_DATE

trap - EXIT
clean_up
exit 0
