// Fonctions communes à tous les formulaires (add_form.php, edit_form.php, sell_form.php)


//pour mettre à jour la valeur d'un champ sur la page
function set_value(id_to_update, value)
{
  document.getElementById(id_to_update).value= value;
}

function set_active(selector, element_to_activate)
{
  console.log(element_to_activate);
  element_to_activate.classList.add("active");
  document.querySelectorAll(selector).forEach(function(node)
  {node.classList.remove("active");});
}



//fonction qui enlève la classe "hidden" d'un élément du DOM
function unhide(id_to_show)
{var elem_to_show= document.getElementById(id_to_show);

elem_to_show.classList.remove("hidden");}

//fonction expand affiche le div #id_to_show, cache le div #id_to_hide et applique une animation d'entrée
// en fonction de la variable direction (slide down, slide right, ou fade in (par défaut))
function expand(id_to_show, id_to_hide, direction)
{
  var elem_to_show= document.getElementById(id_to_show);

  elem_to_show.classList.remove("invisible");

if (direction=='down')
{ elem_to_show.classList.add("visible-slide-down");}
else if (direction=='right')
{ elem_to_show.classList.add("visible-slide-right");}
else
{ elem_to_show.classList.add("visible");}

if (id_to_hide !== null && id_to_hide !== '')
{
  var elem_to_hide = document.getElementById(id_to_hide);
  elem_to_hide.classList.add("invisible");
}
  return false;
}

//cache l'élément dont l'id est fourni
function hide(id_to_hide)
{if (id_to_hide !== null && id_to_hide !== '')
{
  var elem_to_hide = document.getElementById(id_to_hide);
  elem_to_hide.classList.add("invisible");
}}

//fonction pour vérifier si il faut faire apparaitre ou disparaitre un div en fonction de si la case est cochée
function check_expand_hide(elem, id_to_show, id_to_hide, direction)
{
  if (elem.checked== true)
  {expand(id_to_show, '', direction)}
  else if (elem.checked==false)
  {hide(id_to_hide)}
}

function checkhearts(value)
{

  if (value >= 1)
  {document.getElementById('heart1').classList.add("checked");}
  else
  {document.getElementById('heart1').classList.remove("checked");}

  if (value >= 2)
  {document.getElementById('heart2').classList.add("checked");}
  else
  {document.getElementById('heart2').classList.remove("checked");}

  if (value >= 3)
  {document.getElementById('heart3').classList.add("checked");}
  else
  {document.getElementById('heart3').classList.remove("checked");}

  if (value >= 4)
  {document.getElementById('heart4').classList.add("checked");}
  else
  {document.getElementById('heart4').classList.remove("checked");}

}

// fonction pour inc/décrementer la valeur d'un élément (utilisé pour "pieces")
  function Increment(id, increment, min){

    var value= parseInt(document.getElementById(id).value);

    if ( (value+increment) <= min )
    {document.getElementById(id).value= min;}

    else
    {
    document.getElementById(id).value= value + increment;
    }
  }

  function ValidateNonEmpty(id, min)
  {

    var value = document.getElementById(id).value;

    if (value=='')
  {document.getElementById(id).value = min;}
  else
  {
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

  function ValidateNumber(textbox)
  {
    n = textbox.value;
    console.log(n);

    if (isNaN(parseFloat(n.replace(",",".")))) //on contrôle si n est un nombre (en remplaçant la ',' par un '.' sinon isNaN=true)
    {
  M.toast({html: "Nombre invalide"});
  textbox.value= textbox.oldvalue;
    }

    else {
      {textbox.value=n;} // si n est un nombre, on met à jour l'input range "mesure"
    }

  }

function updateTextInput(id, val){
  document.getElementById(id).value=val; // on met à jour l'input text lié à l'input range "mesure"
}
