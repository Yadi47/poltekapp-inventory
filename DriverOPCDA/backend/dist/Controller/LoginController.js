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
const Op = require("Sequelize").Op;
const bcrypt = require("bcrypt");
class LoginController extends Controller_1.Controller {
    constructor() {
        super();
        this.success = false;
        this.msg = "";
        this.code = 0;
        this.PasswordValidate = "";
        this.user = {};
        this.login = (req, res) => __awaiter(this, void 0, void 0, function* () {
            try {
                // cari username or emailnya
                let where = {
                    [Op.or]: [
                        { Email: req.body.emailOrUsername },
                        { UserName: req.body.emailOrUsername },
                    ],
                };
                this.users = (yield User_1.default.findAll({
                    where,
                    include: [
                        {
                            model: Role_1.default,
                            as: "role",
                        },
                    ],
                }));
                if (this.users.length > 0) {
                    // jika user ditemukan
                    this.PasswordValidate = this.users[0].Password;
                    let isAuthenticated = bcrypt.compareSync(req.body.password, this.PasswordValidate);
                    this.user = this.users[0];
                    console.log(this.user.Password);
                    // check password
                    if (isAuthenticated) {
                        this.msg = this.LOGIN_SUCCESS;
                        this.success = true;
                        this.code = 200;
                    }
                    else {
                        this.msg = this.LOGIN_FAILED + "Wrong Password";
                        this.success = true;
                        this.code = 401;
                    }
                }
                else {
                    this.msg = this.LOGIN_FAILED + "Wrong Username Or Password";
                    this.success = true;
                    this.code = 401;
                }
            }
            catch (error) {
                this.msg = this.LOGIN_FAILED + error;
                this.success = false;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, {
                user: this.user,
                token: 123,
            }));
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
exports.default = LoginController;
