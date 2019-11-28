//JS pour la page add_form.php

//implémentation de $_GET pour javascript (https://www.onlineaspect.com/2009/06/10/reading-get-variables-with-javascript/)
function $_GET(q, s) {
  s = s ? s : window.location.search;
  var re = new RegExp('&' + q + '(?:=([^&]*))?(?=&|$)', 'i');
  return (s = s.replace(/^\?/, '&').match(re)) ? (typeof s[1] == 'undefined' ? '' : decodeURIComponent(s[1])) : undefined;
}

var constraints = {
  video: {
    width: {
      min: 1024,
      ideal: 1280,
      max: 1920
    },
    facingMode: {
      exact: 'environment'
    }
  },
  audio: false
};

var verbose = $_GET('verbose');


window.addEventListener('DOMContentLoaded', (event) => {


  document.querySelector('#rearcameraID').value = '';

  var take_photo_btn = document.querySelector('#take-photo');
  var upload_file_default_btn = document.querySelector('#upload-file-default');
  var file_upload = document.getElementById('file_upload');
  var video = document.querySelector("#video");
  var canvas_streaming = document.getElementById('video_streaming');
  var is_camera_active = false;
  var snap_final = document.getElementById('snap_final');


  canvas_streaming.addEventListener("click", PrisePhoto); //le canvas du streaming video fonctionne comme le bouton prise de vue
  take_photo_btn.addEventListener("click", PrisePhoto); //on active le bouton prise de vue
  file_upload.addEventListener('change', UploadFichier); //on active le bouton d'upload de photo
  //  snap_final.addEventListener("click", UploadFichier); //on active  l'upload de photo en cas de clic sur le snap final

  var tagInput1 = new TagsInput({
    selector: 'input-tags',
  });

  init_materialize();

  if (!detectAndroidFirefox())
  {
    // only initialize getusermedia camera stream if not on Firefox on android (due to https://bugzilla.mozilla.org/show_bug.cgi?id=1250872)
   init_getusermedia();
  }
  //if the above fails : fallback to default with already visible #file_upload_container
});


function detectAndroidFirefox () {
   var agent = navigator.userAgent.toLowerCase();
   return (agent.indexOf('firefox') > -1 && agent.indexOf("android") > -1);
}

function getPreciseConstraints() {
  var DEVICES = [];
  var final = null;
  navigator.mediaDevices.enumerateDevices()
    .then(function(devices) {
      var nbdevices = devices.length;
      for (var i = 0; i < nbdevices; i++) {

        var tempDevice = devices[i];

        //FOR EACH DEVICE, PUSH TO DEVICES LIST THOSE OF KIND VIDEOINPUT (cameras)
        //AND IF THE CAMERA HAS THE RIGHT FACEMODE SETTING IT TO "final"
        if (tempDevice.kind == "videoinput") {
          DEVICES.push(tempDevice);

          if (tempDevice.facingMode == "environment" || tempDevice.label.indexOf("facing back") >= 0 || tempDevice.label.indexOf("rear") >= 0 || tempDevice.label.indexOf("Rear") >= 0 || tempDevice.label.indexOf("Back") >= 0 || tempDevice.label.indexOf("back") >= 0) {
            final = tempDevice;
            console.log("caméra arrière trouvée : " + final.label);
          }

        }
      }


      //If couldnt find a suitable camera, switch to backup solution with input="image" control
      if (final == null) {
        console.log("La caméra ne respecte pas les contraintes, on passe à la solution de rechange !");
        StopVideo();
        show_input_image_controls();
        return 0;


      } else {
        rearcameraID.value = final.deviceId; //on sauve l'ID dans notre boîte de texte

        //Set the constraints and call getUserMedia
        constraints = {
          audio: false,
          video: {
            width: {
              min: 640,
              ideal: 1024,
              max: 1024
            },
            deviceId: {
              exact: final.deviceId
            }
          }
        };

        console.log(constraints);
        console.log("2e call à getusermedia avec les bonnes contraintes");

        call_getusermedia();

      }
    });
}



function PlayVideo() {

  call_getusermedia();
  is_camera_active = true;

}

function StopVideo() {
  var stream = video.srcObject;
  if (stream.getTracks()) {
    var tracks = stream.getTracks();
  }
  if (stream.getVideoTracks()) {
    var tracks = stream.getVideoTracks();
  }


  for (i = 0; i < tracks.length; ++i) ////better backwards compatibility than tracks.forEach (ES6 and later)
  {
    tracks[i].stop();
  }

  is_camera_active = false;

  video.srcObject = null;
}


//polyfill to improve compatibility with older browsers
function init_getusermedia() {

  // Older browsers might not implement mediaDevices at all, so we set an empty object first
  if (navigator.mediaDevices === undefined) {
    navigator.mediaDevices = {};
  }

  // Some browsers partially implement mediaDevices.
  // Here, we will just add the getUserMedia property if it's missing.
  if (navigator.mediaDevices.getUserMedia === undefined) {
    navigator.mediaDevices.getUserMedia = function(constraints) {

      // First get ahold of the legacy getUserMedia, if present
      var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

      // Some browsers just don't implement it - return a rejected promise with an error
      // to keep a consistent interface
      if (!getUserMedia) {
        return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
      }

      // Otherwise, wrap the call to the old navigator.getUserMedia with a Promise
      return new Promise(function(resolve, reject) {
        getUserMedia.call(navigator, constraints, resolve, reject);
      });
    }
  }

  var firstcall = true;
  console.log("1er call à getusermedia pour accéder aux labels des cameras");
  call_getusermedia(firstcall);


}

function show_camera_controls() {

  var file_upload_container = document.getElementById("file_upload_container");
  file_upload_container.classList.add("invisible");

  var canvas_streaming = document.getElementById('video_streaming');
  canvas_streaming.classList.remove("invisible");
  var canvas_final = document.getElementById('snap_final');
  canvas_final.classList.add("invisible");
  var take_photo_btn = document.querySelector('#take-photo');
  take_photo_btn.classList.remove("invisible");
  //take_photo_btn.classList.add("pulse");
  take_photo_btn.classList.remove("inactive");
  var video_streaming_controls = document.getElementById('video_streaming_controls');
  video_streaming_controls.classList.remove("invisible");
}

function show_input_image_controls() {
  var take_photo_btn = document.querySelector('#take-photo');
  take_photo_btn.classList.add("invisible");
  var video_streaming_controls = document.getElementById('video_streaming_controls');
  video_streaming_controls.classList.add("invisible");
  var canvas_video = document.getElementById("video_streaming");
  canvas_video.classList.add("invisible");
  var file_upload_container = document.getElementById("file_upload_container");
  file_upload_container.classList.remove("invisible");
  var canvas_final = document.getElementById('snap_final');
  canvas_final.classList.add("invisible");
  var upload_file_default_btn = document.querySelector('#upload-file-default');
  //upload_file_default_btn.classList.add("pulse");
}


function call_getusermedia(firstcall) {



  navigator.mediaDevices.getUserMedia(constraints)
    .then(function(stream) {

      var video = document.querySelector('video');
      snap_final.addEventListener("click", PrisePhoto); //le canvas final du thumbnail fonctionne comme le bouton prise de vue
      // Older browsers may not have srcObject
      if ("srcObject" in video) {
        video.srcObject = stream;
      } else {
        // for compatibility with older browsers
        video.src = window.URL.createObjectURL(stream);
      }

      if (firstcall) {
        if (rearcameraID.value == '') {

          //populate_camera_list();

          getPreciseConstraints();

        }
        video.onloadedmetadata = function(e) {
          video.play();
          is_camera_active = true;
          show_camera_controls();
        };
      }

    })
    .catch(function(err) {
      console.log(err.name + ": " + err.message);

      is_camera_active = false;
      if (firstcall) {
        show_input_image_controls();
      }
    });
}



function SwitchCameraActiveState() {
  if (is_camera_active) {

    StopVideo();
  } else {
    PlayVideo();
  }
}


function PrisePhoto(e) {
  e.preventDefault();

  //var vignette = DrawOnCanvas('videopreview');
  document.getElementById('image_final').value = DessineVignette('videosnap');

  SwitchCameraActiveState();
  var take_photo_btn = document.querySelector('#take-photo');
  //  take_photo_btn.classList.remove("pulse");
  take_photo_btn.classList.add("inactive");

}


function UploadFichier(e) {

  //on cache le svg avec les bords discontinus
  var bords_file_upload = document.getElementById("bords_file_upload");
  bords_file_upload.classList.add("invisible");
  var upload_file_default = document.getElementById("upload-file-default");
  upload_file_default.classList.add("invisible");
  var spinner_imagesnap = document.getElementById("spinner_imagesnap");
  spinner_imagesnap.classList.remove("invisible");
  var canvas_final = document.getElementById('snap_final');
  canvas_final.classList.add("invisible");


document.getElementById('image_final').reset;

  var img = new Image;
  img.src = URL.createObjectURL(e.target.files[0]);



 img.onload = function()
  {

    console.log("img.onload");
    getOrientation(e.target.files[0], function(orientation)
      {

        document.getElementById('image_final').value = DessineVignette('imagesnap', img, orientation);
      });

    canvas_final.classList.remove("invisible");
    spinner_imagesnap.classList.add("invisible");

  }

  if (is_camera_active) {
    StopVideo();
  }
}

// from http://stackoverflow.com/a/32490603
function getOrientation(file, callback) {
  var reader = new FileReader();

  reader.onload = function(event) {
    var view = new DataView(event.target.result);

    if (view.getUint16(0, false) != 0xFFD8) return callback(-2);

    var length = view.byteLength,
      offset = 2;

    while (offset < length) {
      var marker = view.getUint16(offset, false);
      offset += 2;

      if (marker == 0xFFE1) {
        if (view.getUint32(offset += 2, false) != 0x45786966) {
          return callback(-1);
        }
        var little = view.getUint16(offset += 6, false) == 0x4949;
        offset += view.getUint32(offset + 4, little);
        var tags = view.getUint16(offset, little);
        offset += 2;

        for (var i = 0; i < tags; i++)
          if (view.getUint16(offset + (i * 12), little) == 0x0112)
            return callback(view.getUint16(offset + (i * 12) + 8, little));
      } else if ((marker & 0xFF00) != 0xFF00) break;
      else offset += view.getUint16(offset, false);
    }
    return callback(-1);
  };

  reader.readAsArrayBuffer(file.slice(0, 64 * 1024));
};


function DessineVignette(type, elem, orientation) {

  var compression = 0.95;
  var size = 500;

  //si l'image uploadée est passée en argument
  if (type == 'imagesnap') {

    var canvas = document.getElementById('snap_final'),
      ctx = canvas.getContext('2d'),
      vw = elem.width,
      vh = elem.height;

    canvas.width = size;
    canvas.height = size;

    //on calcule le plus grand carré au milieu de l'image
    var dimension = Math.min(vw, vh);
    var sx = (vw - dimension) / 2;
    var sy = (vh - dimension) / 2;

    ctx.clearRect(0, 0, size, size);
    //on utilise l'orientation EXIF de l'image (le cas échéant) pour réorienter le canevas vers le haut puis on dessine
    if (orientation == 6) {

      ctx.clearRect(0, 0, size, size);
      ctx.transform(0, 1, -1, 0, size, 0);
      ctx.drawImage(elem, sx, sy, dimension, dimension, 0, 0, size, size);
    } else if (orientation == 8) {

      ctx.clearRect(0, 0, size, size);
      ctx.transform(0, -1, 1, 0, 0, size);
      ctx.drawImage(elem, sx, sy, dimension, dimension, 0, 0, size, size);
    } else if (orientation == 3) {

      ctx.clearRect(0, 0, size, size);
      ctx.transform(-1, 0, 0, -1, size, size);
      ctx.drawImage(elem, sx, sy, dimension, dimension, 0, 0, size, size);
    } else {


      ctx.drawImage(elem, sx, sy, dimension, dimension, 0, 0, size, size);
    }

    // on affiche le canevas final
    canvas.classList.remove("invisible");
    return canvas.toDataURL("image/jpeg", compression);
  }

  else if ((type == 'videosnap') && (video.readyState === 4)) {

    var canvas_streaming = document.getElementById('video_streaming'),
      canvas = document.getElementById('snap_final'),
      ctx = canvas.getContext('2d');
    canvas.width = size;
    canvas.height = size;

    var vw = video.videoWidth,
      vh = video.videoHeight;

    var dimension = Math.min(vw, vh);
    var sx = (vw - dimension) / 2;
    var sy = (vh - dimension) / 2;

    //On cache le canvas avec le streaming
    canvas_streaming.classList.add("invisible");
    canvas.classList.remove("invisible");
    //Dessine l'image video dans notre Canvas
    ctx.drawImage(video, sx, sy, dimension, dimension, 0, 0, size, size);

    canvas.classList.add('flash');
    setTimeout(function() {
      canvas.classList.remove('flash');
    }, 500);

    return canvas.toDataURL("image/jpeg", compression);
  }

}



function DrawVideoOnCanvas() {

  if (video.readyState === 4) {
    var canvas = document.getElementById('video_streaming'),
      ctx = canvas.getContext('2d');

    var vw = video.videoWidth,
      vh = video.videoHeight;

    var div_width;

    canvas.style.width = '100%';
    canvas.style.height = '';

    if (canvas.offsetWidth > 400) {
      div_width = 400;
      canvas.style.width = '400'
    } else {
      div_width = canvas.offsetWidth;
    }

    // ...then set the internal size to match
    canvas.width = div_width;
    canvas.height = div_width;

    var dimension = Math.min(vw, vh);

    var sx = (vw - dimension) / 2;
    var sy = (vh - dimension) / 2;


    ctx.drawImage(video, sx, sy, dimension, dimension, 0, 0, div_width, div_width);
  };
  //context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight, 0, 0, Math.floor(200*ratio), 200);
  setTimeout(DrawVideoOnCanvas, 20);
}




video.addEventListener('play', function() {
  DrawVideoOnCanvas('videostream');
}, false);
