// Fonctions communes à tous les formulaires (add_form.php, edit_form.php, sell_form.php)




function expand(id_to_show, id_to_hide)
{
  var elem_to_show= document.getElementById(id_to_show);

  elem_to_show.classList.remove("invisible");
  elem_to_show.classList.add("visible");


  var elem_to_hide = document.getElementById(id_to_hide);
  elem_to_hide.classList.add("invisible");
  return false;
}


// Script pour inc/décrementer la valeur d'un élément (utilisé pour "pieces")

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
