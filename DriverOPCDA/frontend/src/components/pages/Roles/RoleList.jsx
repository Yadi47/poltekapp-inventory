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
import roleServices from "./RoleServicesClass";
const roleServ = new roleServices();
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
  const [roles, setRole] = useState([]);

  useEffect(() => {
    fetchRoles();
  }, []);

  async function fetchRoles() {
    const resp = await roleServ.getRoles();
    setRole(resp.data);
    console.log("FETCH ROLES SUCCESS!");
    return resp;
  }

  async function deleteRole(id) {
    return new Promise(async (res, rej) => {
      try {
        const resp = await roleServ.deleterole(id);
        console.log("DEELTE ROLE SUCCESS !");
        res(resp);
      } catch (error) {
        rej(error);
      }
    });
  }

  async function handleClick(id) {
    const roleDelete = await deleteRole(id);
    if (roleDelete.success) {
      alert(roleDelete.message);
      fetchRoles();
    } else {
      alert(roleDelete.message);
    }
  }

  return (
    <TableContainer component={Paper}>
      <Table className={classes.table} aria-label="simple table">
        <TableHead>
          <TableRow>
            <TableCell>No</TableCell>
            <TableCell>Role Name</TableCell>
            <TableCell align="center">Description</TableCell>
            <TableCell align="right">Action</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {roles.map((row, i) => (
            <TableRow key={row.id}>
              <TableCell align="left">{i + 1}</TableCell>
              <TableCell align="left">{row.RoleName}</TableCell>
              <TableCell align="center">{row.Description}</TableCell>
              <TableCell align="right">
                <Button
                  component={NavLink}
                  to={"/roles/edit/" + row.id}
                  variant="contained"
                  size="small"
                  className={classes.margin}
                >
                  Edit
                </Button>
                <Button
                  variant="contained"
                  size="small"
                  disabled={row.length <= 1 ? true : false}
                  className={classes.margin}
                  onClick={(e) => {
                    if (window.confirm("Delete the role?")) {
                      handleClick(row.id, e);
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
