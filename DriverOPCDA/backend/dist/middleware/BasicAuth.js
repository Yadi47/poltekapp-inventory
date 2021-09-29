"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var auth = require("basic-auth");
exports.default = (req, res, next) => {
    const token = "ardhi";
    let basicAuth = req.headers.authorization;
    var user = auth(req);
    console.log(user.name);
    if (user.name != token) {
        res.statusCode = 401;
        // res.setHeader("WWW-Authenticate", 'Basic realm="MyRealmName"');
        res.end("Unauthorized");
    }
    else {
        next();
    }
};
