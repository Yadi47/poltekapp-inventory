import { Controller } from "./Controller";
import { TagGroupInterface } from "../Interface/TagGroupInterface";
import TagGroup from "../Models/TagGroup";
import Tag from "../Models/Tag";

export default class RoleController extends Controller implements TagGroupInterface {
  private tagGroups: TagGroupInterface[] = [];
  private tagGroup: any = {};
  private success: boolean = false;
  private msg: String = "";
  private code: number = 0;
  public readonly TagGroupName = "";
  public readonly TagTableName = "";
  public readonly TagGroupServer = "";
  public readonly Description = "";
  public readonly Status = false;
  constructor() {
    super();
  }

  public getWithTags = async (req: any, res: any) => {
    try {
      this.tagGroups = (await TagGroup.findAll({
        include: [
          {
            model: Tag,
            as: "tags",
          },
          
        ],
        where: {
          Status:1,
        },
      })) as [];
      this.msg = this.GET_ALL_SUCCESS;
      this.success = true;
      this.code = 200;
    } catch (error) {
      this.msg = this.GET_ALL_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.tagGroups));
  };
  public get = async (req: any, res: any) => {
    try {
      
      this.tagGroups = (await TagGroup.findAll()) as [];
      this.msg = this.GET_ALL_SUCCESS;
      this.success = true;
      this.code = 200;
    } catch (error) {
      this.msg = this.GET_ALL_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.tagGroups));
  };

  public store = async (req: any, res: any) => {
    this.tagGroup = {
      TagGroupName: req.body.TagGroupName,
      TagTableName: req.body.TagTableName,
      TagGroupServer: req.body.TagGroupServer,
      Description: req.body.Description,
      Status: req.body.Status,
    };

    try {
      this.tagGroup = TagGroup.build(this.tagGroup);
      await this.tagGroup.save();
      this.msg = this.INSERT_SUCCESS;
      this.success = true;
      this.code = 201;
    } catch (error) {
      this.msg = this.INSERT_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.tagGroup));
  };

  public find = async (req: any, res: any) => {
    try {
      this.tagGroup = await TagGroup.findOne({
        include: [
          {
            model: Tag,
            as: "tags",
          },
        ],
        where: {
          id: req.params.id,
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
    res.send(this.response(this.success, this.code, this.msg, this.tagGroup));
  };

  public findByStatus = async (req: any, res: any) => {
    try {
      this.tagGroup = await TagGroup.findAll({where:{
        Status : req.params.status
      }});
      this.msg = this.GET_ALL_SUCCESS;
      this.success = true;
      this.code = 200;
    } catch (error) {
      this.msg = this.GET_ALL_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.tagGroup));
  };

  public update = async (req: any, res: any) => {
    this.tagGroup = {
      TagGroupName: req.body.TagGroupName,
      TagTableName: req.body.TagTableName,
      TagGroupServer: req.body.TagGroupServer,
      Description: req.body.Description,
      Status: req.body.Status,
    };
    try {
      this.tagGroup = await TagGroup.findByPk(req.params.id);
      if (this.tagGroup) {
        this.tagGroup.TagGroupName = req.body.TagGroupName;
        this.tagGroup.TagTableName = req.body.TagTableName;
        this.tagGroup.TagGroupServer = req.body.TagGroupServer;
        this.tagGroup.Description = req.body.Description;
        this.tagGroup.Status = req.body.Status;
        await this.tagGroup.save();
      }
      this.msg = this.UPDATE_SUCCESS;
      this.success = true;
      this.code = 200;
    } catch (error) {
      this.msg = this.UPDATE_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.tagGroup));
  };

  public delete = async (req: any, res: any) => {
    try {
      Tag.destroy({
        where: {
          TagGroupId:req.params.id
        }
    });
      this.tagGroup = await TagGroup.findByPk(req.params.id);
      await this.tagGroup.destroy();
      this.msg = this.DELETE_SUCCESS;
      this.success = true;
      this.code = 200;
    } catch (error) {
      this.msg = this.DELETE_FAILED + error;
      this.success = false;
      this.code = 204;
    }
    res.send(this.response(this.success, this.code, this.msg, this.tagGroup));
  };
}
