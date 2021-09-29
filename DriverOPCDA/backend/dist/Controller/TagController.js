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
const Tag_1 = __importDefault(require("../Models/Tag"));
class TagController extends Controller_1.Controller {
    constructor() {
        super();
        this.Tags = [];
        this.Tag = {};
        this.success = false;
        this.msg = "";
        this.code = 0;
        this.TagName = "";
        this.ColumnName = "";
        this.tagAdress = "";
        this.Status = false;
        this.StaticValue = 0;
        this.TagGroupId = 0;
        this.get = (req, res) => __awaiter(this, void 0, void 0, function* () {
            try {
                this.Tags = (yield Tag_1.default.findAll());
                this.msg = this.GET_ALL_SUCCESS;
                this.success = true;
                this.code = 200;
            }
            catch (error) {
                this.msg = this.GET_ALL_FAILED + error;
                this.success = false;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.Tags));
        });
        this.store = (req, res) => __awaiter(this, void 0, void 0, function* () {
            this.Tag = {
                TagName: req.body.TagName,
                ColumnName: req.body.ColumnName,
                TagAddress: req.body.TagAddress,
                Status: req.body.Status,
                StaticValue: req.body.StaticValue,
                TagGroupId: req.body.TagGroupId,
            };
            try {
                this.Tag = Tag_1.default.build(this.Tag);
                yield this.Tag.save();
                this.msg = this.INSERT_SUCCESS;
                this.success = true;
                this.code = 201;
            }
            catch (error) {
                this.msg = this.INSERT_FAILED + error;
                this.success = false;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.Tag));
        });
        this.find = (req, res) => __awaiter(this, void 0, void 0, function* () {
            try {
                this.Tag = yield Tag_1.default.findByPk(req.params.id);
                this.msg = this.GET_ALL_SUCCESS;
                this.success = true;
                this.code = 200;
            }
            catch (error) {
                this.msg = this.GET_ALL_FAILED + error;
                this.success = false;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.Tag));
        });
        this.update = (req, res) => __awaiter(this, void 0, void 0, function* () {
            try {
                this.Tag = yield Tag_1.default.findByPk(req.params.id);
                if (this.Tag) {
                    this.Tag.TagName = req.body.TagName;
                    this.Tag.ColumnName = req.body.ColumnName;
                    this.Tag.TagAddress = req.body.TagAddress;
                    this.Tag.Status = req.body.Status;
                    this.Tag.StaticValue = req.body.StaticValue;
                    this.Tag.TagGroupId = req.body.TagGroupId;
                    yield this.Tag.save();
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
            res.send(this.response(this.success, this.code, this.msg, this.Tag));
        });
        this.findByStatus = (req, res) => __awaiter(this, void 0, void 0, function* () {
            try {
                this.Tag = yield Tag_1.default.findAll({
                    where: {
                        Status: req.params.status,
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
            res.send(this.response(this.success, this.code, this.msg, this.Tag));
        });
        this.delete = (req, res) => __awaiter(this, void 0, void 0, function* () {
            try {
                this.Tag = yield Tag_1.default.findByPk(req.params.id);
                yield this.Tag.destroy();
                this.msg = this.DELETE_SUCCESS;
                this.success = true;
                this.code = 200;
            }
            catch (error) {
                this.msg = this.DELETE_FAILED + error;
                this.success = false;
                this.code = 204;
            }
            res.send(this.response(this.success, this.code, this.msg, this.Tag));
        });
    }
}
exports.default = TagController;
