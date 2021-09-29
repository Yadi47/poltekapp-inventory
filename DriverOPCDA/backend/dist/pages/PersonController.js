"use strict";
var __extends =
  (this && this.__extends) ||
  (function () {
    var extendStatics = function (d, b) {
      extendStatics =
        Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array &&
          function (d, b) {
            d.__proto__ = b;
          }) ||
        function (d, b) {
          for (var p in b)
            if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p];
        };
      return extendStatics(d, b);
    };
    return function (d, b) {
      if (typeof b !== "function" && b !== null)
        throw new TypeError(
          "Class extends value " + String(b) + " is not a constructor or null"
        );
      extendStatics(d, b);
      function __() {
        this.constructor = d;
      }
      d.prototype =
        b === null
          ? Object.create(b)
          : ((__.prototype = b.prototype), new __());
    };
  })();
Object.defineProperty(exports, "__esModule", { value: true });
exports.PersonController = void 0;
var Controller_1 = require("./Controller");
var PersonController = /** @class */ (function (_super) {
  __extends(PersonController, _super);
  function PersonController() {
    var _this = _super.call(this) || this;
    _this.index = function () {
      console.log(_this.timestamp());
    };
    _this.biodata = function (name, age) {
      _this.name = name;
      _this.age = age;
      return (
        "Hello my name is " +
        _this.name +
        " and i'm " +
        _this.age +
        " years old"
      );
    };
    _this.name = "";
    _this.age = 0;
    return _this;
  }
  return PersonController;
})(Controller_1.Controller);
exports.PersonController = PersonController;
