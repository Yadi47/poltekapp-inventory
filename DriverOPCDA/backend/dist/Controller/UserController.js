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
const Controller_1 = require("./Controller");
const User_1 = __importDefault(require("../Models/User"));
const Role_1 = __importDefault(require("../Models/Role"));
const bcrypt = require("bcrypt");
class UserController extends Controller_1.Controller {
    constructor() {
        super();
        this.user = {};
        this.msg = "";
        this.success = false;
        this.code = 0;
        this.get = (req, res) => __awaiter(this, void 0, void 0, function* () {
            try {
                this.users = (yield User_1.default.findAll({
                    include: [
                        {
                            model: Role_1.default,
                            as: "role",
                        },
                    ],
                }));
                this.msg = this.GET_ALL_SUCCESS;
                this.success = true;
                this.code = 200;
            }
            catch (error) {
                this.msg = this.GET_ALL_FAILED + error;
                this.success = false;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.users));
        });
        this.store = (req, res) => __awaiter(this, void 0, void 0, function* () {
            this.user = {
                Email: req.body.Email,
                UserName: req.body.UserName,
                Name: req.body.Name,
                Password: bcrypt.hashSync(req.body.Password, 10),
                Avatar: req.body.Avatar,
                RoleId: req.body.RoleId,
            };
            try {
                this.user = yield User_1.default.create(this.user);
                this.msg = this.INSERT_SUCCESS;
                this.success = true;
                this.code = 200;
            }
            catch (error) {
                this.msg = this.INSERT_FAILED + error;
                this.success = false;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.user));
        });
        this.find = (req, res) => __awaiter(this, void 0, void 0, function* () {
            try {
                this.user = yield User_1.default.findByPk(req.params.id);
                this.success = true;
                this.code = 200;
                this.msg = this.GET_ALL_SUCCESS;
            }
            catch (error) {
                this.success = false;
                this.msg = this.GET_ALL_SUCCESS;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.user));
        });
        this.update = (req, res) => __awaiter(this, void 0, void 0, function* () {
            try {
                this.user = yield User_1.default.findByPk(req.params.id);
                this.user.Email = req.body.Email;
                this.user.UserName = req.body.UserName;
                this.user.Name = req.body.Name;
                this.user.Password = bcrypt.hashSync(req.body.Password, 10);
                this.user.Avatar = req.body.Avatar;
                this.user.RoleId = req.body.RoleId;
                yield this.user.save();
                this.msg = this.UPDATE_SUCCESS;
                this.success = true;
                this.code = 200;
            }
            catch (error) {
                this.msg = this.UPDATE_FAILED;
                this.success = false + error;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.user));
        });
        this.delete = (req, res) => __awaiter(this, void 0, void 0, function* () {
            try {
                this.user = yield User_1.default.findByPk(req.params.id);
                yield this.user.destroy();
                this.msg = this.DELETE_SUCCESS;
                this.success = true;
                this.code = 200;
            }
            catch (error) {
                this.msg = this.DELETE_FAILED + error;
                this.success = false;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.user));
        });
        this.Email = "";
        this.UserName = "";
        this.Name = "";
        this.Password = "";
        this.Avatar = "";
        this.RoleId = 0;
        this.users = [];
    }
}
exports.default = UserController;
