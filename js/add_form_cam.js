

var take_photo_btn = document.querySelector('#take-photo');
var input_btn = document.getElementById('file');
var controls_div =  document.getElementById('controls');

if (hasGetUserMedia()) {
  //M.toast({html: "Tip top"});
  init_getusermedia();

}

else {
  //M.toast({html: "getUserMedia() n'est pas supporté par votre navigateur :("});
  take_photo_btn.classList.add("invisible"); //on cache le bouton prise de vue (puisqu'inutile sans getusermedia)

}

take_photo_btn.addEventListener("click", PrisePhoto); //on active le bouton prise de vue
input_btn.addEventListener('change', handleFiles); //on active le bouton d'upload de photo
