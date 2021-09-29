"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.PersonController = void 0;
const Controller_1 = require("./Controller");
class PersonController extends Controller_1.Controller {
  constructor() {
    super();
    this.index = () => {
      console.log(this.timestamp());
    };
    this.biodata = (name, age) => {
      this.name = name;
      this.age = age;
      return `Hello my name is ${this.name} and i'm ${this.age} years old`;
    };
    this.name = "";
    this.age = 0;
  }
}
exports.PersonController = PersonController;
