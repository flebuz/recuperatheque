// Fonctions communes à tous les formulaires (add_form.php, edit_form.php, sell_form.php)


//pour mettre à jour la valeur d'un champ sur la page
function set_value(id_to_update, value) {
  document.getElementById(id_to_update).value = value;
}
//pour mettre à jour la valeur d'un champ sur la page
function compute_price(id_price, id_price_per_kg, id_weight, id_etat) {
  var weight = document.getElementById(id_weight).value;
  var price_per_kg = document.getElementById(id_price_per_kg).value;
  var etat = document.getElementById(id_etat).value;
  if (weight && price_per_kg && etat)
  {
      var coefficient_etat = 0.2 + (etat * 0.2);
      console.log("price_per_kg : "+ price_per_kg +"; weight : "+ weight+"; etat : "+etat+ "; coefficient_etat : " + coefficient_etat)
      var final_price = price_per_kg * weight * coefficient_etat;

      /*final_price= Math.round(final_price * 10) / 10; */
      final_price= final_price.toFixed(2);
      if ((final_price < 0.01) && (price_per_kg > 0))
      {
        final_price =0.01; // minimum price if price_per_kg is not null
      }
      document.getElementById(id_price).value = final_price;}
}

function check_default_unit(default_unit, id_to_update) {
  console.log(default_unit);
  console.log(id_to_update);
  if (default_unit == 'kg') {
    document.getElementById(id_to_update).classList.remove("invisible");
    document.getElementById('has_weight').value = 1;
  } else if (default_unit == 'pc') {
    document.getElementById(id_to_update).classList.add("invisible");
    document.getElementById('has_weight').value = 0;
  }
}

function set_range_value(id_to_update, value) {
  if (value > 1) {
    value = (value - 1) * 10 + 1;
    value = Math.round(value * 10) / 10;
  }
  document.getElementById(id_to_update).value = value;
}

function update_slider(slider_id, value, elem) {
  document.getElementById(slider_id).noUiSlider.set(value);
  elem.value = value; // to avoid values bigger than slider range being overriden by noUiSlider.set
}

function update_weight_and_price(final_weight_id, item_weight, nb_unit, final_price_id, item_price) {
  if ((item_weight !== 'N/A') && (item_weight !== '')) {


    var final_weight = nb_unit * item_weight;
    document.getElementById(final_weight_id).value = final_weight;

    var final_price = (nb_unit * item_price).toFixed(2);

    document.getElementById(final_price_id).value = final_price;
    console.log("nb pieces = " + nb_unit + "; prix/pc = " + item_price + "; poids/pc = " + item_weight + "; prix total = " + final_price);

  } else {

  }
}



function set_active(selector, id_to_activate) {
  document.getElementById(id_to_activate).classList.add("active");
  if ((selector !== undefined) && (selector !== '')) {

    var tabs = document.querySelectorAll(selector);
    for (i = 0; i < tabs.length; ++i) {
      tabs[i].classList.remove("active");
    } //better backwards compatibility than array.forEach (ES6 and later)

  }
}

function set_inactive(id_to_deactivate) {
  document.getElementById(id_to_deactivate).classList.remove("active");
}


function ValidateForm(mandatory_fields, fields_visible_name)
{
  var error_msg ='';

  for (i=0; i<mandatory_fields.length; i++) {
    var field = document.querySelector("#"+mandatory_fields[i]).value;
      if (field == '' || field == null)
      {
        error_msg= error_msg.concat("Veuillez entrer "+ fields_visible_name[i] +"<br />");
      }
    }

    return error_msg;
}

function Soumettre(formid) {

  document.forms[formid].submit();
  //document.getElementById(formid).reset();
}



//fonction qui enlève la classe "hidden" d'un élément du DOM
function unhide(id_to_show) {
  var elem_to_show = document.getElementById(id_to_show);

  elem_to_show.classList.remove("hidden");
}

//fonction expand affiche le div #id_to_show, cache le div #id_to_hide et applique une animation d'entrée
// en fonction de la variable direction (slide down, slide right, ou fade in (par défaut))
function expand(id_to_show, id_to_hide, direction) {
  //console.log(id_to_show);
  var elem_to_show = document.getElementById(id_to_show);
  //console.log(elem_to_show);
  elem_to_show.classList.remove("invisible");

  if (direction == 'down') {
    elem_to_show.classList.add("visible-slide-down");
  } else if (direction == 'right') {
    elem_to_show.classList.add("visible-slide-right");
  } else {
    elem_to_show.classList.add("visible");
  }

  if ((id_to_hide !== undefined) && (id_to_hide !== '')) {
    var elem_to_hide = document.getElementById(id_to_hide);
    elem_to_hide.classList.add("invisible");
  }
  return false;
}

//cache l'élément dont l'id est fourni
function hide(id_to_hide) {
  if (id_to_hide !== null && id_to_hide !== '') {
    var elem_to_hide = document.getElementById(id_to_hide);
    elem_to_hide.classList.add("invisible");
  }
}

//fonction pour vérifier si il faut faire apparaitre ou disparaitre un div en fonction de si la case est cochée
function check_expand_hide(elem, id_to_show, id_to_hide, direction) {
  if (elem.checked == true) {
    expand(id_to_show, '', direction)
  } else if (elem.checked == false) {
    hide(id_to_hide)
  }
}

function checkhearts(value) {

  if (value >= 1) {
    document.getElementById('heart1').classList.add("checked");
  } else {
    document.getElementById('heart1').classList.remove("checked");
  }

  if (value >= 2) {
    document.getElementById('heart2').classList.add("checked");
  } else {
    document.getElementById('heart2').classList.remove("checked");
  }

  if (value >= 3) {
    document.getElementById('heart3').classList.add("checked");
  } else {
    document.getElementById('heart3').classList.remove("checked");
  }

  if (value >= 4) {
    document.getElementById('heart4').classList.add("checked");
  } else {
    document.getElementById('heart4').classList.remove("checked");
  }

}

// fonction pour inc/décrementer la valeur d'un élément (utilisé pour "pieces")
function Increment(id, increment, min, max) {

  var value = parseInt(document.getElementById(id).value);

  if ((value + increment) <= min) {
    document.getElementById(id).value = min;
  } else if ((value + increment) >= max) {
    document.getElementById(id).value = max;
  } else {
    document.getElementById(id).value = value + increment;
  }
}

function ValidateNonEmpty(id, min) {

  var value = document.getElementById(id).value;

  if (value == '') {
    document.getElementById(id).value = min;
  } else {
    document.getElementById(id).value = parseInt(value);
  }

}

function ValidateValue(id, min, max) {

  var value = document.getElementById(id).value;

  if (value == '') {
    document.getElementById(id).value = min;
  } else if (value >= max) {
    document.getElementById(id).value = max;
  } else {
    document.getElementById(id).value = parseInt(value);
  }

}


function ValidateNumKeyPress(event) {
  var regex = new RegExp(/^-?\d*[.,]?\d*$/);
  var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
}

function ValidateNumber(textbox) {
  n = textbox.value;


  if (isNaN(parseFloat(n.replace(",", ".")))) //on contrôle si n est un nombre (en remplaçant la ',' par un '.' sinon isNaN=true)
  {
    M.toast({
      html: "Nombre invalide"
    });
    textbox.value = textbox.oldvalue;
  } else {
    {
      textbox.value = n;
    } // si n est un nombre, on met à jour l'input range "mesure"
  }

}
