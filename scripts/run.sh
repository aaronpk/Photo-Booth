#!/bin/bash

echo "Running..."
gphoto2 --capture-tethered --hook-script=./process.sh --filename ../web/original/img_%H%M%S_%n.%C

