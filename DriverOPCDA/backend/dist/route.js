"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const UserController_1 = __importDefault(require("./Controller/UserController"));
const RoleController_1 = __importDefault(require("./Controller/RoleController"));
const TagGroupController_1 = __importDefault(require("./Controller/TagGroupController"));
const TagController_1 = __importDefault(require("./Controller/TagController"));
const LoginController_1 = __importDefault(require("./Controller/LoginController"));
const swagger_ui_express_1 = __importDefault(require("swagger-ui-express"));
const DatabaseSync_1 = __importDefault(require("./Database/DatabaseSync"));
const bcrypt = require("bcrypt");
const YAML = require("yamljs");
const swaggerDocument = YAML.load("./swagger.yaml");
const init = (router) => {
    router.get("/database/sync", DatabaseSync_1.default);
    const userController = new UserController_1.default(), roleController = new RoleController_1.default(), tagGroupController = new TagGroupController_1.default(), tagController = new TagController_1.default(), loginController = new LoginController_1.default();
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
    router.get("/test", (req, res) => __awaiter(void 0, void 0, void 0, function* () {
        const saltRounds = 10;
        const password = "RoninAssasins";
        const passwordConfirm = "JohnDoe1!";
        const hash = bcrypt.hashSync(password, saltRounds);
        let isTrue = bcrypt.compareSync(passwordConfirm, "$2b$10$..wUWkpbeVZsN5znGWPnyeERfLESaRJAbd5VSFYJYxhs7ZEQrc3BK"); // true
        res.send(isTrue);
    }));
};
;
const swagger = (app) => {
    app.use("/api-docs", swagger_ui_express_1.default.serve, swagger_ui_express_1.default.setup(swaggerDocument));
};
exports.default = {
    init,
    swagger,
};
