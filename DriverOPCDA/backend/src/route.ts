import UserController from "./Controller/UserController";
import RoleController from "./Controller/RoleController";
import TagGroupController from "./Controller/TagGroupController";
import TagController from "./Controller/TagController";
import LoginController from "./Controller/LoginController";
import BasicAuth from "./middleware/BasicAuth";
import swaggerUi from "swagger-ui-express";
import DatabaseSync from "./Database/DatabaseSync";
import TagGroup from "./Models/TagGroup";
const bcrypt = require("bcrypt");

const YAML = require("yamljs");
const swaggerDocument = YAML.load("./swagger.yaml");

const init = (router: any) => {
  router.get("/database/sync", DatabaseSync);

  const userController = new UserController(),
    roleController = new RoleController(),
    tagGroupController = new TagGroupController(),
    tagController = new TagController(),
    loginController = new LoginController();

  // route user
  router.get("/users", userController.get);
  router.put("/users/:id", userController.find);
  router.post("/users", userController.store);
  router.patch("/users/:id", userController.update);
  router.delete("/users/:id", userController.delete);

  // route role
  router.get("/roles", roleController.get);
  router.put("/roles/:id", roleController.find);
  router.post("/roles", roleController.store);
  router.patch("/roles/:id", roleController.update);
  router.delete("/roles/:id", roleController.delete);

  // route tag group
  router.get("/gateway-tag-groups", tagGroupController.getWithTags);
  router.get("/tag-groups", tagGroupController.get);
  router.put("/tag-groups/:id", tagGroupController.find);
  router.put("/tag-groups/status/:status", tagGroupController.findByStatus);
  router.post("/tag-groups", tagGroupController.store);
  router.patch("/tag-groups/:id", tagGroupController.update);
  router.delete("/tag-groups/:id", tagGroupController.delete);

  // route tag
  router.get("/tags", tagController.get);
  router.put("/tags/:id", tagController.find);

  router.post("/tags", tagController.store);
  router.patch("/tags/:id", tagController.update);

  router.delete("/tags/:id", tagController.delete);

  // login
  router.post("/login", loginController.login);

  // test
  router.get("/test", async (req: any, res: any) => {
    const saltRounds = 10;
    const password = "RoninAssasins";
    const passwordConfirm = "JohnDoe1!";

    const hash = bcrypt.hashSync(password, saltRounds);
    let isTrue = bcrypt.compareSync(
      passwordConfirm,
      "$2b$10$..wUWkpbeVZsN5znGWPnyeERfLESaRJAbd5VSFYJYxhs7ZEQrc3BK"
    ); // true

    res.send(isTrue);
  });

  

 
};;

const swagger = (app: any) => {
  app.use("/api-docs", swaggerUi.serve, swaggerUi.setup(swaggerDocument));
};

export default {
  init,
  swagger,
};
