import React from "react";
import Container from "@material-ui/core/Container";
import BreadCrumb from "../layouts/Breadcrumb";
import PageTitle from "../layouts/PageTitle";
import { Box } from "@material-ui/core";
import RoleFormAdd from "./Roles/RoleFormAdd";

export default class RoleAdd extends React.Component {
  constructor(props) {
    super(props);
    this.pageTitle = "Role Add";
    this.links = [
      {
        link: "/roles",
        text: "Role Management",
      },
      {
        link: "/roles/add",
        text: this.pageTitle,
      },
    ];
    
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
            <RoleFormAdd></RoleFormAdd>
          </Box>
        </Container>
      </main>
    );
  }
}
