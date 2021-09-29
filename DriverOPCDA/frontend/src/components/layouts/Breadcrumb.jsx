import React from "react";
import Breadcrumbs from "@material-ui/core/Breadcrumbs";
import { Link } from "react-router-dom";

import * as Icon from "@material-ui/icons";

export default function SimpleBreadcrumbs(props) {
  
  return (
    <Breadcrumbs aria-label="breadcrumb">
      <Link color="inherit" to="/" style={{ textDecoration: "none" }}>
        <Icon.Home />
      </Link>
      {props.links.map((object, i) => {
        return (
          <Link
            color="inherit"
            key={i}
            to={object.link}
            style={{ textDecoration: "none" }}
          >
            {object.text}
          </Link>
        );
      })}
    </Breadcrumbs>
  );
}
