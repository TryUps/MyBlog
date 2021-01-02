"use strict";

var submitForm = function submitForm(e) {
  e.preventDefault();
  var data = new FormData(e.target);

  var login = function login(data) {
    return fetch('./signin', {
      method: 'POST',
      body: data
    }).then(function (res) {
      return res.json();
    })["catch"](function (error) {
      return console.error(error);
    });
  };

  login(data).then(function (login) {
    console.log(login);

    if (login) {
      setTimeout(function () {
        return window.location.href = './dash/';
      }, 300);
    }
  });
};

var loginform = document.querySelector("#myb__login_form");
loginform.addEventListener("submit", submitForm);