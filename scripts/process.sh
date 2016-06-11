#!/bin/bash

self=`basename $0`

case "$ACTION" in
  init)
    echo "$self: INIT"
    ;;
  start)
    echo "$self: START"
    ;;
  download)
    fn=`basename $ARGUMENT`
    original=../web/original/$fn
    final=../web/final/$fn
    echo "$self: DOWNLOAD to $fn"

    convert $original -auto-orient $original

    curl "http://photobooth.dev/streaming/pub?id=photo" -d "{\"type\":\"original\",\"filename\":\""$fn\""}"

    # effects

    # ./lucisarteffect $original $final

    # try 0.4 darker, 0.6 only a little darker
    convert $original -level 0%,100%,0.6 $final

    # add overlay
    composite -gravity SouthEast ../overlay.png $final $final

    curl "http://photobooth.dev/streaming/pub?id=photo" -d "{\"type\":\"final\",\"filename\":\""$fn\""}"

    ;;
  stop)
    echo "$self: STOP"
    ;;
  *)
    echo "$self: Unknown action: $ACTION"
    ;;
esac

exit 0
