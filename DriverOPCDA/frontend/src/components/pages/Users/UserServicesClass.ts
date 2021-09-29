import axios from 'axios'

class UserServicesClass {
  public getUsers = async () => {
    return new Promise(async (resolve, reject) => {
      await axios.get(process.env.REACT_APP_BASE_URL + "/users").then((res) => {
        resolve(res.data);
      });
    });
  };

  public findUser = async (id: number) => {
    return new Promise(async (resolve, reject) => {
      await axios
        .put(process.env.REACT_APP_BASE_URL + "/users/" + id)
        .then((res) => {
          resolve(res.data);
        });
    });
  };

  public updateUser = async (id: number, params: any) => {
    return new Promise(async (resolve, reject) => {
      await axios
        .patch(process.env.REACT_APP_BASE_URL + "/users/" + id, params)
        .then((res) => {
          resolve(res.data);
        });
    });
  };

  public deleteUsers = async (id: number) => {
    return new Promise(async (resolve, reject) => {
      await axios
        .delete(process.env.REACT_APP_BASE_URL + "/users/" + id)
        .then((res) => {
          resolve(res.data);
        });
    });
  };
}

export default UserServicesClass