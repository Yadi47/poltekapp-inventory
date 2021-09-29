import { Component } from "react";
import Container from "@material-ui/core/Container";
import BreadCrumb from "../layouts/Breadcrumb";
import PageTitle from "../layouts/PageTitle";
 import { withRouter } from "react-router-dom";

import { Box } from "@material-ui/core";

import UserFormEdit from "./Users/UserFormEdit";

class UserEdit extends Component {
  constructor(props) {
    super(props);
    this.pageTitle = "User Edit";
    this.links = [
      {
        link: "/users",
        text: "User Management",
      },
      {
        link: "/users/edit/" + this.props.match.params.id,
        text: this.pageTitle,
      },
    ];
    this.state = {
      users: [],
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
          <Box mt={3} width="100%">
            <Box>
              <PageTitle pageTitle={pageTitle} />
              <Box></Box>
            </Box>
            {/* CONTENT */}
            <UserFormEdit></UserFormEdit>
          </Box>
        </Container>
      </main>
    );
  }
}


export default withRouter(UserEdit);