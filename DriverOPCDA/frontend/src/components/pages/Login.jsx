import React from "react";
import { useState, useEffect } from "react";
import Button from "@material-ui/core/Button";
import CssBaseline from "@material-ui/core/CssBaseline";
import { useHistory } from "react-router-dom";
import FormControlLabel from "@material-ui/core/FormControlLabel";
import Link from "@material-ui/core/Link";
import Grid from "@material-ui/core/Grid";
import Box from "@material-ui/core/Box";
import Typography from "@material-ui/core/Typography";
import { makeStyles } from "@material-ui/core/styles";
import { IconButton } from "@material-ui/core";
import { Visibility, VisibilityOff } from "@material-ui/icons";
import { withStyles } from "@material-ui/core/styles";
import axios from "axios";
import Container from "@material-ui/core/Container";
import logo_eh from "../../assets/logo_eh.png";
import logo_gr from "../../assets/logo_groot.png";
import { green } from "@material-ui/core/colors";
import CircularProgress from "@material-ui/core/CircularProgress";
import { connect } from "react-redux";
import { setUserAuth,setIsAuth } from "../../../src/redux/UserLogin/userLogin.action";

import { ValidatorForm, TextValidator } from "react-material-ui-form-validator";
const AddUserButton = withStyles({
  root: {
    background: "linear-gradient(45deg, #2196F3 30%, #2196F3 90%)",
    borderRadius: 3,
    border: 0,
    float: "right",
    color: "white",
    height: 40,
    padding: "0 30px",
    boxShadow: "0 3px 20px 2px rgb(151 151 151 / 42%)",
  },
  label: {
    textTransform: "capitalize",
  },
})(Button);
function Copyright() {
  return (
    <Typography variant="body2" color="textSecondary" align="center">
      {"Powered By  "}
      <Link color="inherit" href="https://grootech.id">
        {/* Grootech */}
        <img
          src={logo_gr}
          style={{ maxHeight: "40px", marginBlock: "-14px" }}
          alt="logo"
        />
      </Link>{" "}
      {new Date().getFullYear()}
      {"."}
    </Typography>
  );
}

const useStyles = makeStyles((theme) => ({
  paper: {
    marginTop: theme.spacing(8),
    display: "flex",
    flexDirection: "column",
    alignItems: "center",
  },
  avatar: {
    margin: theme.spacing(1),
    backgroundColor: theme.palette.secondary.main,
  },
  form: {
    width: "100%", // Fix IE 11 issue.
    marginTop: theme.spacing(1),
  },
  submit: {
    margin: theme.spacing(3, 0, 2),
  },
  wrapper: {
    margin: theme.spacing(1),
    position: "relative",
  },
  buttonSuccess: {
    backgroundColor: green[500],
    "&:hover": {
      backgroundColor: green[700],
    },
  },
  fabProgress: {
    color: green[500],
    position: "absolute",
    top: -6,
    left: -6,
    zIndex: 1,
  },
  buttonProgress: {
    color: green[500],
    position: "absolute",
    top: "50%",
    left: "50%",
    marginTop: -12,
    marginLeft: -12,
  },
}));

function Login(props) {
  const history = useHistory();
  const classes = useStyles();
  const [emailOrUsername, setEmailOrUsername] = useState("");
  const [password, setPassword] = useState("");
  const [values, setValues] = React.useState({
    showPassword: false,
  });
  const [loading, setLoading] = React.useState(false);

  async function handleSubmit() {
    let params = {
      emailOrUsername: emailOrUsername,
      password: password,
    };
    setLoading(true);
    await axios
      .post(process.env.REACT_APP_BASE_URL + "/login", params)
      .then((res) => {
        if (res.data.code !== 200) {
          alert(res.data.message);
          setLoading(false);
        } else {
          setLoading(false);
          props.setUserAuth(res.data.data.user);
          props.setIsAuth(true);
          history.push("/dashboard");
        }
      });
  }
  const handleClickShowPassword = () => {
    setValues({ ...values, showPassword: !values.showPassword });
  };

  const handleMouseDownPassword = (event) => {
    event.preventDefault();
  };
  useEffect(() => {
    document.title = process.env.REACT_APP_APP_NAME + " - " + "Login";
    return () => {};
  }, []);

  return (
    <Container component="main" maxWidth="xs">
      <CssBaseline />
      <div className={classes.paper}>
        <img
          src={logo_eh}
          style={{ maxHeight: "125px" }}
          alt="logo"
          className={classes.logo}
        />
        <Typography component="h2" variant="h5">
          Endress+Hauser
        </Typography>
        <Typography component="h2" variant="h5">
          TankVision Login
        </Typography>
        <ValidatorForm className={classes.form} onSubmit={handleSubmit}>
          {/* <form className={classes.form} noValidate> */}
          <TextValidator
            variant="outlined"
            margin="normal"
            validators={["required"]}
            errorMessages={["this field is required"]}
            fullWidth
            id="emailorusername"
            label="Email / Username"
            name="email_or_username"
            autoComplete="email/username"
            autoFocus
            onChange={(e) => setEmailOrUsername(e.target.value)}
            value={emailOrUsername}
          />
          {/* <TextValidator
            variant="outlined"
            margin="normal"
            validators={["required"]}
            errorMessages={["this field is required"]}
            fullWidth
            name="password"
            label="Password"
            type="password"
            id="password"
            autoComplete="current-password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
          /> */}
          <TextValidator
            variant="outlined"
            margin="normal"
            validators={["required"]}
            errorMessages={["this field is required"]}
            fullWidth
            name="password"
            label="Password"
            type={values.showPassword ? "text" : "password"}
            id="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
          />

          <FormControlLabel
            control={
              <IconButton
                aria-label="toggle password visibility"
                onClick={handleClickShowPassword}
                onMouseDown={handleMouseDownPassword}
              >
                {values.showPassword ? <Visibility /> : <VisibilityOff />}
              </IconButton>
            }
            label="Password Visibility"
          />
          <div className={classes.wrapper}>
            <AddUserButton
              type="submit"
              fullWidth
              variant="contained"
              color="primary"
              disabled={loading}
              // onClick={(e) => onLogin(e)}
              className={classes.submit}
            >
              Log In
            </AddUserButton>

            {loading && (
              <CircularProgress size={24} className={classes.buttonProgress} />
            )}
          </div>

          <Grid container>
            {/* <Grid item xs>
              <Link href="#" variant="body2">
                Forgot password?
              </Link>
            </Grid>
            <Grid item>
              <Link href="#" variant="body2">
                {"Don't have an account? Sign Up"}
              </Link>
            </Grid> */}
          </Grid>
          {/* </form> */}
        </ValidatorForm>
      </div>
      <Box mt={8}>
        <Copyright />
      </Box>
    </Container>
  );
}



const mapStateToProps = (state) => {
  return {
    StateUserAuth: state.auth,
  };
};
const mapDispatchToProps = (dispact) => {
  return {
    setUserAuth: (p) => dispact(setUserAuth(p)),
    setIsAuth: (p) => dispact(setIsAuth(p)),
  };
};
export default connect(mapStateToProps, mapDispatchToProps)(Login);