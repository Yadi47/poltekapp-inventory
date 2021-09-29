import { Controller } from "./Controller";
import { RoleInterface } from "../Interface/Roleinterface";
import Role from "../Models/Role";

export default class RoleController extends Controller implements RoleInterface {
  private roles: RoleInterface[];
  private role: any;
  private success: boolean = false;
  private msg: String = "";
  private code: number = 0;
  public readonly RoleName;
  public readonly Description;
  constructor() {
    super();
    this.RoleName = ``;
    this.Description = ``;
    this.roles = [];
   
  }

  public get = async (req: any, res: any) => {
    try {
      this.roles = (await Role.findAll()) as [];
      this.msg = this.GET_ALL_SUCCESS;
      this.success = true;
      this.code = 200;
    } catch (error) {
      this.msg = this.GET_ALL_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.roles));
  };

  public store = async (req: any, res: any) => {
    this.role = {
      RoleName: req.body.RoleName,
      Description: req.body.Description,
    };

    try {
      this.role = Role.build(this.role);
      await this.role.save();

      this.msg = this.INSERT_SUCCESS;
      this.success = true;
      this.code = 201;
    } catch (error) {
      this.msg = this.INSERT_FAILED + error;
      this.success = false;
      this.code = 204;
    }

    res.send(this.response(this.success, this.code, this.msg, this.role));
  };

  public find = async (req: any, res: any) => {
    try {
      this.role = await Role.findByPk(req.params.id);
      this.msg = this.GET_ALL_SUCCESS;
      this.success = true;
      this.code = 200;
    } catch (error) {
      this.msg = this.GET_ALL_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.role));
  };

  public update = async (req: any, res: any) => {
    this.role = {
      RoleName: req.body.RoleName,
      Description: req.body.Description,
    };
    try {
      this.role = await Role.findByPk(req.params.id);
      if (this.role) {
        this.role.RoleName = req.body.RoleName;
        this.role.Description = req.body.Description;
        await this.role.save();
      }
      this.msg = this.UPDATE_SUCCESS;
      this.success = true;
      this.code = 200;
    } catch (error) {
      this.msg = this.UPDATE_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.role));
  };

  public delete = async (req: any, res: any) => {
    try {
      this.role = await Role.findByPk(req.params.id);
      await this.role.destroy();
      this.msg = this.DELETE_SUCCESS;
      this.success = true;
      this.code = 200;
    } catch (error) {
      this.msg = this.DELETE_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.role));
  };
}
