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

import TagServices from "./TagServicesClass";
const tagServ = new TagServices();

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
class TagGroupFormAdd extends React.Component {
  constructor(props) {
    super(props);
    this.onSuccess = this.onSuccess.bind(this);
  }
  state = {
    Tag: {
      TagName: "",
      ColumnName: "",
      TagAddress: "",
      Status: false,
      StaticValue: 0,
      TagGroupId: this.props.match.params.id,
    },
  };

  onSuccess(e) {
    this.props.history.push(
      "/opc/tag-groups/detail/" + this.props.match.params.id
    );
  }

  handleChange = (event) => {
    const { Tag } = this.state;
    Tag[event.target.name] = event.target.value;
    this.setState({ Tag });
  };

  handleSubmit = async () => {
    const { Tag } = this.state;
    const paramInsert = {
      TagName: Tag.TagName,
      ColumnName: Tag.ColumnName,
      TagAddress: Tag.TagAddress,
      Status: Tag.Status,
      StaticValue: Tag.StaticValue,
      TagGroupId: Tag.TagGroupId,
    };

    console.log(paramInsert);
    const resp = await tagServ.store(paramInsert);
    // save role data
    if (resp.success) {
      alert(resp.message);
      this.onSuccess();
    } else {
      alert(resp.message);
    }
  };

  componentDidMount() {}

  componentWillUnmount() {}

  render() {
    const { classes } = this.props;
    const { Tag } = this.state;

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
                label="Tag Name"
                onChange={this.handleChange}
                name="TagName"
                value={Tag.TagName}
                validators={["required"]}
                errorMessages={["this field is required"]}
                className={classes.textField}
              />
              <TextValidator
                label="Column Name"
                onChange={this.handleChange}
                name="ColumnName"
                value={Tag.ColumnName}
                validators={["required"]}
                errorMessages={["this field is required"]}
                className={classes.textField}
              />
              <TextValidator
                label="Tag Address"
                onChange={this.handleChange}
                name="TagAddress"
                value={Tag.TagAddress}
                validators={["required"]}
                errorMessages={["this field is required"]}
                className={classes.textField}
              />
              <SelectValidator
                label="Status"
                id="demo-simple-select-helper"
                value={Tag.Status}
                onChange={this.handleChange}
                validators={["required"]}
                errorMessages={["this field is required"]}
                className={classes.selectField}
                name="Status"
              >
                <MenuItem value="">
                  <em>None</em>
                </MenuItem>

                <MenuItem value={true}>enable</MenuItem>
                <MenuItem value={false}>disable</MenuItem>
              </SelectValidator>

              <TextValidator
                type="number"
                label="Static Value"
                onChange={this.handleChange}
                name="StaticValue"
                value={Tag.StaticValue}
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

export default withRouter(withStyles(useStyles)(TagGroupFormAdd));
