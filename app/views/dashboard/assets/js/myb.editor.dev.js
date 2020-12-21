"use strict";

(function () {
  var editors = document.querySelectorAll('myb-editor');
  var _iteratorNormalCompletion = true;
  var _didIteratorError = false;
  var _iteratorError = undefined;

  try {
    var _loop = function _loop() {
      var editor = _step.value;
      var ifrEdit = editor.querySelector('iframe.editor-text');
      var ifrDoc = ifrEdit.document;
      if (ifrEdit.contentWindow) ifrDoc = ifrEdit.contentWindow.document;
      var style = document.createElement('style');
      style.textContent = "\n      body {\n        overflow-y: auto;\n        font-size: 16px;\n        font-family: 'Arial', Times New Roman, Times, serif, sans-serif;\n        line-height: 1.4;\n        -webkit-nbsp-mode: space;\n        line-break: after-white-space;\n        -webkit-user-modify: read-write;\n        overflow-wrap: break-word;\n        word-wrap: break-word;\n        max-width: 100vw;\n        min-height: calc(100vh - 60px);\n        caret-color: blue;\n      }\n      body[placeholder]:empty::before {\n        content: attr(placeholder);\n        color: gray;\n        font-style:italic;\n      }\n      body::after {\n        display: block;\n        content: '';\n        height: 60px;\n      }\n    ";
      ifrDoc.head.appendChild(style);
      var ifrBody = ifrDoc.body;
      ifrBody.contentEditable = true;
      ifrBody.setAttribute('placeholder', 'Olá mundo');
      var textEdit = editor.querySelector('.myb-htmleditor > textarea');
      ifrBody.addEventListener('keypress', function (e) {
        textEdit.value = e.target.innerHTML;
      });
      var editorButtons = editor.querySelectorAll('editor-tab > button');
      var _iteratorNormalCompletion2 = true;
      var _didIteratorError2 = false;
      var _iteratorError2 = undefined;

      try {
        for (var _iterator2 = editorButtons[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
          var edBtn = _step2.value;
          edBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e = e.target;
            var action = e.dataset.action;
            var value = e.dataset.value;
            formatText(action, value);
          });
        }
      } catch (err) {
        _didIteratorError2 = true;
        _iteratorError2 = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion2 && _iterator2["return"] != null) {
            _iterator2["return"]();
          }
        } finally {
          if (_didIteratorError2) {
            throw _iteratorError2;
          }
        }
      }

      var formatText = function formatText(cmd) {
        var value = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
        ifrDoc.execCommand(cmd, false, value);
        ifrDoc.body.focus();
      };
    };

    for (var _iterator = editors[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
      _loop();
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

  var permalink = document.querySelector('.article_url > #url');
  var the_title = document.querySelector('#post_title');
  the_title.addEventListener('keyup', function (e) {
    var title = e.target.value;
    var the_perma = permalink.querySelector('span');
    the_perma.innerText = title;
  });
})();