import axios from "axios";

class TagGroupServicesClass {
  public getAll = async () => {
    return new Promise(async (resolve, reject) => {
      await axios.get(process.env.REACT_APP_BASE_URL + "/tag-groups").then((res) => {
        resolve(res.data);
      });
    });
  };

  public store = async (params: any) => {
    return new Promise(async (resolve, reject) => {
      await axios
        .post(process.env.REACT_APP_BASE_URL + "/tag-groups", params)
        .then((res) => {
          resolve(res.data);
        });
    });
  };

  public findOne = async (id: number) => {
    return new Promise(async (resolve, reject) => {
      await axios
        .put(process.env.REACT_APP_BASE_URL + "/tag-groups/" + id)
        .then((res) => {
          resolve(res.data);
        });
    });
  };

  public update = async (id: number, params: any) => {
    return new Promise(async (resolve, reject) => {
      await axios
        .patch(process.env.REACT_APP_BASE_URL + "/tag-groups/" + id, params)
        .then((res) => {
          resolve(res.data);
        });
    });
  };

  public delete = async (id: number) => {
    return new Promise(async (resolve, reject) => {
      await axios
        .delete(process.env.REACT_APP_BASE_URL + "/tag-groups/" + id)
        .then((res) => {
          resolve(res.data);
        });
    });
  };
  public getServers = async () => {
    return new Promise(async (resolve, reject) => {
      await axios
        .get(process.env.REACT_APP_BASE_URL + "/gateway-servers")
        .then((res) => {
          resolve(res.data);
        });
    });
  };

  public getValues = async (id:number,data:any) => {
    return new Promise(async (resolve, reject) => {
      await axios
        .post(
          process.env.REACT_APP_BASE_URL + "/websocket/getValues/" + id,
          data
        )
        .then((res) => {
          resolve(res.data);
        });
    });
  };
}

export default TagGroupServicesClass;
