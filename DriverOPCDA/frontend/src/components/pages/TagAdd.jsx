import React from "react";
import Container from "@material-ui/core/Container";
import BreadCrumb from "../layouts/Breadcrumb";
import PageTitle from "../layouts/PageTitle";
import { Box } from "@material-ui/core";
import { withRouter } from "react-router-dom";
import TagFormAdd from "./TagGroups/TagFormAdd";
import TagGroupServices from  './TagGroups/TagGroupServicesClass'
const TagGroupServ = new TagGroupServices()
class TagAdd extends React.Component {
  constructor(props) {
    super(props);
    this.pageTitle = "Tag Add";
    this.id = this.props.match.params.id
    this.test = ""
    this.state = {
        groupName :'ss'
    }
    this.links = [
      {
        link: "/opc/tag-groups",
        text: "Tag Groups",
      },
      {
        link: "/opc/tag-groups/detail/" + this.id,
        text: "Tag Group Detail",
      },
      {
        link: "/opc/tags/add/" + this.id,
        text: this.pageTitle,
      },
    ];
  }
  async componentDidMount() {
    document.title = process.env.REACT_APP_APP_NAME + " - " + this.pageTitle;
    this.findOne()
    this.test = '123'
    console.log(this.test)
  }

  async findOne(){
    const resp = await TagGroupServ.findOne(this.id)
    this.setState({ groupName: resp.data.TagGroupName });
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
              <PageTitle pageTitle={pageTitle + " (" +this.state.groupName+")"} />
              <Box></Box>
            </Box>
            {/* CONTENT */}
            <TagFormAdd></TagFormAdd>
          </Box>
        </Container>
      </main>
    );
  }
}

export default withRouter(TagAdd);
