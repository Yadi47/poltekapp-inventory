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
import Chip from "@material-ui/core/Chip";

import TagGroupServices from "./TagGroupServicesClass";
import socketIOClient from "socket.io-client";
const ENDPOINT = process.env.REACT_APP_BASE_URL;
const TagGroupServ = new TagGroupServices();
var socket = {};

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
  danger: {
    background: "#DC004E",
    color: "white",
  },
  success: {
    background: "#48B330",
    color: "white",
  },
  btnDetail: {
    background: "#47AF83",
    borderRadius: 3,
    border: 0,
    color: "white",
    boxShadow: "0 3px 20px 2px rgb(151 151 151 / 42%)",
    "&:hover": {
      background: "#38A68A",
    },
    margin: theme.spacing(1),
  },
}));

export default function BasicTable(props) {
  const classes = useStyles();
  const [tagGroups, setTagGroups] = useState([]);

  useEffect(() => {
    socket = socketIOClient(ENDPOINT);
    
    socket.on("toClientValues", (data) => {
      let html = ''
      data.values.map((d) => {
        if(d !== null)
          html += d['TagName'] + " : " + d['TagValue'] + "\r\n";
        return html
      });
      alert(html);
    });

    
    getTagGroups();
    return () => {
      socket.removeAllListeners("toClientValues");
    };
  }, [props]);

  async function getTagGroups() {
    const resp = await TagGroupServ.getAll();
    setTagGroups(resp.data);
    return resp;
  }

  async function handleClick(id) {
    const resp = await TagGroupServ.delete(id);
    if (resp.success) {
      alert(resp.message);
      getTagGroups();
    } else {
      alert(resp.message);
    }
  }

  async function readValue(id) {
    const resp =  await TagGroupServ.findOne(id)
    // let tags =[];
    // tags = resp.data.tags.map((tag,i)=>{
    //   return tag.TagAddress;
    // });
    // const payload = {
    //   "server": resp.data.TagGroupServer,
    //   "tags" : tags
    // }
    await TagGroupServ.getValues(id, resp.data);
  }

  return (
    <TableContainer component={Paper}>
      <Table className={classes.table} aria-label="simple table">
        <TableHead>
          <TableRow>
            <TableCell>No</TableCell>
            <TableCell>Group Name</TableCell>
            <TableCell>Table Name</TableCell>
            <TableCell>Server</TableCell>
            <TableCell align="left">Status</TableCell>
            <TableCell align="right">Action</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {tagGroups.map((row, i) => (
            <TableRow key={row.id}>
              <TableCell align="left">{i + 1}</TableCell>
              <TableCell align="left">{row.TagGroupName}</TableCell>
              <TableCell align="left">{row.TagTableName}</TableCell>
              <TableCell align="left">{row.TagGroupServer}</TableCell>
              <TableCell align="center">
                {row.Status === true ? (
                  <Chip label={"ON"} className={classes.success} />
                ) : (
                  <Chip label={"OFF"} className={classes.danger} />
                )}
              </TableCell>
              <TableCell align="right">
                {/* <Button
                  variant="contained"
                  size="small"
                  className={classes.btnDetail}
                  onClick={(e) => {
                    readValue(row.id);
                  }}
                >
                  Read
                </Button> */}
                <Button
                  component={NavLink}
                  to={"/opc/tag-groups/detail/" + row.id}
                  variant="contained"
                  size="small"
                  className={classes.btnDetail}
                >
                  Detail
                </Button>

                <Button
                  component={NavLink}
                  to={"/opc/tag-groups/edit/" + row.id}
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
                    if (window.confirm("Delete Tag Group?")) {
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
