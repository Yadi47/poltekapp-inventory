import React from 'react'
import Container from "@material-ui/core/Container";
import Box from "@material-ui/core/Box";
import { connect } from "react-redux";


import BreadCrumb from '../layouts/Breadcrumb'

import GridDashboard from "./Dashboard/GridDashboard";
import { setUserAuth } from "../../../src/redux/UserLogin/userLogin.action";

class Dashboard extends React.Component {
  constructor(props) {
    super(props);
    this.pageTitle = "Dashboard";
    this.links = [
      {
        link: "/dashboard",
        text: this.pageTitle,
      },
    ];
  }

  componentDidMount() {
    console.log(this.props.StateUserAuth);
    // document.title = process.env.REACT_APP_APP_NAME+' - '+this.pageTitle;
  }

  render() {
    const links = this.links

    return (
      <main className={this.props.content}>
        <Container maxWidth={"xl"}>
          <BreadCrumb links={links} />
          <Box
            // boxShadow={1}
            mt={3}
            // p={3}
            // style={{ background: "white" }}
            width="100%"
          >
            {/* <Box>
              <PageTitle pageTitle={pageTitle} />
            </Box> */}
            {/* CONTENT */}
            Hello , {this.props.StateUserAuth.Name}
            <GridDashboard />
          </Box>
        </Container>
      </main>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    StateUserAuth: state.auth.userAuth,
  };
};
const mapDispatchToProps = dispact => {
  return {
    setUserAuth: (p)=>dispact(setUserAuth(p)),
  };
};
export default connect(mapStateToProps,mapDispatchToProps)(Dashboard)