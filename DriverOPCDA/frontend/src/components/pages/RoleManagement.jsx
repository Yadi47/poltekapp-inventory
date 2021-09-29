import React from "react";
import Container from "@material-ui/core/Container";
import BreadCrumb from "../layouts/Breadcrumb";
import PageTitle from "../layouts/PageTitle";
import RoleList from "../pages/Roles/RoleList";
import { withStyles } from "@material-ui/core/styles";

import { Box, Button } from "@material-ui/core";
import { NavLink } from "react-router-dom";

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

export default class RoleManagement extends React.Component {
  constructor(props) {
    super(props);
    this.pageTitle = "Role Management";
    this.links = [
      {
        link: "roles",
        text: this.pageTitle,
      },
    ];
    this.state = {
      roles: [],
    };
  }
  async componentDidMount() {
    document.title = process.env.REACT_APP_APP_NAME + " - " + this.pageTitle;
  }

  render() {
    const links = this.links;
    const pageTitle = this.pageTitle;
    return (
      <main className={this.props.content}>
        <Container maxWidth={"xl"}>
          <BreadCrumb links={links} />
          <Box
            boxShadow={1}
            p={3}
            style={{ background: "white" }}
            mt={3}
            width="100%"
          >
            <Box>
              <PageTitle pageTitle={pageTitle} />
              <Box>
                <AddUserButton component={NavLink} to="/roles/add">
                  Add Role
                </AddUserButton>
              </Box>
            </Box>
            {/* CONTENT */}
            <RoleList></RoleList>
          </Box>
        </Container>
      </main>
    );
  }
}
