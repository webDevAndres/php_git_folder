(function() {
    'use strict';
    window.addEventListener('load', function() {
      var form = document.getElementById('needs-validation');
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
          // if the values are empty these errors will show
          $("#nameError").html("Please enter your name");
          $("#emailError").html("invalid email");
          $("#addressError").html("Please enter an address");
          $("#cityError").html("Please choose a city");
        }
        form.classList.add('was-validated');
      }, false);
    }, false);
  })();