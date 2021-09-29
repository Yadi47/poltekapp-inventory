import React from "react";
import { withStyles } from "@material-ui/core/styles";
import { Grid, Box, MenuItem } from "@material-ui/core";
import Button from "@material-ui/core/Button";
import { withRouter } from "react-router-dom";

import {
  ValidatorForm,
  TextValidator,
  SelectValidator,
} from "react-material-ui-form-validator";

import TagGroupServices from "./TagGroupServicesClass";
import socketIOClient from "socket.io-client";
const ENDPOINT = process.env.REACT_APP_BASE_URL;
var socket = {};
const tagGroupServ = new TagGroupServices();

const useStyles = (theme) => ({
  root: {
    "& .MuiTextField-root": {
      margin: theme.spacing(1),
      width: "90%",
    },
  },
  gridColor: {
    background: "white",
  },
  button: {
    marginTop: theme.spacing(1),
    color: "#ffffff",
    background: theme.palette.success.main,
    "&:hover": {
      backgroundColor: theme.palette.success.dark,
      borderColor: theme.palette.success.light,
      boxShadow: "none",
    },
  },
  buttonGetServer: {
    marginTop: theme.spacing(1),
    color: "#ffffff",
    background: theme.palette.primary.main,
    "&:hover": {
      backgroundColor: theme.palette.primary.dark,
      borderColor: theme.palette.primary.light,
      boxShadow: "none",
    },
  },
  form: {
    background: "white",
  },
  textField: {
    width: "100%",
    marginTop: 10,
  },
  selectField: {
    width: "100%",
    marginTop: 20,
  },
});
class TagGroupFormEdit extends React.Component {
  constructor(props) {
    super(props);
    this.onSuccess = this.onSuccess.bind(this);
  }
  state = {
    tagGroup: {
      TagGroupName: "",
      TagTableName: "",
      TagGroupServer: "",
      Description: "",
      Status: false,
    },
    servers: [[]],
  };

  onSuccess(e) {
    this.props.history.push("/opc/tag-groups");
  }

  handleChange = (event) => {
    const { tagGroup } = this.state;
    tagGroup[event.target.name] = event.target.value;
    this.setState({ tagGroup });
  };

  handleSubmit = async () => {
    const { tagGroup } = this.state;
    const paramInsert = {
      TagGroupName: tagGroup.TagGroupName,
      TagTableName: tagGroup.TagTableName,
      TagGroupServer: tagGroup.TagGroupServer,
      Description: tagGroup.Description,
      Status: tagGroup.Status,
    };

    const resp = await tagGroupServ.update(
      this.props.match.params.id,
      paramInsert
    );
    // save role data
    if (resp.success) {
      alert(resp.message);
      this.onSuccess();
    } else {
      alert(resp.message);
    }
  };
  find = async (id) => {
    const resp = await tagGroupServ.findOne(id);
    const { tagGroup } = this.state;

    for (const key in resp.data) {
      const element = resp.data[key];
      tagGroup[key] = element;
    }
    console.log(tagGroup)
    this.setState({ tagGroup });
    var servers = this.state.servers.concat(tagGroup.TagGroupServer);
    this.setState({ servers });
    console.log(this.state);
  };

  componentDidMount() {
    this.find(this.props.match.params.id);
    socket = socketIOClient(ENDPOINT);
    console.log(this._isMounted);
    if (this._isMounted !== true) {
      if (socket)
        socket.on("toClientServers", (data) => {
          console.log("GET SERVERS");
          console.log(data);
          this.setState({ servers: data });
        });
      this._isMounted = true;
    }
  }


  

  componentWillUnmount() {
    this._isMounted = false;
    socket.removeAllListeners("toClientServers");
    console.log("UNMOUNT");
  }
  async getServers() {
    await tagGroupServ.getServers();
    let resp = await tagGroupServ.getServers();
    let srvrs = [];
    srvrs.push(resp);
    console.log(srvrs);
    this.setState({ servers: srvrs });
  }
  render() {
    const { classes } = this.props;
    const { tagGroup } = this.state;

    return (
      <Grid container spacing={1}>
        <Grid item lg={5} xs={12}>
          <Box p={3} boxShadow={3} className={classes.form}>
            <ValidatorForm
              ref="form"
              onSubmit={this.handleSubmit}
              onError={(errors) => console.log(errors)}
            >
              <TextValidator
                label="Tag Group Name"
                onChange={this.handleChange}
                name="TagGroupName"
                value={tagGroup.TagGroupName}
                validators={["required"]}
                errorMessages={["this field is required"]}
                className={classes.textField}
              />

              <SelectValidator
                id="demo-simple-select-helper"
                value={tagGroup.TagGroupServer}
                onChange={this.handleChange}
                validators={["required"]}
                errorMessages={["this field is required"]}
                className={classes.selectField}
                name="TagGroupServer"
              >
                {this.state.servers[0].map((server, i) => (
                  <MenuItem key={i} value={server}>
                    {server}
                  </MenuItem>
                ))}
              </SelectValidator>
              <Button
                type="button"
                onClick={(e) => {
                  this.getServers();
                }}
                size="small"
                className={classes.buttonGetServer}
              >
                Get Servers
              </Button>

              <TextValidator
                label="Tag Table Name"
                onChange={this.handleChange}
                name="TagTableName"
                value={tagGroup.TagTableName}
                validators={["required"]}
                errorMessages={["this field is required"]}
                className={classes.textField}
              />
              <TextValidator
                label="Description"
                onChange={this.handleChange}
                name="Description"
                value={tagGroup.Description}
                className={classes.textField}
              />

              <SelectValidator
                id="demo-simple-select-helper"
                value={tagGroup.Status}
                onChange={this.handleChange}
                validators={["required"]}
                errorMessages={["this field is required"]}
                className={classes.selectField}
                name="Status"
              >
                <MenuItem value="">
                  <em>None</em>
                </MenuItem>

                <MenuItem value={true}>ON</MenuItem>
                <MenuItem value={false}>OFF</MenuItem>
              </SelectValidator>

              <Button type="submit" className={classes.button}>
                Submit
              </Button>
            </ValidatorForm>
          </Box>
        </Grid>
      </Grid>
    );
  }
}

export default withRouter(withStyles(useStyles)(TagGroupFormEdit));
