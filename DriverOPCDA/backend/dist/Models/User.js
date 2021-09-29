"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const sequelize_1 = require("sequelize");
const Database_1 = __importDefault(require("../Database/Database"));
const Role_1 = __importDefault(require("./Role"));
class User extends sequelize_1.Model {
}
exports.default = User;
User.init({
    id: {
        type: sequelize_1.DataTypes.BIGINT,
        primaryKey: true,
        unique: true,
    },
    Email: {
        type: sequelize_1.DataTypes.STRING,
        allowNull: true,
        unique: true,
    },
    UserName: {
        type: sequelize_1.DataTypes.STRING,
        allowNull: false,
        defaultValue: "root",
        unique: true,
    },
    Name: {
        type: sequelize_1.DataTypes.STRING,
        allowNull: false,
        defaultValue: "root",
    },
    Password: {
        type: sequelize_1.DataTypes.STRING,
    },
    Avatar: {
        type: sequelize_1.DataTypes.STRING,
    },
    RoleId: {
        type: sequelize_1.DataTypes.INTEGER,
        references: {
            // This is a reference to another model
            model: Role_1.default,
            // This is the column name of the referenced model
            key: "Id",
        },
        allowNull: false,
    },
}, {
    // Other model options go here
    sequelize: Database_1.default,
    modelName: "User", // We need to choose the model name
});
User.belongsTo(Role_1.default, { as: "role", foreignKey: "RoleId" });
Role_1.default.hasMany(User, { as: "users", foreignKey: "RoleId" });
