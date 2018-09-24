#!/bin/bash

# Script for importing contributions from EasyTithe to BreezeChMS.
# Logs into EasyTithe and imports contributions into BreezeChMS using
# the Python Breeze API. This script is used by the heroku-scheduler (cron).

set -e

EASYTITHE_USERNAME=${EASYTITHE_USERNAME?"Need to set EASYTITHE_USERNAME"}
EASYTITHE_PASSWORD=${EASYTITHE_PASSWORD?"Need to set EASYTITHE_PASSWORD"}
BREEZE_API_KEY=${BREEZE_API_KEY?"Need to set BREEZE_API_KEY"}
BREEZE_API_URL=${BREEZE_API_URL?"Need to set BREEZE_API_URL"}
PYBREEZECHMS_GIT_REPOSITORY=${PYBREEZECHMS_GIT_REPOSITORY:="https://github.com/alexortizrosado/pyBreezeChMS.git"}

YESTERDAY_DATE=$([ `uname` == "Darwin" ] && date -v-1d +%m/%d/%Y || date +%m/%d/%Y -d "yesterday")
EASYTITHE_IMPORT_TMP_DIR=/tmp/$$.easytithe_import
PYTHON_BIN=$(which python)
PIP_BIN=pip

function clean_up() {
    echo "Cleaning up directory: ${EASYTITHE_IMPORT_TMP_DIR}"
    if [[ -d "$EASYTITHE_IMPORT_TMP_DIR" ]]
    then
        echo "rm -rf $EASYTITHE_IMPORT_TMP_DIR"
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
  echo "Cloning ${PYBREEZECHMS_GIT_REPOSITORY} ..."
  /usr/bin/git clone ${PYBREEZECHMS_GIT_REPOSITORY} $working_dir

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
