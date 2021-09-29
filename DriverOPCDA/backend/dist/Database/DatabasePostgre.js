"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const { Sequelize } = require("sequelize");
// Option 2: Passing parameters separately (other dialects)
const sequelize = new Sequelize("itokin", "postgres", "root", {
    host: "localhost",
    dialect: "postgres" /* one of 'mysql' | 'mariadb' | 'postgres' | 'mssql' */,
    logging: false,
});
exports.default = sequelize;
