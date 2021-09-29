"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const sequelize_1 = require("sequelize");
var sequelize = new sequelize_1.Sequelize({
    dialect: "sqlite",
    storage: "database/NxaTankvision.sqlite",
    logging: false
});
exports.default = sequelize;
