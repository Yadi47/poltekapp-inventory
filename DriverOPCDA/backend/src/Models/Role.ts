import { DataTypes, Model } from "sequelize";
import DB from "../Database/Database";

export default class Role extends Model {}
Role.init(
  {
    id: {
      type: DataTypes.BIGINT,
      primaryKey: true,
      unique: true,
    },
    RoleName: {
      type: DataTypes.STRING,
      allowNull: false,
      defaultValue: "root",
      unique: true,
    },
    Description: {
      type: DataTypes.STRING,
    },
  },
  {
    sequelize: DB,
    modelName: "Role",
  }
);

