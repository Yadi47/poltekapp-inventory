import { makeStyles } from "@material-ui/core/styles";
import Table from "@material-ui/core/Table";
import TableBody from "@material-ui/core/TableBody";
import TableCell from "@material-ui/core/TableCell";
import TableContainer from "@material-ui/core/TableContainer";
import TableHead from "@material-ui/core/TableHead";
import TableRow from "@material-ui/core/TableRow";
import Paper from "@material-ui/core/Paper";
import Button from "@material-ui/core/Button";
import { NavLink } from "react-router-dom";
import { useState, useEffect } from "react";
import userServices from "./UserServicesClass";
const userServ = new userServices();
const useStyles = makeStyles((theme) => ({
  table: {
    minWidth: 650,
  },
  margin: {
    margin: theme.spacing(1),
  },

  extendedIcon: {
    marginRight: theme.spacing(1),
  },
}));

export default function BasicTable(props) {
  const classes = useStyles();
  const [users, setUser] = useState([]);
  
  useEffect(() => {
    fetchUsers();
  }, []);

  async function fetchUsers() {
    const resp = await userServ.getUsers();
    setUser(resp.data);
    console.log("FETCH USER SUCCESS!");
    return resp;
  }

  async function deleteUsers(id){
    return new Promise(async (res,rej)=>{
      try {
        const resp = await userServ.deleteUsers(id)
        console.log("DELETE USER SUCCESS !")
        res(resp)
      } catch (error) {
        rej(error)
      }
    })
  }

  async function handleClick(id) {
    const userDelete = await deleteUsers(id)
    if (userDelete.success) {
      alert(userDelete.message);
      fetchUsers();
    } else {
      alert(userDelete.message);
    }
    
  }

  return (
    <TableContainer component={Paper}>
      <Table className={classes.table} aria-label="simple table">
        <TableHead>
          <TableRow>
            <TableCell>No</TableCell>
            <TableCell>Email</TableCell>
            <TableCell align="right">Username</TableCell>
            <TableCell align="right">Name</TableCell>
            <TableCell align="right">Role</TableCell>
            <TableCell align="right">Action</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {users.map((user, i) => (
            <TableRow key={user.id}>
              <TableCell align="right">{i + 1}</TableCell>
              <TableCell component="th" scope="row">
                {user.Email}
              </TableCell>
              <TableCell align="right">{user.UserName}</TableCell>
              <TableCell align="right">{user.Name}</TableCell>
              <TableCell align="right">{user.role.RoleName}</TableCell>
              <TableCell align="right">
              
                <Button
                  component={NavLink}
                  to={"/users/edit/" + user.id}
                  variant="contained"
                  size="small"
                  className={classes.margin}
                >
                  Edit
                </Button>
                <Button
                  variant="contained"
                  size="small"
                  disabled={users.length <= 1 ? true : false}
                  className={classes.margin}
                  onClick={(e) => {
                    if (window.confirm("Delete the user?")) {
                      handleClick(user.id, e);
                    }
                  }}
                >
                  Delete
                </Button>
              </TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </TableContainer>
  );
}
