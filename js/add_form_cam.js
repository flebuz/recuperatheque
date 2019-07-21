//"use strict";

var take_photo_btn = document.querySelector('#take-photo');
var upload_file_default_btn = document.querySelector('#upload-file-default');
var file_upload = document.getElementById('file');
//var play_btn = document.getElementById('play');
//var stop_btn = document.getElementById('stop');
var is_camera_active = false;

var controls_div =  document.getElementById('controls'); // ? Obsolète je pense ?

if (hasGetUserMedia()) {
  //M.toast({html: "Tip top"});
  init_getusermedia_simple();

}


else {
  M.toast({html: "GetUserMedia pas supporté :()"});
  console.log("getUserMedia() n'est pas supporté par votre navigateur :(");
  take_photo_btn.classList.add("invisible"); //on cache le bouton prise de vue (puisqu'inutile sans getusermedia)
  var video = document.querySelector('video');
  video.classList.add("invisible");
  var upload_file_default = document.getElementById("upload-file-default");
  upload_file_default.classList.add("pulse");

}


take_photo_btn.addEventListener("click", PrisePhoto); //on active le bouton prise de vue
file_upload.addEventListener('change', UploadFichier); //on active le bouton d'upload de photo
//play_btn.addEventListener("click", PlayVideo); //on active le bouton prise de vue
//stop_btn.addEventListener("click", StopVideo); //on active le bouton prise de vue

var video = document.querySelector("#video");




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
          var upload_file_default = document.getElementById("upload-file-default");
          upload_file_default.classList.add("invisible");
          take_photo_btn.classList.remove("invisible");
          take_photo_btn.classList.add("pulse");
          take_photo_btn.classList.remove("grey");
          take_photo_btn.classList.add("red");
          //M.toast({html: "Camera Tip top"});
        };
      })
      .catch(function(err) { M.toast({html: err.name + ": " + err.message});
        console.log(err.name + ": " + err.message);
        take_photo_btn.classList.add("invisible");
        video.classList.add("invisible");
        var upload_file_default = document.getElementById("upload-file-default");
        upload_file_default.classList.add("pulse");
      });
       // always check for errors at the end.
      //M.toast({html: "Utilisez une connexion sécurisée (https)"});

}

//méthode tarabiscotée pour lancer getusermedia pour améliorer la compatibilité (temporaire pour les tests)
function init_getusermedia(){

M.toast({html: "init getusermedia"});

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
  {StopVideo();}
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

     var vignette = DessineVignette();

      SwitchCameraActiveState();
      take_photo_btn.classList.remove("pulse");
      take_photo_btn.classList.remove("red");
      take_photo_btn.classList.add("grey");
}

function UploadFichier(e) {

  if(is_camera_active) {StopVideo();}
  var hidden_canvas = document.querySelector('canvas'),
      context = hidden_canvas.getContext('2d');
  var img = new Image;
  img.src = URL.createObjectURL(e.target.files[0]);
  img.onload = function() {
    var vignette = DessineVignette(img);
    //context.drawImage(img, 0,0);

    var upload_file_default = document.getElementById("upload-file-default");
    upload_file_default.classList.remove("pulse");
    upload_file_default.classList.remove("red");
    upload_file_default.classList.add("grey");

  }
}

function DessineVignette(image){
  var hidden_canvas = document.querySelector('canvas'),
      context = hidden_canvas.getContext('2d');
  hidden_canvas.width = 125;
  hidden_canvas.height = 125;

  //si l'image uploadée est passée en argument
  if (image) {

    //vérifie et corrige l'orientation de l'image à partir des données EXIF (ne fonctionne pas encore)
    var fileReader = new FileReader();

    fileReader.onloadend = function() {
      var exif = EXIF.readFromBinaryFile(new BinaryFile(image));
      switch(exif.Orientation){
        case 8:
          context.rotate(90*Math.PI/180);
          break;
        case 3:
          context.rotate(180*Math.PI/180);
          break;
        case 6:
          context.rotate(-90*Math.PI/180);
          break;
      }
    };

    //Dessine le fichier uploadé dans notre Canvas
    context.drawImage(image, 0, 0, image.width, image.height, 0, 0, 125, 125);
  }

  else{
    //Dessine l'image video dans notre Canvas
    context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight, 0, 0, 125, 125);
  }

  //retourne une image URI (possible de jouer avec la qualité du jpeg avec .toDataURL)
  return hidden_canvas.toDataURL('image/png');
}
