$(function(){

  var timer = null;
  var newPhotoSustain = 15;
  var slideshowInterval = 5;

  function toggleBodyClass() {
    if($("body").hasClass("bowie")) {
      $("body").addClass("prince").removeClass("bowie");
    } else {
      $("body").addClass("bowie").removeClass("prince");
    }
  }

  function showPhoto(type, filename) {
    $("#photo").css("background-image", "url(/"+type+"/"+filename+")");
    toggleBodyClass();
  }

  function slideshow() {
    $.get("/photo.php", function(data) {
      // console.log(data);
      showPhoto(data.type, data.filename);
      timer = setTimeout(slideshow, slideshowInterval*1000);
    })
  }

  // Subscribe to the new photos and show new ones immediately
  if(window.EventSource) {
    var socket = new EventSource('/streaming/sub?id=photo');

    socket.onopen = function() {
      // console.log("waiting for new photos");
    };

    socket.onmessage = function(event) {
      var data = JSON.parse(event.data);
      // console.log(data);
      // Show the new photo immediately
      showPhoto(data.text.type, data.text.filename);

      // Cancel pending timer
      if(timer) {
        // console.log("Clearing existing timer");
        clearTimeout(timer);
      }

      // Start a new timer to show a random photo
      timer = setTimeout(slideshow, newPhotoSustain*1000);
    }
  }

  // Start by loading a previous photo
  slideshow();

});
