"use strict";
var __importDefault =
  (this && this.__importDefault) ||
  function (mod) {
    return mod && mod.__esModule ? mod : { default: mod };
  };
Object.defineProperty(exports, "__esModule", { value: true });
exports.Controller = void 0;
var ReponseModifier_1 = __importDefault(require("../helper/ReponseModifier"));
var Controller = /** @class */ (function () {
  function Controller() {}
  Controller.prototype.timestamp = function () {
    return "2020";
  };
  Controller.prototype.response = function (
    successStatus,
    messageResponse,
    data,
    errorCode
  ) {
    return ReponseModifier_1.default(
      successStatus,
      messageResponse,
      data,
      errorCode
    );
  };
  return Controller;
})();
exports.Controller = Controller;
