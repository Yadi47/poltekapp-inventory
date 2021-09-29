"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const sequelize_1 = require("sequelize");
const Database_1 = __importDefault(require("../Database/Database"));
class TagGroup extends sequelize_1.Model {
}
exports.default = TagGroup;
TagGroup.init({
    id: {
        type: sequelize_1.DataTypes.BIGINT,
        primaryKey: true,
        unique: true,
    },
    TagGroupName: {
        type: sequelize_1.DataTypes.STRING,
        allowNull: false,
        unique: true,
    },
    TagGroupServer: {
        type: sequelize_1.DataTypes.STRING,
        allowNull: false,
    },
    TagTableName: {
        type: sequelize_1.DataTypes.STRING,
        allowNull: true,
    },
    Description: {
        type: sequelize_1.DataTypes.STRING,
    },
    Status: {
        type: sequelize_1.DataTypes.BOOLEAN,
    },
}, {
    sequelize: Database_1.default,
    modelName: "TagGroup",
});
