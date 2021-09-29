import { Controller } from "./Controller";
import { UserInterface } from "../Interface/UserInterface";

import User from "../Models/User";
import Role from "../Models/Role";
const Op = require("Sequelize").Op;
const bcrypt = require("bcrypt");

export default class LoginController
  extends Controller
  implements UserInterface {
  private users: UserInterface[];
  public readonly Email;
  public readonly UserName;
  public readonly Name;
  public readonly Password;
  public readonly Avatar;
  public readonly RoleId;
  private success: boolean = false;
  private msg: String = "";
  private code: number = 0;
  private PasswordValidate: String = "";
  private user: any = {};
  constructor() {
    super();
    this.Email = "";
    this.UserName = "";
    this.Name = "";
    this.Password = "";
    this.Avatar = "";
    this.RoleId = 0;
    this.users = [];
  }

  public login = async (req: any, res: any) => {
    try {
      // cari username or emailnya
      let where = {
        [Op.or]: [
          { Email: req.body.emailOrUsername },
          { UserName: req.body.emailOrUsername },
        ],
      };

      this.users = (await User.findAll({
        where,
        include: [
          {
            model: Role,
            as: "role",
          },
        ],
      })) as [];

      if (this.users.length > 0) {
        // jika user ditemukan
        this.PasswordValidate = this.users[0].Password;
        let isAuthenticated = bcrypt.compareSync(
          req.body.password,
          this.PasswordValidate
        );
        
        this.user = this.users[0];
        console.log(this.user.Password)
        // check password
        if (isAuthenticated) {
          this.msg = this.LOGIN_SUCCESS;
          this.success = true;
          this.code = 200;
        } else {
          this.msg = this.LOGIN_FAILED + "Wrong Password";
          this.success = true;
          this.code = 401;
        }
      } else {
        this.msg = this.LOGIN_FAILED + "Wrong Username Or Password";
        this.success = true;
        this.code = 401;
      }
    } catch (error) {
      this.msg = this.LOGIN_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(
      this.response(this.success, this.code, this.msg, {
        user: this.user,
        token: 123,
      })
    );
  };
}
