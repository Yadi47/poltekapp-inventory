import { Controller } from "./Controller";
import { TagInterface } from "../Interface/TagInterface";
import Tag from "../Models/Tag";

export default class TagController extends Controller implements TagInterface {
  private Tags: Tag[] = [];
  private Tag: any = {};
  private success: boolean = false;
  private msg: String = "";
  private code: number = 0;
  public readonly TagName = "";
  public readonly ColumnName = "";
  public readonly tagAdress = "";
  public readonly Status = false;
  public readonly StaticValue = 0;
  public readonly TagGroupId = 0;
  constructor() {
    super();
  }

  public get = async (req: any, res: any) => {
    try {
      this.Tags = (await Tag.findAll()) as [];
      this.msg = this.GET_ALL_SUCCESS;
      this.success = true;
      this.code = 200;
    } catch (error) {
      this.msg = this.GET_ALL_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.Tags));
  };

  public store = async (req: any, res: any) => {
    this.Tag = {
      TagName: req.body.TagName,
      ColumnName: req.body.ColumnName,
      TagAddress: req.body.TagAddress,
      Status: req.body.Status,
      StaticValue: req.body.StaticValue,
      TagGroupId: req.body.TagGroupId,
    };

    try {
      this.Tag = Tag.build(this.Tag);
      await this.Tag.save();
      this.msg = this.INSERT_SUCCESS;
      this.success = true;
      this.code = 201;
    } catch (error) {
      this.msg = this.INSERT_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.Tag));
  };

  public find = async (req: any, res: any) => {
    try {
      this.Tag = await Tag.findByPk(req.params.id);
      this.msg = this.GET_ALL_SUCCESS;
      this.success = true;
      this.code = 200;
    } catch (error) {
      this.msg = this.GET_ALL_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.Tag));
  };

  public update = async (req: any, res: any) => {
    try {
      this.Tag = await Tag.findByPk(req.params.id);
      if (this.Tag) {
        this.Tag.TagName = req.body.TagName;
        this.Tag.ColumnName = req.body.ColumnName;
        this.Tag.TagAddress = req.body.TagAddress;
        this.Tag.Status = req.body.Status;
        this.Tag.StaticValue = req.body.StaticValue;
        this.Tag.TagGroupId = req.body.TagGroupId;
        await this.Tag.save();
      }
      this.msg = this.UPDATE_SUCCESS;
      this.success = true;
      this.code = 200;
    } catch (error) {
      this.msg = this.UPDATE_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.Tag));
  };

  public findByStatus = async (req: any, res: any) => {
    try {
      this.Tag = await Tag.findAll({
        where: {
          Status: req.params.status,
        },
      });
      this.msg = this.GET_ALL_SUCCESS;
      this.success = true;
      this.code = 200;
    } catch (error) {
      this.msg = this.GET_ALL_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.Tag));
  };

  public delete = async (req: any, res: any) => {
    try {
      this.Tag = await Tag.findByPk(req.params.id);
      await this.Tag.destroy();
      this.msg = this.DELETE_SUCCESS;
      this.success = true;
      this.code = 200;
    } catch (error) {
      this.msg = this.DELETE_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.Tag));
  };
}
