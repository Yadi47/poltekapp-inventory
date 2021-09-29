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
const Role_1 = __importDefault(require("../Models/Role"));
class RoleController extends Controller_1.Controller {
    constructor() {
        super();
        this.success = false;
        this.msg = "";
        this.code = 0;
        this.get = (req, res) => __awaiter(this, void 0, void 0, function* () {
            try {
                this.roles = (yield Role_1.default.findAll());
                this.msg = this.GET_ALL_SUCCESS;
                this.success = true;
                this.code = 200;
            }
            catch (error) {
                this.msg = this.GET_ALL_FAILED + error;
                this.success = false;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.roles));
        });
        this.store = (req, res) => __awaiter(this, void 0, void 0, function* () {
            this.role = {
                RoleName: req.body.RoleName,
                Description: req.body.Description,
            };
            try {
                this.role = Role_1.default.build(this.role);
                yield this.role.save();
                this.msg = this.INSERT_SUCCESS;
                this.success = true;
                this.code = 201;
            }
            catch (error) {
                this.msg = this.INSERT_FAILED + error;
                this.success = false;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.role));
        });
        this.find = (req, res) => __awaiter(this, void 0, void 0, function* () {
            try {
                this.role = yield Role_1.default.findByPk(req.params.id);
                this.msg = this.GET_ALL_SUCCESS;
                this.success = true;
                this.code = 200;
            }
            catch (error) {
                this.msg = this.GET_ALL_FAILED + error;
                this.success = false;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.role));
        });
        this.update = (req, res) => __awaiter(this, void 0, void 0, function* () {
            this.role = {
                RoleName: req.body.RoleName,
                Description: req.body.Description,
            };
            try {
                this.role = yield Role_1.default.findByPk(req.params.id);
                if (this.role) {
                    this.role.RoleName = req.body.RoleName;
                    this.role.Description = req.body.Description;
                    yield this.role.save();
                }
                this.msg = this.UPDATE_SUCCESS;
                this.success = true;
                this.code = 200;
            }
            catch (error) {
                this.msg = this.UPDATE_FAILED + error;
                this.success = false;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.role));
        });
        this.delete = (req, res) => __awaiter(this, void 0, void 0, function* () {
            try {
                this.role = yield Role_1.default.findByPk(req.params.id);
                yield this.role.destroy();
                this.msg = this.DELETE_SUCCESS;
                this.success = true;
                this.code = 200;
            }
            catch (error) {
                this.msg = this.DELETE_FAILED + error;
                this.success = false;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.role));
        });
        this.RoleName = ``;
        this.Description = ``;
        this.roles = [];
    }
}
exports.default = RoleController;
