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
const TagGroup_1 = __importDefault(require("../Models/TagGroup"));
const Tag_1 = __importDefault(require("../Models/Tag"));
class RoleController extends Controller_1.Controller {
    constructor() {
        super();
        this.tagGroups = [];
        this.tagGroup = {};
        this.success = false;
        this.msg = "";
        this.code = 0;
        this.TagGroupName = "";
        this.TagTableName = "";
        this.TagGroupServer = "";
        this.Description = "";
        this.Status = false;
        this.getWithTags = (req, res) => __awaiter(this, void 0, void 0, function* () {
            try {
                this.tagGroups = (yield TagGroup_1.default.findAll({
                    include: [
                        {
                            model: Tag_1.default,
                            as: "tags",
                        },
                    ],
                    where: {
                        Status: 1,
                    },
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
            res.send(this.response(this.success, this.code, this.msg, this.tagGroups));
        });
        this.get = (req, res) => __awaiter(this, void 0, void 0, function* () {
            try {
                this.tagGroups = (yield TagGroup_1.default.findAll());
                this.msg = this.GET_ALL_SUCCESS;
                this.success = true;
                this.code = 200;
            }
            catch (error) {
                this.msg = this.GET_ALL_FAILED + error;
                this.success = false;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.tagGroups));
        });
        this.store = (req, res) => __awaiter(this, void 0, void 0, function* () {
            this.tagGroup = {
                TagGroupName: req.body.TagGroupName,
                TagTableName: req.body.TagTableName,
                TagGroupServer: req.body.TagGroupServer,
                Description: req.body.Description,
                Status: req.body.Status,
            };
            try {
                this.tagGroup = TagGroup_1.default.build(this.tagGroup);
                yield this.tagGroup.save();
                this.msg = this.INSERT_SUCCESS;
                this.success = true;
                this.code = 201;
            }
            catch (error) {
                this.msg = this.INSERT_FAILED + error;
                this.success = false;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.tagGroup));
        });
        this.find = (req, res) => __awaiter(this, void 0, void 0, function* () {
            try {
                this.tagGroup = yield TagGroup_1.default.findOne({
                    include: [
                        {
                            model: Tag_1.default,
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
            }
            catch (error) {
                this.msg = this.GET_ALL_FAILED + error;
                this.success = false;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.tagGroup));
        });
        this.findByStatus = (req, res) => __awaiter(this, void 0, void 0, function* () {
            try {
                this.tagGroup = yield TagGroup_1.default.findAll({ where: {
                        Status: req.params.status
                    } });
                this.msg = this.GET_ALL_SUCCESS;
                this.success = true;
                this.code = 200;
            }
            catch (error) {
                this.msg = this.GET_ALL_FAILED + error;
                this.success = false;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.tagGroup));
        });
        this.update = (req, res) => __awaiter(this, void 0, void 0, function* () {
            this.tagGroup = {
                TagGroupName: req.body.TagGroupName,
                TagTableName: req.body.TagTableName,
                TagGroupServer: req.body.TagGroupServer,
                Description: req.body.Description,
                Status: req.body.Status,
            };
            try {
                this.tagGroup = yield TagGroup_1.default.findByPk(req.params.id);
                if (this.tagGroup) {
                    this.tagGroup.TagGroupName = req.body.TagGroupName;
                    this.tagGroup.TagTableName = req.body.TagTableName;
                    this.tagGroup.TagGroupServer = req.body.TagGroupServer;
                    this.tagGroup.Description = req.body.Description;
                    this.tagGroup.Status = req.body.Status;
                    yield this.tagGroup.save();
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
            res.send(this.response(this.success, this.code, this.msg, this.tagGroup));
        });
        this.delete = (req, res) => __awaiter(this, void 0, void 0, function* () {
            try {
                Tag_1.default.destroy({
                    where: {
                        TagGroupId: req.params.id
                    }
                });
                this.tagGroup = yield TagGroup_1.default.findByPk(req.params.id);
                yield this.tagGroup.destroy();
                this.msg = this.DELETE_SUCCESS;
                this.success = true;
                this.code = 200;
            }
            catch (error) {
                this.msg = this.DELETE_FAILED + error;
                this.success = false;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.tagGroup));
        });
    }
}
exports.default = RoleController;
