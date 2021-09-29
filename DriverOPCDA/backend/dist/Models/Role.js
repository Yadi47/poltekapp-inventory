"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const sequelize_1 = require("sequelize");
const Database_1 = __importDefault(require("../Database/Database"));
class Role extends sequelize_1.Model {
}
exports.default = Role;
Role.init({
    id: {
        type: sequelize_1.DataTypes.BIGINT,
        primaryKey: true,
        unique: true,
    },
    RoleName: {
        type: sequelize_1.DataTypes.STRING,
        allowNull: false,
        defaultValue: "root",
        unique: true,
    },
    Description: {
        type: sequelize_1.DataTypes.STRING,
    },
}, {
    sequelize: Database_1.default,
    modelName: "Role",
});
