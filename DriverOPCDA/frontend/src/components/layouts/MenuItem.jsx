import React from "react"
import ListItem from "@material-ui/core/ListItem";
import ListItemIcon from "@material-ui/core/ListItemIcon";
import ListItemText from "@material-ui/core/ListItemText";


export default class MenuItem extends React.Component {
 

  render() {
    return (
      <ListItem
        button
        component={this.props.component}
        to={this.props.link}
        activeClassName="link-active"
      >
        <ListItemIcon children={this.props.icon}></ListItemIcon>
        <ListItemText primary={this.props.menu} />
      </ListItem>
    );
  }
}