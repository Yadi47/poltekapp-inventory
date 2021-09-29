import { Controller } from "./Controller";
import { UserInterface } from "../Interface/UserInterface";
import User from "../Models/User";
import Role from "../Models/Role";
const bcrypt = require("bcrypt");

export default class UserController extends Controller implements UserInterface {
  private users: UserInterface[];
  public readonly Email;
  public readonly UserName;
  public readonly Name;
  public readonly Password;
  public readonly Avatar;
  public readonly RoleId;
  private user: any = {};
  private msg: String = "";
  private success: boolean = false;
  private code: number = 0;
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

  public get = async (req: any, res: any) => {
    try {
      this.users = (await User.findAll({
        include: [
          {
            model: Role,
            as: "role",
          },
        ],
      })) as [];
      this.msg = this.GET_ALL_SUCCESS;
      this.success = true;
      this.code = 200;
    } catch (error) {
      this.msg = this.GET_ALL_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.users));
  };

  public store = async (req: any, res: any) => {
    this.user = {
      Email: req.body.Email,
      UserName: req.body.UserName,
      Name: req.body.Name,
      Password: bcrypt.hashSync(req.body.Password,10),
      Avatar: req.body.Avatar,
      RoleId: req.body.RoleId,
    };

    try {
      this.user = await User.create(this.user);
      this.msg = this.INSERT_SUCCESS;
      this.success = true;
      this.code = 200;
    } catch (error) {
      this.msg = this.INSERT_FAILED + error;
      this.success = false;
      this.code = 204;
    }

    res.send(this.response(this.success, this.code, this.msg, this.user));
  };

  public find = async (req: any, res: any) => {
    try {
      this.user = await User.findByPk(req.params.id);
      this.success = true;
      this.code = 200;
      this.msg = this.GET_ALL_SUCCESS;
    } catch (error) {
      this.success = false;
      this.msg = this.GET_ALL_SUCCESS;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.user));
  };

  public update = async (req: any, res: any) => {
    try {
        this.user = await User.findByPk(req.params.id);
        this.user.Email= req.body.Email
        this.user.UserName= req.body.UserName
        this.user.Name= req.body.Name
        this.user.Password= bcrypt.hashSync(req.body.Password,10)
        this.user.Avatar= req.body.Avatar
        this.user.RoleId= req.body.RoleId
        await this.user.save();
        this.msg = this.UPDATE_SUCCESS;
        this.success = true;
        this.code = 200;
    } catch (error) {
      this.msg = this.UPDATE_FAILED;
      this.success = false + error;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.user));
  };

  public delete = async (req: any, res: any) => {
    try {
      this.user = await User.findByPk(req.params.id);
      await this.user.destroy();
      this.msg = this.DELETE_SUCCESS;
      this.success = true;
      this.code = 200;
    } catch (error) {
      this.msg = this.DELETE_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.user));
  };
}
