"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const response = (success, code, message, data) => {
    let resp;
    resp = {
        success,
        code,
        message,
        data,
    };
    return resp;
};
exports.default = response;
