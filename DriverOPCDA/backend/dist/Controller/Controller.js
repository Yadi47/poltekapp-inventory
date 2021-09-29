"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.Controller = void 0;
const ReponseModifier_1 = __importDefault(require("../helper/ReponseModifier"));
const Const_1 = require("../Config/Const");
class Controller {
    constructor() {
        this.GET_ALL_SUCCESS = Const_1.RESPONSE_MESSAGE.GET_ALL_SUCCESS;
        this.GET_ALL_FAILED = Const_1.RESPONSE_MESSAGE.GET_ALL_FAILED;
        this.INSERT_SUCCESS = Const_1.RESPONSE_MESSAGE.INSERT_SUCCESS;
        this.INSERT_FAILED = Const_1.RESPONSE_MESSAGE.INSERT_FAILED;
        this.UPDATE_SUCCESS = Const_1.RESPONSE_MESSAGE.UPDATE_SUCCESS;
        this.UPDATE_FAILED = Const_1.RESPONSE_MESSAGE.UPDATE_FAILED;
        this.DELETE_SUCCESS = Const_1.RESPONSE_MESSAGE.DELETE_SUCCESS;
        this.DELETE_FAILED = Const_1.RESPONSE_MESSAGE.DELETE_FAILED;
        this.LOGIN_SUCCESS = Const_1.RESPONSE_MESSAGE.LOGIN_SUCCESS;
        this.LOGIN_FAILED = Const_1.RESPONSE_MESSAGE.LOGIN_FAILED;
    }
    timestamp() {
        return "2020";
    }
    response(successStatus, code, messageResponse, data) {
        /*
        {
          success : true,
          code : 200,
          message : "Message success !",
          data : [],
        };
    
        */
        return ReponseModifier_1.default(successStatus, code, messageResponse, data);
    }
    message() { }
}
exports.Controller = Controller;
