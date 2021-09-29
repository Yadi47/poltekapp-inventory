import React from "react";
import Box from "@material-ui/core/Box";
import Container from "@material-ui/core/Container";

import BreadCrumb from "../layouts/Breadcrumb";
import PageTitle from "../layouts/PageTitle"
export default class Administrator extends React.Component {
  constructor(props) {
    super(props);
    this.pageTitle = "Administrator";
    this.links = [
      {
        link: "administrator",
        text: "Administrator",
      },
    ];
  }

  componentDidMount() {
    document.title = process.env.REACT_APP_APP_NAME + " - " + this.pageTitle;
  }

  render() {
    const pageTitle = this.pageTitle;
    const links = this.links;
    return (
      <main className={this.props.content}>
        <Container>
          <BreadCrumb links={links} />
          <Box
            boxShadow={1}
            mt={3}
            p={3}
            style={{ background: "white" }}
            width="100%"
          >
            <Box>
              <PageTitle pageTitle={pageTitle} />
            </Box>
          </Box>
        </Container>
      </main>
    );
  }
}
