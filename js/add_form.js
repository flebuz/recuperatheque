//JS pour la page add_form.php

window.addEventListener('DOMContentLoaded', (event) => {



    var take_photo_btn = document.querySelector('#take-photo');
    var upload_file_default_btn = document.querySelector('#upload-file-default');
    var file_upload = document.getElementById('file');
    var video = document.querySelector("#video");
    var is_camera_active = false;


    take_photo_btn.addEventListener("click", PrisePhoto); //on active le bouton prise de vue
    file_upload.addEventListener('change', UploadFichier); //on active le bouton d'upload de photo
    video.addEventListener("click", PrisePhoto);

    init_materialize();

    if (hasGetUserMedia()) {
      //M.toast({html: "Tip top"});
      init_getusermedia_simple();

    }


    else {

      console.log("getUserMedia() n'est pas supporté par votre navigateur :(");

      take_photo_btn.classList.add("invisible"); //on cache le bouton prise de vue (puisqu'inutile sans getusermedia)
      //var video = document.querySelector('video');
      //video.classList.add("invisible");
      var canvas_video = document.getElementById("video_streaming");
      canvas_video.classList.add("invisible");
      var file_upload_container = document.getElementById("file_upload_container");
      file_upload_container.classList.remove("invisible");
    var canvas_final = document.getElementById('snap_final');
      canvas_final.classList.add("invisible");
      var upload_file_default_btn = document.querySelector('#upload-file-default');
      upload_file_default_btn.classList.add("pulse");
      is_camera_active = false;

    }


});

//console.log(adapter.browserDetails.browser);


function init_materialize()
{
  /* Script requis par Materialize pour activer le composant Dropdown (qui sont définis en "visibility:hidden" trouvent tout en bas de index.php)*/
  var elems = document.querySelectorAll('.dropdown-trigger');
  var instance = M.Dropdown.init(elems, { coverTrigger: false, constrainWidth: false, outDuration:0});

  var elems2 = document.querySelectorAll('.fixed-action-btn');
   var instances = M.FloatingActionButton.init(elems2);

}






function PlayVideo()
{
  init_getusermedia_simple();
  is_camera_active = true;
  console.log("Caméra activée");
}

function StopVideo()
{
  var stream = video.srcObject;
  var tracks = stream.getTracks();

  tracks.forEach(function(track) {
    track.stop();
    is_camera_active = false;
    console.log("Camera désactivée");
  });

  video.srcObject = null;
}

function hasGetUserMedia() {
  //test si l'user possede getUserMedia
  return !!(navigator.mediaDevices &&
  navigator.mediaDevices.getUserMedia);
}



function init_getusermedia_simple() {
  // solution issue de https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
      // Contraintes : préférer la caméra arrière sur mobile ; pas d'audio
      var constraints = {  video: { facingMode: { exact: "environment"} }, audio: false };

      navigator.mediaDevices.getUserMedia(constraints)
      .then(function(mediaStream) {
        var video = document.querySelector('video');

          video.srcObject = mediaStream;
        video.onloadedmetadata = function(e) {
          video.play();


          is_camera_active = true;
          var file_upload_container = document.getElementById("file_upload_container");
          file_upload_container.classList.add("invisible");

          var canvas_streaming= document.getElementById('video_streaming');
          canvas_streaming.classList.remove("invisible");
          var canvas_final = document.getElementById('snap_final');
          canvas_final.classList.add("invisible");
          var take_photo_btn = document.querySelector('#take-photo');
          take_photo_btn.classList.remove("invisible");
          take_photo_btn.classList.add("pulse");
          take_photo_btn.classList.remove("inactive");




        };
      })
      .catch(function(err) {
        console.log(err.name + ": " + err.message);
        M.toast({html: err.name + ": " + err.message});

        var take_photo_btn = document.querySelector('#take-photo');
        take_photo_btn.classList.add("invisible");
        var canvas_video = document.getElementById("video_streaming");
        canvas_video.classList.add("invisible");
        var file_upload_container = document.getElementById("file_upload_container");
        file_upload_container.classList.remove("invisible");
      var canvas_final = document.getElementById('snap_final');
        canvas_final.classList.add("invisible");
        var upload_file_default_btn = document.querySelector('#upload-file-default');
        upload_file_default_btn.classList.add("pulse");
        is_camera_active = false;
      });
       // always check for errors at the end.
      //M.toast({html: "Utilisez une connexion sécurisée (https)"});

}

//méthode tarabiscotée pour lancer getusermedia pour améliorer la compatibilité (temporaire pour les tests)
function init_getusermedia(){



  // Contraintes : préférer la caméra arrière sur mobile ; pas d'audio
  var constraints = {  video: { facingMode: { exact: "environment"} }, audio: false };

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

navigator.mediaDevices.getUserMedia({ audio: true, video: true })
.then(function(stream) {
  var video = document.querySelector('video');
  // Older browsers may not have srcObject
  if ("srcObject" in video) {
    video.srcObject = stream;
  } else {
    // Avoid using this in new browsers, as it is going away.
    video.src = window.URL.createObjectURL(stream);
  }
  video.onloadedmetadata = function(e) {
    video.play();
  };
})
.catch(function(err) {
  console.log(err.name + ": " + err.message);
});
}

function SwitchCameraActiveState()
{
  if (is_camera_active)
  {
  const ShutterSound = new Audio("assets/inspectorj__camera-shutter-fast-a.wav"); //On prépare le son "Camera Shutter, Fast, A.wav" by InspectorJ (www.jshaw.co.uk) of Freesound.org
   ShutterSound.play(); //jouer le son seulement quand on prend la photo
   StopVideo();
 }
  else
    {PlayVideo();}
}


function SwitchCameraPausedState()
{
  if (video.paused)
  {video.play();
  console.log("Camera réactivée");}
  else
    {video.pause();
    console.log("Camera sur pause");}
}

function PrisePhoto(e){
     e.preventDefault();


     //var vignette = DrawOnCanvas('videopreview');
     DessineVignette('videosnap');

      SwitchCameraActiveState();
      var take_photo_btn = document.querySelector('#take-photo');
      take_photo_btn.classList.remove("pulse");
      take_photo_btn.classList.add("inactive");



}

function UploadFichier(e) {

  if(is_camera_active) {StopVideo();}

  var img = new Image;
  img.src = URL.createObjectURL(e.target.files[0]);
console.log("UploadFichier");
 img.onload = function() {
getOrientation(e.target.files[0],function(orientation) {

    var vignette = DessineVignette('imagesnap', img, orientation);
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
      }
      else if ((marker & 0xFF00) != 0xFF00) break;
      else offset += view.getUint16(offset, false);
    }
    return callback(-1);
  };

  reader.readAsArrayBuffer(file.slice(0, 64 * 1024));
};

function DessineVignette(type, elem, orientation){

  //si l'image uploadée est passée en argument
  if (type=='imagesnap') {

    var canvas2 = document.getElementById('hidden_snap_canvas'),
        ctx2 = canvas2.getContext('2d'),
        canvas3 = document.getElementById('snap_final'),
        ctx3 = canvas3.getContext('2d'),
        vw = elem.width,
        vh = elem.height;

        canvas2.width=300;
        canvas2.height=300;
        canvas3.width=300;
        canvas3.height=300;

//on calcule le plus grand carré au milieu de l'image
    var dimension = Math.min(vw, vh);
    var sx = (vw - dimension)/2;
    var sy= (vh - dimension)/2;

//on crop le plus grand carré au milieu de l'image et on redimensionne dans un carré de 200x200
    ctx2.drawImage(elem, sx, sy, dimension, dimension, 0, 0, 300, 300);

//on utilise l'orientation EXIF de l'image (le cas échéant) pour réorienter le canevas vers le haut puis on dessine
  if (orientation==6) {
          ctx3.clearRect(0,0,canvas2.width,canvas2.height);
          ctx3.translate(canvas2.width/2,canvas2.height/2);
          ctx3.rotate(90*Math.PI/180);
          ctx3.drawImage(canvas2,-canvas2.width/2,-canvas2.width/2);
        }
else if (orientation==8) {
          ctx3.clearRect(0,0,canvas2.width,canvas2.height);
          ctx3.translate(canvas2.width/2,canvas2.height/2);
          ctx3.rotate(270*Math.PI/180);
          ctx3.drawImage(canvas2,-canvas2.width/2,-canvas2.width/2);
        }
else if (orientation==3) {
          ctx3.clearRect(0,0,canvas2.width,canvas2.height);
          ctx3.translate(canvas2.width/2,canvas2.height/2);
          ctx3.rotate(180*Math.PI/180);
          ctx3.drawImage(canvas2,-canvas2.width/2,-canvas2.width/2);
        }
else    {
          ctx3.clearRect(0,0,canvas2.width,canvas2.height);
          ctx3.drawImage(canvas2,0,0);

        }

// on affiche le canevas final
    canvas3.classList.remove("invisible");

    return canvas3.toDataURL('image/png');
  }

  else if ((type=='videosnap') && ( video.readyState === 4 )){



    var canvas_streaming= document.getElementById('video_streaming'),
        canvas1 = document.getElementById('hidden_snap_canvas'),
        ctx1 = canvas1.getContext('2d'),
        canvas2 = document.getElementById('snap_final'),
        ctx2 = canvas2.getContext('2d');
        canvas2.width=300;
        canvas2.height=300;

        var vw = video.videoWidth,
            vh = video.videoHeight;
        canvas1.width = vw;
        canvas1.height = vh;

        ctx1.drawImage(video, 0, 0, vw, vh, 0, 0, vw, vh);

        var dimension = Math.min(vw, vh);
        var sx = (vw - dimension)/2;
        var sy= (vh - dimension)/2;

    //Dessine l'image video dans notre Canvas
      canvas_streaming.classList.add("invisible");
      canvas2.classList.remove("invisible");
    ctx2.drawImage(canvas1, sx, sy, dimension, dimension, 0, 0, 300, 300);
    return canvas2.toDataURL('image/png');
  }

  //retourne une image URI (possible de jouer avec la qualité du jpeg avec .toDataURL)

}



function DrawVideoOnCanvas(){

  if ( video.readyState === 4 ) {
    var canvas1 = document.getElementById('hidden_streaming_canvas'),
        ctx1 = canvas1.getContext('2d'),
        canvas2 = document.getElementById('video_streaming'),
        ctx2 = canvas2.getContext('2d');

    var vw = video.videoWidth,
        vh = video.videoHeight;

    var div_width;
    canvas1.width= vw;
    canvas1.height= vh;

    ctx1.drawImage(video, 0, 0, vw, vh, 0, 0, vw, vh);

    canvas2.style.width ='100%';
    canvas2.style.height='';

    if (canvas2.offsetWidth > 400)
    {div_width = 400;
    canvas2.style.width ='400'}
    else
    { div_width = canvas2.offsetWidth;}




    // ...then set the internal size to match
    canvas2.width  = div_width;
    canvas2.height = div_width;

    var dimension = Math.min(vw, vh);

    var sx = (vw - dimension)/2;

    var sy= (vh - dimension)/2;




      ctx2.drawImage(canvas1, sx, sy, dimension, dimension, 0, 0, div_width, div_width);
      };
    //context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight, 0, 0, Math.floor(200*ratio), 200);
    setTimeout(DrawVideoOnCanvas,20);
}

download_img = function(el) {

  var canvas_final = document.getElementById('snap_final');
  var image = canvas_final.toDataURL("image/jpeg", 0.9);
  el.href = image;
};


video.addEventListener('play', function(){
        DrawVideoOnCanvas('videostream');
    },false);
