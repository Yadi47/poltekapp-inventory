import React from "react";
import Container from "@material-ui/core/Container";
import BreadCrumb from "../layouts/Breadcrumb";
import Grid from "@material-ui/core/Grid";
import { Box} from "@material-ui/core";
import {  withRouter } from "react-router-dom";

import TagGroupDesc from './TagGroups/TagGroupDesc'
import TagGroupTags from './TagGroups/TagGroupTags'

class TagGroupDetail extends React.Component {
  constructor(props) {
    super(props);
    this.pageTitle = "Tag Group Detail";
    this.links = [
      {
        link: "/opc/tag-groups",
        text: "Tag Groups",
      },
      {
        link: "/opc/tag-groups/detail/" + this.props.match.params.id,
        text: this.pageTitle,
      },
    ];
  }
  async componentDidMount() {
    document.title = process.env.REACT_APP_APP_NAME + " - " + this.pageTitle;
  }

  render() {
    const links = this.links;
    return (
      <main className={this.props.content}>
        <Container maxWidth={"xl"}>
          <BreadCrumb links={links} />
          <Box mt={3} width="100%">
          </Box>
          <Grid container spacing={3}>
            <Grid item xl={4} lg={4} xs={12}>
              <TagGroupDesc id={this.props.match.params.id}></TagGroupDesc>
            </Grid>
            <Grid item xl={8} lg={8} xs={12}>
              <TagGroupTags id={this.props.match.params.id}></TagGroupTags>
            </Grid>
          </Grid>
        </Container>
      </main>
    );
  }
}

export default withRouter(TagGroupDetail);
