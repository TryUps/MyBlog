"use strict";

(function () {
  var MybPages = function MybPages(_ref) {
    var _ref$element = _ref.element,
        element = _ref$element === void 0 ? 'body' : _ref$element,
        _ref$folder = _ref.folder,
        folder = _ref$folder === void 0 ? './pages/' : _ref$folder;
    this.el = document.querySelector(element);
    this.folder = folder;
    var hash = window.location.hash;
    this.hash = hash.split("#!/").pop(); //return this.load();
  };

  MybPages.prototype.load = function () {
    var el = this.el;
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
      if (request.readyState < 4) {
        // handle preload
        return;
      }

      if (request.status !== 200) {
        // handle error
        return;
      }
    };

    request.open('GET', this.folder + this.hash, true);
    request.send('');

    request.onload = function (e) {
      document.querySelector('main').innerHTML = request.responseText;
    };
  };

  MybPages.prototype.go = function () {
    var page = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '#!/';
    var stateObj = {
      id: "100"
    };
    window.history.replaceState(stateObj, "Page 3", "/answer#page3.html");
    window.history.replaceState({}, '#!/hash', page);
  };

  var router = new MybPages({
    element: "#dynamic-container",
    folder: "./"
  });
  window.addEventListener("hashchange", MybPages, false);
  window.onhashchange;
})();