 $( document ).ready(function() {
    $('body').addClass('loaded');

        
// ############ TECLADO NUMERICO
var keys = document.querySelectorAll('#teclado_numerico span');

// Add onclick event to all the keys and perform operations
for (var i = 0; i < keys.length; i++) {
  keys[i].onclick = function (e) {
    // Get the input and button values     
    var inputVal = input.innerHTML;
    var btnVal = this.innerHTML;
    // Now, just append the key values (btnValue) to the input string and finally use javascript's eval function to get the result
    // If clear key is pressed, erase everything
    if (btnVal == 'C') {
      //input.innerHTML = '';
      input.val("");
      decimalAdded = false;
    }
    // if any other key is pressed, just append it
    else {
      if (!$(this).hasClass('erase')) {
        input.val(input.val() + $(this).html());
      }
    }
    // prevent page jumps
    e.preventDefault();
  }
}
$('.erase').on('click', function () {
  var cadena;
  cadena = input.val();
  if (cadena !== "") {
    cadena = cadena.substring(0, cadena.length - 1);
    input.val(cadena);
  }
  return false;
});
}); //termina document readey
// ############ TERMINA TECLADO NUMERICO

$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').focus();
});