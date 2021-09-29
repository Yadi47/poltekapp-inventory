import React from "react";
import { withStyles } from "@material-ui/core/styles";
import { Grid, Box } from "@material-ui/core";
import Button from "@material-ui/core/Button";
import { withRouter } from "react-router-dom";

import { ValidatorForm, TextValidator } from "react-material-ui-form-validator";

import roleServices from "./RoleServicesClass";
const roleServ = new roleServices();

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
class RoleFormEdit extends React.Component {
  constructor(props) {
    super(props);
    this.onSuccess = this.onSuccess.bind(this);
  }
  state = {
    role: {
      RoleName: "",
      Description: "",
    },
  };

  onSuccess(e) {
    this.props.history.push("/roles");
  }

  handleChange = (event) => {
    const { role } = this.state;
    role[event.target.name] = event.target.value;
    this.setState({ role });
  };

  handleSubmit = async () => {
    const { role } = this.state;
    const paramInsert = {
      RoleName: role.RoleName,
      Description: role.Description,
    };

    // save role data
    const resp = await roleServ.updateRole(
      this.props.match.params.id,
      paramInsert
    );
    if (resp.success) {
      alert(resp.message);
      this.onSuccess();
    } else {
      alert(resp.message);
    }
  };

  async findRole(id) {
    const resp = await roleServ.findRole(id);
    const data = resp.data;
    if (data != null) {
      const { role } = this.state;
      role["RoleName"] = data.RoleName;
      role["Description"] = data.Description;
      this.setState({ role });
    }
    console.log(this.state);
  }

  componentDidMount() {
      this.findRole(this.props.match.params.id);
  }

  componentWillUnmount() {}

  render() {
    const { classes } = this.props;
    const { role } = this.state;

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
                label="Role name"
                onChange={this.handleChange}
                name="RoleName"
                value={role.RoleName}
                validators={["required"]}
                errorMessages={["this field is required"]}
                className={classes.textField}
              />
              <TextValidator
                label="Description"
                onChange={this.handleChange}
                name="Description"
                value={role.Description}
                validators={[]}
                errorMessages={[]}
                className={classes.textField}
              />

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

export default withRouter(withStyles(useStyles)(RoleFormEdit));
