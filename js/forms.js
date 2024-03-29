// Common functions for all item-related forms (add_form.php, edit_form.php)


function set_value(id_to_update, value)
//simply updates the value of an element on a page :)
{
  document.getElementById(id_to_update).value = value;
}



function compute_price(id_price, id_price_per_kg, id_weight, id_etat)
// Computes the suggested price of an item in relation to 1) the material's base price per kg
// (set in the _global_souscategories MySQL table), // 2) the weight of the item and
// 3) its condition ("etat") (1 to 4 hearts)
{
  var weight = document.getElementById(id_weight).value;
  var price_per_kg = document.getElementById(id_price_per_kg).value;
  var etat = document.getElementById(id_etat).value;
  if (weight && price_per_kg && etat)
  {
      var coefficient_etat = 0.2 + (etat * 0.2);
      //console.log("price_per_kg : "+ price_per_kg +"; weight : "+ weight+"; etat : "+etat+ "; coefficient_etat : " + coefficient_etat);
      var final_price = price_per_kg * weight * coefficient_etat;


      final_price= Math.round(final_price*2)/2; //restrict number to 2 decimal points
      if ((final_price < 0.5) && (price_per_kg > 0))
      {
        final_price =0.5; // minimum price if price_per_kg is not null
      }
      document.getElementById(id_price).value = final_price;}
}

function update_weight_and_price(final_weight_id, item_weight, nb_unit, final_price_id, item_price)
// Used in the "sell_form" modal in item_page.php to update weight and price based on number of units to sell
{
  if ((item_weight !== 'N/A') && (item_weight !== '')) {


    var final_weight = nb_unit * item_weight;
    document.getElementById(final_weight_id).value = final_weight;

    var final_price = (nb_unit * item_price).toFixed(2);

    document.getElementById(final_price_id).value = final_price;
    console.log("nb pieces = " + nb_unit + "; prix/pc = " + item_price + "; poids/pc = " + item_weight + "; prix total = " + final_price);

  } else {

  }
}



function update_slider(slider_id, value, elem)
// Updates the weight slider on user input in the weight text field  "weight_textbox" in add_form.php
{
  document.getElementById(slider_id).noUiSlider.set(value);
  elem.value = value; // to avoid bigger values than slider range being overriden by noUiSlider.set
}


function set_active(selector, id_to_activate)
// Sets an element as active. Used to highlight in green the "prefix" icon to the left of the field
 {
     document.getElementById(id_to_activate).classList.add("active");
  if ((selector !== undefined) && (selector !== '')) {

    var tabs = document.querySelectorAll(selector);
    for (i = 0; i < tabs.length; ++i) {
      tabs[i].classList.remove("active");
    } //better backwards compatibility than array.forEach (ES6 and later)

  }
}

function update_cat(dropdown_id,cat_id,cat_name)
  // Called on each change of categories to update relevant fields
{
  set_active('.dropdown-trigger', dropdown_id);
  document.getElementById(dropdown_id).classList.add('active');
  set_value('nom_categorie',cat_name);
  set_value('id_categorie',cat_id);
  set_value('nom_souscategorie','');
  set_value('id_souscategorie','');
  expand('categorisation','', 'down');
}


function update_subcat(subcat_id,subcat_name, subcat_price, subcat_unit)
  // Called on each change of subcategories to update relevant fields
{
  set_value('nom_souscategorie',subcat_name);
  set_value('id_souscategorie',subcat_id);
  set_value('price_per_kg',subcat_price);
  compute_price('prix','price_per_kg', 'weight_textbox', 'etat');
  check_default_unit(subcat_unit, 'row_poids');
}


function check_default_unit(default_unit, id_to_update) {
  // Called by update_subcat. Hides and shows certain elements
  // depending on whether an item's material is measured by weight ('kg')
  // or is only measured by piece ('pc')
  if (default_unit == 'kg') {
    document.getElementById(id_to_update).classList.remove("invisible");
    document.getElementById('has_weight').value = 1;
  } else if (default_unit == 'pc') {
    document.getElementById(id_to_update).classList.add("invisible");
    document.getElementById('has_weight').value = 0;
  }
}


function set_inactive(id_to_deactivate) {
  document.getElementById(id_to_deactivate).classList.remove("active");
}


function ValidateForm(mandatory_fields, fields_visible_name)
// Checks if all mandatory fields are filled before validating a form
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


function submit_form(formid) {

  document.forms[formid].submit();

}



function unhide(id_to_show)
//removes the "hidden" class of a DOM element
{
  var elem_to_show = document.getElementById(id_to_show);

  elem_to_show.classList.remove("hidden");
}



function expand(id_to_show, id_to_hide, direction)
// This function shows the div #id_to_show, hides the div #id_to_hide, and uses an entry animation
// depending on the desired direction (slide down, slide right, or fade in (by defaut)).
// Used for clickable "Plus de détails" ("More details") div.
{

  var elem_to_show = document.getElementById(id_to_show);

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


function hide(id_to_hide)
// Hides a given element
{
  if (id_to_hide !== null && id_to_hide !== '') {
    var elem_to_hide = document.getElementById(id_to_hide);
    elem_to_hide.classList.add("invisible");
  }
}


function check_expand_hide(current_state, id_to_show, id_to_hide, direction)
// Checks if a div needs to be displayed or hidden depending on its state, stored in the checkbox "current_state"
{
  if (current_state.checked == true) {
    expand(id_to_show, '', direction)
  } else if (current_state.checked == false) {
    hide(id_to_hide)
  }
}


function update_hearts(value)
// updates the item's condition based on user input on the hearts icons (slightly misleading name)
{
  checkhearts(value);
  set_value('etat',value);
  compute_price('prix','price_per_kg', 'weight_textbox', 'etat');
}

function checkhearts(value) {
// checks or unchecks hearts (which displays them as filled or unfilled) based on a given condition (1 to 4) value
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


function Increment(id, increment, min, max)
// function for incrementing/decrementing the value of an element
//(used for "pieces" minus_btn and plus_btn in add_form.php)

{
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
// Checks if value of an element (whose "id" is given) is not empty.
// If the element is empty, sets it to "min" value.
// (Used in add_form.php for "pieces" to make sure a minimal quantity of 1 item is always set)
  var value = document.getElementById(id).value;

  if (value == '') {
    document.getElementById(id).value = min;
  } else {
    document.getElementById(id).value = parseInt(value);
  }

}

function ValidateValue(id, min, max)
// Checks if value of an element (whose "id" is given) is not empty or above a maximum threshold.
// If the element is empty, sets it to "min" value. If it is above the threshold, sets the value with "max"
// (Used in item_page.php)
{
  var value = document.getElementById(id).value;

  if (value == '') {
    document.getElementById(id).value = min;
  } else if (value >= max) {
    document.getElementById(id).value = max;
  } else {
    document.getElementById(id).value = parseInt(value);
  }
}


function ValidateNumKeyPress(event)
// Checks the user key press to constraint input to numbers
{
  var regex = new RegExp(/^-?\d*[.,]?\d*$/);
  var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
}

function ValidateNumber(textbox)
// Checks if value of a textbox is a valid number
// If it's invalid, reverts it to its former value ("oldvalue")
{
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
