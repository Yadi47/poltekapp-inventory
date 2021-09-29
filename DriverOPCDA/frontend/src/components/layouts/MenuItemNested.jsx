import React from "react";
import { makeStyles } from "@material-ui/core/styles";
import ListItem from "@material-ui/core/ListItem";
import ListItemIcon from "@material-ui/core/ListItemIcon";
import ListItemText from "@material-ui/core/ListItemText";
import Collapse from "@material-ui/core/Collapse";
import * as Icon from "@material-ui/icons";

const useStyles = makeStyles((theme) => ({
  nested: {
    paddingLeft: theme.spacing(5),
    paddingTop :3,
    paddingBottom :3,
  },
  item: {
    padding: 0,
  },
}));


export default function MenuItemNested(props){
    const classes = useStyles();
    const [open, setOpen] = React.useState(false);

    const handleClick = () => {
      setOpen(!open);
    };
    return (
      <React.Fragment>
        <ListItem button onClick={handleClick}>
          <ListItemIcon children={props.icon}></ListItemIcon>
          <ListItemText primary={props.menu} />
          {open ? <Icon.ExpandLess /> : <Icon.ExpandMore />}
        </ListItem>
        <Collapse in={open} timeout="auto" unmountOnExit>
        {props.subMenu.map((sm,i)=>{
            return (
              <ListItem component="div" className={classes.item} key={i}>
                <ListItem
                  component={sm.component}
                  to={sm.link}
                  button
                  className={classes.nested}
                  activeClassName="link-active"
                >
                  <ListItemIcon children={<sm.icon />}></ListItemIcon>
                  <ListItemText primary={sm.menu} />
                </ListItem>
              </ListItem>
            );
        })

        }
          

        </Collapse>
      </React.Fragment>
    );
}