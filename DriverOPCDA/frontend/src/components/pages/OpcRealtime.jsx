import React from "react";
import Container from "@material-ui/core/Container";
import Box from "@material-ui/core/Box";

import BreadCrumb from "../layouts/Breadcrumb";

import OpcRealtimeListGroup from "./OpcRealtime/OpcRealtimeListGroup";
import socketIOClient from "socket.io-client";
import { setRealtime } from "../../redux/Realtime/realtime.actions";

import { connect } from "react-redux";
import { gridColumnLookupSelector } from "@material-ui/data-grid";

const ENDPOINT = process.env.REACT_APP_BASE_URL;
var socket = {}
class OpcRealtime extends React.Component {
  constructor(props) {
    super(props);
    this.pageTitle = "OPC Realtime";
    this.links = [
      {
        link: "/Realtime",
        text: this.pageTitle,
      },
    ];
    this.state ={
        values : []
    }
  }

  componentDidMount() {
    document.title = process.env.REACT_APP_APP_NAME + " - " + this.pageTitle;
    socket = socketIOClient(ENDPOINT);

    // socket.emit('toServerFromFrontendRealtime',{'sd':'  '})
    // socket.on("toClientRealtimeValuesResult", (data) => {
    //   if (this.props.realtimeSelected.id === data.TagGroupId) {
    //     this.props.setRealtimeValues(data.values);
    //   }
    //   setTimeout(() => {
    //     socket.emit("toServerFromFrontendRealtime", data);
    //   }, 1000);
    // });
    socket.on("toClientRealtimeValuesResult", (data) => {
      data = JSON.parse(data);
      if (this.props.realtimeSelected.id === data.TagGroupId) {
        this.props.setRealtimeValues(data.values);
      }
    });


   
    
   
  }
  componentWillUnmount(){
    socket.removeAllListeners("toClientRealtimeValuesResult");
    socket.removeAllListeners("connect");
    socket.disconnect();
  }
  render() {
    const links = this.links;

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
            <OpcRealtimeListGroup
            ></OpcRealtimeListGroup>
          </Box>
        </Container>
      </main>
    );
  }
}

const mapStateToProps = (state)=>{
    return {
      realtimeValues: state.state_realtime_values.values,
      realtimeSelected: state.state_realtime_values.selected,
    };
}

const mapDispatchToProps = (dispatch) =>{
    return {
        setRealtimeValues : (p) => dispatch(setRealtime(p))
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(OpcRealtime);