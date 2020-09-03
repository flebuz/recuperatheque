
window.addEventListener('DOMContentLoaded', (event) => {
      var tagInput1 = new TagsInput({
        selector: 'input-tags',
      });
      var source_tags = document.getElementById("source-tags").value;
      var tags = source_tags.split(',');
      if (tags[0] !== '')
      {
            tags.forEach((tag, index) =>
            {
            tagInput1.addTag(tags[index]);
          });
      }
});




function UpdateSnapshot(e) {

  console.log("UpdateSnapshot");
  //on cache le svg avec les bords discontinus
  var snap_original = document.getElementById("snap");
  snap_original.classList.add("invisible");
  var spinner_imagesnap = document.getElementById("spinner_imagesnap");
  spinner_imagesnap.classList.remove("invisible");
  var canvas_final = document.getElementById('snap_final');
  canvas_final.classList.add("invisible");


document.getElementById('image_final').reset;

  var img = new Image;
  img.src = URL.createObjectURL(e.target.files[0]);



 img.onload = function()
  {

    //console.log("img.onload");
    getOrientation(e.target.files[0], function(orientation)
      {

        document.getElementById('image_final').value = DessineVignette('imagesnap', img, orientation);
      });

    canvas_final.classList.remove("invisible");
    spinner_imagesnap.classList.add("invisible");

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
  var size = 1000;

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



}
