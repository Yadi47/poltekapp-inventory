import { DataTypes, Model } from "sequelize";
import DB from "../Database/Database";
import TagGroup from './TagGroup'
export default class Tag extends Model {}
Tag.init(
  {
    id: {
      type: DataTypes.BIGINT,
      primaryKey: true,
      unique: true,
    },
    TagName: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    ColumnName: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    TagAddress: {
      type: DataTypes.STRING,
    },
    Status: {
      type: DataTypes.BOOLEAN,
    },
    StaticValue: {
      type: DataTypes.FLOAT,
    },
    TagGroupId: {
      type: DataTypes.INTEGER,
      references: {
        // This is a reference to another model
        model: TagGroup,
        // This is the column name of the referenced model
        key: "Id",
        
      },

      onDelete: 'cascade',

      allowNull: false,
    },
  },
  {
    sequelize: DB,
    modelName: "Tag",
  }
);


Tag.belongsTo(TagGroup, { as: "tag_group", foreignKey: "TagGroupId" });
TagGroup.hasMany(Tag, { as: "tags", foreignKey: "TagGroupId" });
