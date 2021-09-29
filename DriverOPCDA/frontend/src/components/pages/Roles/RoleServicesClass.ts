import axios from "axios";

class RoleServicesClass {
  public getRoles = async () => {
    return new Promise(async (resolve, reject) => {
      await axios.get(process.env.REACT_APP_BASE_URL + "/roles").then((res) => {
        resolve(res.data);
      });
    });
  };

  public storeRole = async (params: any) => {
    return new Promise(async (resolve, reject) => {
      await axios
        .post(process.env.REACT_APP_BASE_URL + "/roles", params)
        .then((res) => {
          resolve(res.data);
        });
    });
  };

  public findRole = async (id: number) => {
    return new Promise(async (resolve, reject) => {
      await axios
        .put(process.env.REACT_APP_BASE_URL + "/roles/" + id)
        .then((res) => {
          resolve(res.data);
        });
    });
  };

  public updateRole = async (id: number, params: any) => {
    return new Promise(async (resolve, reject) => {
      await axios
        .patch(process.env.REACT_APP_BASE_URL + "/roles/" + id, params)
        .then((res) => {
          resolve(res.data);
        });
    });
  };

  public deleterole = async (id: number) => {
    return new Promise(async (resolve, reject) => {
      await axios
        .delete(process.env.REACT_APP_BASE_URL + "/roles/" + id)
        .then((res) => {
          resolve(res.data);
        });
    });
  };
}

export default RoleServicesClass;
