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
const User_1 = __importDefault(require("../Models/User"));
const Role_1 = __importDefault(require("../Models/Role"));
const TagGroup_1 = __importDefault(require("../Models/TagGroup"));
const Tag_1 = __importDefault(require("../Models/Tag"));
exports.default = (req, res) => __awaiter(void 0, void 0, void 0, function* () {
    try {
        yield User_1.default.sync();
        yield Role_1.default.sync();
        yield TagGroup_1.default.sync();
        yield Tag_1.default.sync();
        res.send({
            success: true,
            message: "Database Successfully Sync !",
            data: [],
        });
    }
    catch (error) {
        res.send({
            success: true,
            message: error,
            data: [],
        });
    }
});
