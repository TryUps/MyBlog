"use strict";

var inputs = document.querySelectorAll('input[type=text], input[type=password]');
var _iteratorNormalCompletion = true;
var _didIteratorError = false;
var _iteratorError = undefined;

try {
  for (var _iterator = inputs[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
    var input = _step.value;
    input.addEventListener('keyup', function (e) {
      var valid = e.target.checkValidity();
      var icon = e.target.parentElement.querySelector('i');

      if (valid) {
        icon.classList.add('colored');
      } else {
        icon.classList.remove('colored');
      }
    });
  }
} catch (err) {
  _didIteratorError = true;
  _iteratorError = err;
} finally {
  try {
    if (!_iteratorNormalCompletion && _iterator["return"] != null) {
      _iterator["return"]();
    }
  } finally {
    if (_didIteratorError) {
      throw _iteratorError;
    }
  }
}

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
      }, 2000);
    }
  });
};

var loginform = document.querySelector("#myb__login_form");
loginform.addEventListener("submit", submitForm);