import axios from "axios";

class TagServicesClass {
  public getAll = async () => {
    return new Promise(async (resolve, reject) => {
      await axios
        .get(process.env.REACT_APP_BASE_URL + "/tags")
        .then((res) => {
          resolve(res.data);
        });
    });
  };

  public store = async (params: any) => {
    return new Promise(async (resolve, reject) => {
      await axios
        .post(process.env.REACT_APP_BASE_URL + "/tags", params)
        .then((res) => {
          resolve(res.data);
        });
    });
  };

  public findOne = async (id: number) => {
    return new Promise(async (resolve, reject) => {
      await axios
        .put(process.env.REACT_APP_BASE_URL + "/tags/" + id)
        .then((res) => {
          resolve(res.data);
        });
    });
  };

  public update = async (id: number, params: any) => {
    return new Promise(async (resolve, reject) => {
      await axios
        .patch(process.env.REACT_APP_BASE_URL + "/tags/" + id, params)
        .then((res) => {
          resolve(res.data);
        });
    });
  };

  public delete = async (id: number) => {
    return new Promise(async (resolve, reject) => {
      await axios
        .delete(process.env.REACT_APP_BASE_URL + "/tags/" + id)
        .then((res) => {
          resolve(res.data);
        });
    });
  };
}

export default TagServicesClass;
