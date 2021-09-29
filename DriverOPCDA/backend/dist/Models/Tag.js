"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const sequelize_1 = require("sequelize");
const Database_1 = __importDefault(require("../Database/Database"));
const TagGroup_1 = __importDefault(require("./TagGroup"));
class Tag extends sequelize_1.Model {
}
exports.default = Tag;
Tag.init({
    id: {
        type: sequelize_1.DataTypes.BIGINT,
        primaryKey: true,
        unique: true,
    },
    TagName: {
        type: sequelize_1.DataTypes.STRING,
        allowNull: false,
    },
    ColumnName: {
        type: sequelize_1.DataTypes.STRING,
        allowNull: false,
    },
    TagAddress: {
        type: sequelize_1.DataTypes.STRING,
    },
    Status: {
        type: sequelize_1.DataTypes.BOOLEAN,
    },
    StaticValue: {
        type: sequelize_1.DataTypes.FLOAT,
    },
    TagGroupId: {
        type: sequelize_1.DataTypes.INTEGER,
        references: {
            // This is a reference to another model
            model: TagGroup_1.default,
            // This is the column name of the referenced model
            key: "Id",
        },
        onDelete: 'cascade',
        allowNull: false,
    },
}, {
    sequelize: Database_1.default,
    modelName: "Tag",
});
Tag.belongsTo(TagGroup_1.default, { as: "tag_group", foreignKey: "TagGroupId" });
TagGroup_1.default.hasMany(Tag, { as: "tags", foreignKey: "TagGroupId" });
