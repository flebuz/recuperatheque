function init_getusermedia()
{
  // solution "polyfill" issue de https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia

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

    navigator.mediaDevices.getUserMedia({video: { facingMode: { exact: "environment"} }, audio: false })
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





function hasGetUserMedia() {
      return !!(navigator.mediaDevices &&
        navigator.mediaDevices.getUserMedia);
    }

function PrisePhoto(e)
    {
     e.preventDefault();
     var vignette = DessineVignette();

     // Pause video playback of stream. (ne fonctionne pas?)
     navigator.mediaDevices.getUserMedia.stop();
    }

function handleFiles(e) {
      var hidden_canvas = document.querySelector('canvas'),
          context = hidden_canvas.getContext('2d');
        var img = new Image;
        img.src = URL.createObjectURL(e.target.files[0]);
        img.onload = function() {
          var vignette = DessineVignette(img);
            //context.drawImage(img, 0,0);
        }
    }

function DessineVignette(image)
{
  var hidden_canvas = document.querySelector('canvas'),
      context = hidden_canvas.getContext('2d');
      hidden_canvas.width = 125;
      hidden_canvas.height = 125;

      if (image) //si l'image uploadée est passée en argument
      {
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
        context.drawImage(image, 0, 0, image.width, image.height, 0, 0, 125, 125);
        //Dessine le fichier uploadé dans notre Canvas
      }
      else
      {
      context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight, 0, 0, 125, 125);
      //Dessine l'image video dans notre Canvas

      }
  return hidden_canvas.toDataURL('image/png');
  //retourne une image URI (possible de jouer avec la qualité du jpeg avec .toDataURL)
}
