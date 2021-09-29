import { DataTypes, Model } from "sequelize";
import DB from "../Database/Database";

export default class TagGroup extends Model {
  
}
TagGroup.init(
  {
    id: {
      type: DataTypes.BIGINT,
      primaryKey: true,
      unique: true,
    },
    TagGroupName: {
      type: DataTypes.STRING,
      allowNull: false,
      unique: true,
    },
    TagGroupServer: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    TagTableName: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    Description: {
      type: DataTypes.STRING,
    },
    Status: {
      type: DataTypes.BOOLEAN,
    },
  },
  {
    sequelize: DB,
    modelName: "TagGroup",
  }
);
