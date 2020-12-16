"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _wrapNativeSuper(Class) { var _cache = typeof Map === "function" ? new Map() : undefined; _wrapNativeSuper = function _wrapNativeSuper(Class) { if (Class === null || !_isNativeFunction(Class)) return Class; if (typeof Class !== "function") { throw new TypeError("Super expression must either be null or a function"); } if (typeof _cache !== "undefined") { if (_cache.has(Class)) return _cache.get(Class); _cache.set(Class, Wrapper); } function Wrapper() { return _construct(Class, arguments, _getPrototypeOf(this).constructor); } Wrapper.prototype = Object.create(Class.prototype, { constructor: { value: Wrapper, enumerable: false, writable: true, configurable: true } }); return _setPrototypeOf(Wrapper, Class); }; return _wrapNativeSuper(Class); }

function isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

function _construct(Parent, args, Class) { if (isNativeReflectConstruct()) { _construct = Reflect.construct; } else { _construct = function _construct(Parent, args, Class) { var a = [null]; a.push.apply(a, args); var Constructor = Function.bind.apply(Parent, a); var instance = new Constructor(); if (Class) _setPrototypeOf(instance, Class.prototype); return instance; }; } return _construct.apply(null, arguments); }

function _isNativeFunction(fn) { return Function.toString.call(fn).indexOf("[native code]") !== -1; }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

var Selector =
/*#__PURE__*/
function (_HTMLElement) {
  _inherits(Selector, _HTMLElement);

  function Selector() {
    var _this;

    _classCallCheck(this, Selector);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(Selector).call(this));

    var el = _assertThisInitialized(_this);

    var shadow = _this.attachShadow({
      mode: 'closed'
    });

    var defaultOption = document.createElement('span');
    defaultOption.className = 'default';
    var content = _this.innerHTML;
    defaultOption.textContent = _this.querySelector('item[default], item:first-child').textContent;
    var option = document.createElement('div');
    el.setAttribute('value', _this.querySelector('item[default], item:first-child').getAttribute('value'));
    option.className = 'option-list';
    option.innerHTML = content;
    _this.innerHTML = null;
    var style = document.createElement('style');
    style.textContent = "\n      :host {\n        display: flex;\n        font-family: 'Helvetica', Arial, sans-serif;\n        position: relative;\n        flex-direction: column;\n        align-items: center;\n        justify-content: center;\n        background: #fff;\n        border-radius: 25px;\n        border: 1px solid #ccc;\n        padding: 6px 10px;\n        min-width: 150px;\n        width: 220px;\n        height: 30px;\n        cursor: pointer;\n        transition: border .5s;\n      }\n      :host(:hover), :host(:focus-within) {\n        border-color:#0A0C45;\n      }\n      \n      * {\n        box-sizing: border-box;\n        user-select: none;\n        -webkit-user-select: none;\n        cursor: pointer;\n      }\n\n      .default {\n        text-align: center;\n      }\n\n      .option-list {\n        position: absolute;\n        display: flex;\n        width: calc(100% - 0px);\n        visibility: hidden;\n        flex-direction: column;\n        background: rgba(255,255,255,0.5);\n        min-height: 30px;\n        max-height: 160px;\n        border-radius: 6px;\n        z-index: 10;\n        border-top: 1px solid rgba(255,255,255, 0.2);\n        border-left: 1px solid rgba(255,255,255, 0.2);\n        backdrop-filter: blur(15px);\n        -webkit-backdrop-filter: blur(15px);\n        box-shadow: 5px 5px 30px rgba(0,0,0,0.2);\n        overflow-y: auto;\n      }\n\n      .option-list.show {\n        visibility: visible !important;\n      }\n\n\n      .option-list > item {\n        display: flex;\n        align-items: flex-start;\n        padding: 10px 10px;\n\n        border-bottom: 1px solid rgba(255,255,255, 0.3);\n      }\n      \n      .option-list > item:hover {\n        background-color: rgba(0,0,0,0.1);\n      }\n\n      .option-list > item[disabled] {\n        opacity: 0.5;\n        cursor: default;\n      }\n    ";
    shadow.appendChild(style);
    shadow.appendChild(defaultOption);
    shadow.appendChild(option);
    var optionlist = shadow.querySelector('.option-list');

    if (_this.getAttribute('mode') === 'top') {
      optionlist.style.bottom = '43px';
    } else {
      optionlist.style.top = '33px';
    }

    _this.addEventListener('click', function (e) {
      optionlist.classList.toggle('show');
    });

    var itemList = optionlist.querySelectorAll('item:not([disabled])');
    var _iteratorNormalCompletion = true;
    var _didIteratorError = false;
    var _iteratorError = undefined;

    try {
      for (var _iterator = itemList[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
        var item = _step.value;
        item.addEventListener('click', function (e) {
          el.setAttribute('value', this.getAttribute('value'));
          shadow.querySelector('span.default').textContent = this.textContent;
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

    return _this;
  }

  return Selector;
}(_wrapNativeSuper(HTMLElement));

customElements.define('custom-selector', Selector);