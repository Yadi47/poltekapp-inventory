import React from "react";
import { withStyles } from "@material-ui/core/styles";
import { Grid, Box, MenuItem } from "@material-ui/core";
import Button from "@material-ui/core/Button";
import { withRouter } from "react-router-dom";
import { connect } from "react-redux";

import {
  ValidatorForm,
  TextValidator,
  SelectValidator,
} from "react-material-ui-form-validator";
import axios from "axios";
import {setUserAuth} from  "../../../redux/UserLogin/userLogin.action"
import userServices from "./UserServicesClass";
const userServ = new userServices();

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
class UserFormEdit extends React.Component {
  constructor(props) {
    super(props);
    this.onSuccess = this.onSuccess.bind(this);
  }
  state = {
    user: {
      email: "",
      username: "",
      name: "",
      avatar: "",
      roleid: "",
      password: "",
      repeatPassword: "",
    },
    roles: [],
  };

  onSuccess(e) {
    this.props.history.push("/users");
  }

  handleChange = (event) => {
    const { user } = this.state;
    user[event.target.name] = event.target.value;
    this.setState({ user });
  };

  handleSubmit = async () => {
    const { user } = this.state;
    let paramInsert = {
      Email: user.email,
      UserName: user.username,
      Name: user.name,
      Avatar: user.avatar,
      RoleId: user.roleid,
    };

    if (user.password !== "") {
      paramInsert["Password"] = user.password;
    }

    console.log(paramInsert);

    // save user data
    const resp = await userServ.updateUser(
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

  async componentDidMount() {
    // find user data
    this.findUser(this.props.match.params.id);
    // get data roles
    await axios.get(process.env.REACT_APP_BASE_URL + "/roles").then((res) => {
      const roles = res.data.data;
      this.setState({
        roles: roles,
      });
    });

    // custom validation password
    ValidatorForm.addValidationRule("isPasswordMatch", (value) => {
      if (value !== this.state.user.password) {
        return false;
      }
      return true;
    });

    // custom validation username
    ValidatorForm.addValidationRule("userName", (value) => {
      const nameRegex = /^[A-z]{2,}[A-z0-9]{0,}$/;
      if (!value.match(nameRegex)) {
        return false;
      }
      return true;
    });
  }

  async findUser(id) {
    const resp = await userServ.findUser(id);
    const data = resp.data;
    if (data != null) {
      const { user } = this.state;
      user["email"] = data.Email;
      user["username"] = data.UserName;
      user["name"] = data.Name;
      user["avatar"] = data.Avatar;
      user["roleid"] = data.RoleId;
      this.props.setUserAuth(user)
      this.setState({ user });
    }
    // console.log(this.state);
    console.log(this.props);

  }

  componentWillUnmount() {
    // remove rule when it is not needed
    ValidatorForm.removeValidationRule("isPasswordMatch");
    ValidatorForm.removeValidationRule("userName");
  }

  render() {
    const { classes } = this.props;
    const { user } = this.state;

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
                label="Email"
                onChange={this.handleChange}
                name="email"
                value={user.email}
                validators={["required", "isEmail"]}
                errorMessages={["this field is required", "email is not valid"]}
                className={classes.textField}
              />
              <TextValidator
                label="Username"
                onChange={this.handleChange}
                name="username"
                value={user.username}
                validators={["required", "userName"]}
                errorMessages={[
                  "this field is required",
                  "Illegal Caracter in Username",
                ]}
                className={classes.textField}
              />

              <TextValidator
                label="Full Name"
                onChange={this.handleChange}
                name="name"
                value={user.name}
                validators={["required"]}
                errorMessages={["this field is required"]}
                className={classes.textField}
              />

              <SelectValidator
                id="demo-simple-select-helper"
                value={user.roleid}
                onChange={this.handleChange}
                validators={["required"]}
                errorMessages={["this field is required"]}
                className={classes.selectField}
                name="roleid"
              >
                <MenuItem value="">
                  <em>None</em>
                </MenuItem>
                {this.state.roles.map((role, i) => (
                  <MenuItem key={role.id} value={role.id}>
                    {role.RoleName}
                  </MenuItem>
                ))}
              </SelectValidator>

              <TextValidator
                label="New Password"
                onChange={this.handleChange}
                name="password"
                type="password"
                validators={[]}
                errorMessages={["this field is required"]}
                value={user.password}
                className={classes.textField}
              />
              <TextValidator
                label="Repeat New password"
                onChange={this.handleChange}
                name="repeatPassword"
                type="password"
                validators={["isPasswordMatch"]}
                errorMessages={["password mismatch"]}
                value={user.repeatPassword}
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

const mapStateToProps = (state)=>{
 return {
   auth: state.auth,
 };
}

const mapDispatchToProps = (dispatch) => {
  return {
    setUserAuth: (p) => dispatch(setUserAuth(p)),
  };
};
export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(withStyles(useStyles)(UserFormEdit)));
