import { Sequelize } from "sequelize";
var sequelize = new Sequelize({
  dialect: "sqlite",
  storage: "database/NxaTankvision.sqlite",
  logging: false
});
export default sequelize;
