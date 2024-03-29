//JS pour la page add_form.php

//implémentation de $_GET pour javascript (https://www.onlineaspect.com/2009/06/10/reading-get-variables-with-javascript/)
function $_GET(q, s) {
  s = s ? s : window.location.search;
  var re = new RegExp('&' + q + '(?:=([^&]*))?(?=&|$)', 'i');
  return (s = s.replace(/^\?/, '&').match(re)) ? (typeof s[1] == 'undefined' ? '' : decodeURIComponent(s[1])) : undefined;
}


var constraints;

var verbose = $_GET('verbose');


window.addEventListener('DOMContentLoaded', (event) => {

  document.querySelector('#rearcameraID').value = '';

  var take_photo_btn = document.querySelector('#take-photo');
  var upload_file_default_btn = document.querySelector('#upload-file-default');
  var file_upload = document.getElementById('file');
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

  setConstraints();
  init_getusermedia();

});


function setConstraints() {

  console.log("call a setConstraints");

  if ((rearcameraID.value !== '') && (rearcameraID.value !== 'inconnu')) {
    var rear_deviceID = rearcameraID.value;
    //console.log("cam arrière identifiée et prête: " + rearcameraID.value);
    constraints = {
      audio: false,
      video: {
        width: {min: 1024, ideal: 1280, max: 1920},
      /*  height: {min: 776, ideal: 720, max: 1080},*/
        deviceId: {
          exact: rear_deviceID
        }
      }
    };

  } else { // Contraintes : préférer la caméra arrière sur mobile ; pas d'audio
    constraints = {
      video: {
        width: {min: 1024, ideal: 1280, max: 1920},
      /*  height: {min: 776, ideal: 720, max: 1080},*/
        facingMode: {
          exact: 'environment'
        }
      },
      audio: false
    };
    //constraints = {audio: false, video: {mandatory: {facingMode: 'environment'}}};
  }
  console.log(constraints);
}

function getPreciseConstraints() {
  var DEVICES = [];
  var final = null;
  navigator.mediaDevices.enumerateDevices()
    .then(function(devices)
    {
      var nbdevices = devices.length;
      for (var i = 0; i < nbdevices; i++) {

        var tempDevice = devices[i];

        //FOR EACH DEVICE, PUSH TO DEVICES LIST THOSE OF KIND VIDEOINPUT (cameras)
        //AND IF THE CAMERA HAS THE RIGHT FACEMODE SETTING IT TO "final"
        if (tempDevice.kind == "videoinput") {
          DEVICES.push(tempDevice);

          if (tempDevice.facingMode == "environment" || tempDevice.label.indexOf("facing back") >= 0 || tempDevice.label.indexOf("rear") >= 0 || tempDevice.label.indexOf("Rear") >= 0 || tempDevice.label.indexOf("Back") >= 0 || tempDevice.label.indexOf("back") >= 0)
          {
            final = tempDevice;
            console.log("caméra arrière trouvée : " + final.label);
          }
        }
      }



      //If couldnt find a suitable camera, switch to backup solution with input="image" control
      if (final == null) {
        console.log("La caméra ne respecte pas les contraintes, on passe à la solution de rechange !");
        StopVideo();
        return 0;


      } else {
        rearcameraID.value = final.deviceId; //on sauve l'ID dans notre boîte de texte

        //Set the constraints and call getUserMedia
        constraints = {
          audio: false,
          video: {
            width: {min: 640, ideal: 1024, max: 1024},
            deviceId: {
              exact: final.deviceId
            }
          }
        };

        console.log(constraints);
        console.log("2e call à getusermedia avec les bonnes contraintes");

        newcall_getusermedia();


      }
    });
}



function populate_camera_list() {
  navigator.mediaDevices.enumerateDevices()
    //.then(gotDevices)
    .then(

      result => {
        gotDevices(result);
      }
    )
    .then(
      result => {
        setConstraints(); // appel normal à setConstraints
      }
    )

    .catch(function(err) {
      console.log(err.name + ": " + err.message);
      rearcameraID.value = 'inconnu';
      setConstraints(); // appel à setConstraints avec rearcameraID.value= 'iconnu'

    });
}







function PlayVideo() {

  newcall_getusermedia();
  is_camera_active = true;

}

function StopVideo() {

  var stream = video.srcObject;
  if (stream.getTracks())
  {
    var tracks = stream.getTracks();
  }
  else if (stream.getVideoTracks())
  {
    var tracks = stream.getVideoTracks();
  }


  for (i = 0; i < tracks.length; ++i) ////better backwards compatibility than tracks.forEach (ES6 and later)
        {
          tracks[i].stop();
        }

  is_camera_active = false;
  video.srcObject = null;
}


//méthode tarabiscotée pour lancer getusermedia pour améliorer la compatibilité
function init_getusermedia() {



  // Older browsers might not implement mediaDevices at all, so we set an empty object first
  if (navigator.mediaDevices === undefined) {
    navigator.mediaDevices = {};
  }

  // Some browsers partially implement mediaDevices. We can't just assign an object
  // with getUserMedia as it would overwrite existing properties.
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




  navigator.mediaDevices.getUserMedia(constraints)
    .then(function(stream)

      {
        console.log("1er call à getusermedia pour accéder aux labels des cameras");

        if (rearcameraID.value == '') {
          populate_camera_list();
          getPreciseConstraints();
        }

        var video = document.querySelector('video');
        // Older browsers may not have srcObject
        if ("srcObject" in video) {
          video.srcObject = stream;

        } else {
          // for compatibility with older browsers
          video.src = window.URL.createObjectURL(stream);
          //console.log("pas de video srcobject");
        }


        video.onloadedmetadata = function(e) {

          video.play();
            is_camera_active = true;
            show_camera_controls();


        };
      })
    .catch(function(err) {

      console.log("erreur 1er call gUm: " + err.name + ": " + err.message);

      is_camera_active = false;
      show_input_image_controls();

    });

}

function show_camera_controls()
{

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

function show_input_image_controls()
{
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


function newcall_getusermedia(firstcall) {


  navigator.mediaDevices.getUserMedia(constraints)
    .then(function(stream) {

      var video = document.querySelector('video');
      snap_final.addEventListener("click", PrisePhoto); //le canvas final du thumbnail fonctionne comme le bouton prise de vue
      // Older browsers may not have srcObject
      if ("srcObject" in video) {
        video.srcObject = stream;
        //console.log("video srcobject");
      } else {
        // for compatibility with older browsers
        video.src = window.URL.createObjectURL(stream);
        //console.log("pas de video srcobject");
      }

    })
    .catch(function(err) {
      console.log(err.name + ": " + err.message);
    });
}


function gotDevices(deviceInfos) {

  for (var i = 0; i !== deviceInfos.length; ++i) {
    var deviceInfo = deviceInfos[i];
    var option = document.createElement('option');
    option.value = deviceInfo.deviceId;
    if (deviceInfo.kind === 'videoinput') {
      option.text = deviceInfo.label || 'Camera ' +
        (videoSelect.length + 1);
      videoSelect.appendChild(option);
    }
  }


  var found = false;
  for (i = 0; i < videoSelect.options.length; i++) {

    if ((videoSelect.options[i].text.indexOf('Rear') !== -1) || (videoSelect.options[i].text.indexOf('rear') !== -1) || (videoSelect.options[i].text.indexOf('Back') !== -1) || (videoSelect.options[i].text.indexOf('back') !== -1)) //true
    {

      videoSelect.value = videoSelect.options[i].value;
      rearcameraID.value = videoSelect.options[i].value;
      found = true;
    }
  }
  if (found == 'false') {
    rearcameraID.value = "inconnu";
  }
}





function SwitchCameraActiveState() {
  if (is_camera_active) {

    StopVideo();
  } else {
    PlayVideo();
  }
}

/* Obsolète : plus rapide, mais utilise trop de batterie (ne met pas la caméra sur pause, seulement la vidéo)*/
function SwitchCameraPausedState() {
  if (video.paused) {
    video.play();
    console.log("Camera réactivée");
  } else {
    video.pause();
    console.log("Camera sur pause");
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

  if (is_camera_active) {
    StopVideo();
  }

  var img = new Image;
  img.src = URL.createObjectURL(e.target.files[0]);
  console.log("UploadFichier");
  img.onload = function() {
    getOrientation(e.target.files[0], function(orientation) {

      document.getElementById('image_final').value = DessineVignette('imagesnap', img, orientation);
    });

    //context.drawImage(img, 0,0);
    console.log("img.onload");

    var upload_file_default_btn = document.getElementById("upload-file-default");
    //upload_file_default_btn.classList.remove("pulse");
    //upload_file_default_btn.classList.add("grey");
    upload_file_default_btn.classList.add("invisible");
    var canvas_final = document.getElementById('snap_final');
    canvas_final.classList.remove("invisible");

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

  var compression = 1.0;
  var size = 1000;

  //si l'image uploadée est passée en argument
  if (type == 'imagesnap') {

    var canvas2 = document.getElementById('hidden_snap_canvas'),
      ctx2 = canvas2.getContext('2d'),
      canvas3 = document.getElementById('snap_final'),
      ctx3 = canvas3.getContext('2d'),
      vw = elem.width,
      vh = elem.height;

    canvas2.width = size;
    canvas2.height = size;
    canvas3.width = size;
    canvas3.height = size;

    //on calcule le plus grand carré au milieu de l'image
    var dimension = Math.min(vw, vh);
    var sx = (vw - dimension) / 2;
    var sy = (vh - dimension) / 2;

    //on crop le plus grand carré au milieu de l'image et on la redimensionne dans un carré de size x size
    ctx2.drawImage(elem, sx, sy, dimension, dimension, 0, 0, size, size);

    //on utilise l'orientation EXIF de l'image (le cas échéant) pour réorienter le canevas vers le haut puis on dessine
    if (orientation == 6) {
      ctx3.clearRect(0, 0, canvas2.width, canvas2.height);
      ctx3.translate(canvas2.width / 2, canvas2.height / 2);
      ctx3.rotate(90 * Math.PI / 180);
      ctx3.drawImage(canvas2, -canvas2.width / 2, -canvas2.width / 2);
    } else if (orientation == 8) {
      ctx3.clearRect(0, 0, canvas2.width, canvas2.height);
      ctx3.translate(canvas2.width / 2, canvas2.height / 2);
      ctx3.rotate(270 * Math.PI / 180);
      ctx3.drawImage(canvas2, -canvas2.width / 2, -canvas2.width / 2);
    } else if (orientation == 3) {
      ctx3.clearRect(0, 0, canvas2.width, canvas2.height);
      ctx3.translate(canvas2.width / 2, canvas2.height / 2);
      ctx3.rotate(180 * Math.PI / 180);
      ctx3.drawImage(canvas2, -canvas2.width / 2, -canvas2.width / 2);
    } else {
      ctx3.clearRect(0, 0, canvas2.width, canvas2.height);
      ctx3.drawImage(canvas2, 0, 0);
    }

    //on cache le svg avec les bords discontinus
    var bords_file_upload = document.getElementById("bords_file_upload");
    bords_file_upload.classList.add("invisible");

    // on affiche le canevas final
    canvas3.classList.remove("invisible");
    return canvas3.toDataURL("image/jpeg", compression);

  } else if ((type == 'videosnap') && (video.readyState === 4)) {

    var canvas_streaming = document.getElementById('video_streaming'),
      canvas1 = document.getElementById('hidden_snap_canvas'),
      ctx1 = canvas1.getContext('2d'),
      canvas2 = document.getElementById('snap_final'),
      ctx2 = canvas2.getContext('2d');
    canvas2.width = size;
    canvas2.height = size;


    var vw = video.videoWidth,
      vh = video.videoHeight;
    canvas1.width = vw;
    canvas1.height = vh;
    //console.log("vw: "+ vw + "vh: " + vh);

    ctx1.drawImage(video, 0, 0, vw, vh, 0, 0, vw, vh);

    var dimension = Math.min(vw, vh);
    var sx = (vw - dimension) / 2;
    var sy = (vh - dimension) / 2;

    //On cache le canvas avec le streaming
    canvas_streaming.classList.add("invisible");
    canvas2.classList.remove("invisible");
    //Dessine l'image video dans notre Canvas
    ctx2.drawImage(canvas1, sx, sy, dimension, dimension, 0, 0, size, size);

    canvas2.classList.add('flash');
    setTimeout(function() {
      canvas2.classList.remove('flash');
    }, 500);

    return canvas2.toDataURL("image/jpeg", compression);
  }

  //retourne une image URI (possible de jouer avec la qualité du jpeg avec .toDataURL)

}



function DrawVideoOnCanvas() {

  if (video.readyState === 4) {
    var canvas1 = document.getElementById('hidden_streaming_canvas'),
      ctx1 = canvas1.getContext('2d'),
      canvas2 = document.getElementById('video_streaming'),
      ctx2 = canvas2.getContext('2d');

    var vw = video.videoWidth,
      vh = video.videoHeight;

    var div_width;
    canvas1.width = vw;
    canvas1.height = vh;

    ctx1.drawImage(video, 0, 0, vw, vh, 0, 0, vw, vh);

    canvas2.style.width = '100%';
    canvas2.style.height = '';

    if (canvas2.offsetWidth > 400) {
      div_width = 400;
      canvas2.style.width = '400'
    } else {
      div_width = canvas2.offsetWidth;
    }




    // ...then set the internal size to match
    canvas2.width = div_width;
    canvas2.height = div_width;

    var dimension = Math.min(vw, vh);

    var sx = (vw - dimension) / 2;

    var sy = (vh - dimension) / 2;




    ctx2.drawImage(canvas1, sx, sy, dimension, dimension, 0, 0, div_width, div_width);
  };
  //context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight, 0, 0, Math.floor(200*ratio), 200);
  setTimeout(DrawVideoOnCanvas, 20);
}



//OBSOLETE - CAN BE DELETED

function hasGetUserMedia() {
  //test si l'user possede getUserMedia
  return !!(navigator.mediaDevices &&
    navigator.mediaDevices.getUserMedia);
}


//OBSOLETE - CAN BE DELETED
/*
download_img = function(el) {

  var canvas_final = document.getElementById('snap_final');
  var image = canvas_final.toDataURL("image/jpeg", 0.85);
  el.href = image;
};
*/


video.addEventListener('play', function() {
  DrawVideoOnCanvas('videostream');
}, false);
