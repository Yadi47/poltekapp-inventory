import { DataTypes, Model } from "sequelize";
import DB from "../Database/Database";
import Role from "./Role";
export default class User extends Model {}
User.init(
  {
    id: {
      type: DataTypes.BIGINT,
      primaryKey: true,
      unique: true,
    },
    Email: {
      type: DataTypes.STRING,
      allowNull: true,
      unique: true,
    },
    UserName: {
      type: DataTypes.STRING,
      allowNull: false,
      defaultValue: "root",
      unique: true,
    },
    Name: {
      type: DataTypes.STRING,
      allowNull: false,
      defaultValue: "root",
    },
    Password: {
      type: DataTypes.STRING,
    },
    Avatar: {
      type: DataTypes.STRING,
    },
    RoleId: {
      type: DataTypes.INTEGER,
      references: {
        // This is a reference to another model
        model: Role,
        // This is the column name of the referenced model
        key: "Id",
      },
      allowNull: false,
    },
  },
  {
    // Other model options go here
    sequelize: DB, // We need to pass the connection instance
    modelName: "User", // We need to choose the model name
  }
);

User.belongsTo(Role, { as: "role", foreignKey: "RoleId" });
Role.hasMany(User, { as: "users", foreignKey: "RoleId" });

