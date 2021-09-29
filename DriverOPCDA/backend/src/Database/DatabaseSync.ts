import User from "../Models/User";
import Role from "../Models/Role";
import TagGroup from "../Models/TagGroup";
import Tag from "../Models/Tag";

export default async (req: any, res: any) => {
  try {
    await User.sync();
    await Role.sync();
    await TagGroup.sync();
    await Tag.sync();
    res.send({
      success: true,
      message: "Database Successfully Sync !",
      data: [],
    });
  } catch (error) {
    res.send({
      success: true,
      message: error,
      data: [],
    });
  }
};
