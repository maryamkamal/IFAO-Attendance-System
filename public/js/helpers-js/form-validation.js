// Wait for the DOM to be ready
$(function() {
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("#form-validation").validate({
    // Specify validation rules
    rules: {
      ar-phone: "required",

      ar-username: {
          required: true,
          minlength: 3
      }
      ar-email: {
        required: true,
        // Specify that email should be validated
        // by the built-in "email" rule
        email: true
      },
      ar-message: {
        required: true,
        minlength: 5,
        maxlength: 10000
      }
    },
    // Specify validation error messages
    messages: {
      ar-username: "Please enter your name",
      ar-email: "Please enter your email",
      ar-phone: "Please enter your phone",
      ar-message: {
        required: "Please provide a message",
      }
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
  });
});
