#!/bin/bash

killall PTPCamera

echo Waiting
sleep 2

echo "Getting camera summary"
gphoto2 --summary

echo "Waiting..."
sleep 5

echo "Setting image format"
gphoto2 --set-config /main/imgsettings/imageformat=4

./run.sh
