# Photo Booth

This software is a collection of tools I use to run photo booths at events.

The operator takes photos with a DSLR using the camera's remote (IR or wired), and they are downloaded immediately to the computer over a USB cable. The photo is shown immediately in a web browser so the guests can see their photo. The photos are then processed to add an overlay, then uploaded to a Facebook album.

## Requirements

* A DSLR supported by [gPhoto2](http://www.gphoto.org/proj/gphoto2/)
* nginx with the push-stream module for realtime viewing of new photos

## Instructions

* Install nginx with the push-stream module
* Configure the virtual host using the example in `nginx-vhost.conf`
* Set config variables in config.php
 * You can find the Facebook Page ID on the "about" page
* Connect Facebook
 * Go to http://photobooth.dev/facebook.php and sign in
 * (you'll need to visit this page periodically when the access token expires to refresh it)
* Plug in a Canon or other DSLR supported by gPhoto2
* Create your lower-right overlay graphic and save as `overlay.png` in the root folder
* Set up the camera and start waiting for incoming photos
 * `cd scripts; ./setup.sh`
 * (Run `scripts/run.sh` to restart the camera processing later)
* Run the Facebook upload script
 * `cd scripts; php upload.php`
* Open a browser to http://photobooth.dev

## License

Copyright 2016 by Aaron Parecki. See LICENSE.
