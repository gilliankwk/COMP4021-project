$(document).ready(function() {

  var contactForm = $("#contactForm");

  //We set our own custom submit function

  contactForm.on("submit", function(e) {

    //Prevent the default behavior of a form

    e.preventDefault();

    //Get the values from the form

    var name = $("#name").val();

    var email = $("#email").val();

    var message = $("#message").val();

    //Our AJAX POST
      var query=$("#contactForm").serialize();
    $.post("mail.php",query,function(data) {
        $("#response").text(data.status);
        console.log("OUR FORM SUBMITTED CORRECTLY");


    })

  });

});
