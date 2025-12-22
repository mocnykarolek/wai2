


$(document).ready(function () {
  $("#form_section").validate({
    rules: {
      name: {
        required: true,
        minlength: 2,
      },
      email: {
        required: true,
        email: true,
      },
      message: {
        required: true,
        minlength: 10,
      },
      phone: {
        required: false,
        minlength: 9,
      }
    },
    messages: {
      name: {
        required: "Podaj swoje imię.",
        minlength: "Imię musi mieć co najmniej 2 znaki.",
      },
      email: {
        required: "Podaj email.",
        email: "Wpisz poprawny adres email.",
      },
      message: {
        required: "Napisz wiadomość.",
        minlength: "Wiadomość musi mieć minimum 10 znaków.",
      },
      phone: {
        minlength: "Numer ma conajmniej 9 cyfr.",
      }
    },
  });
});
