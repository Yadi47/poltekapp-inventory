import {
  Box,
  makeStyles,
  List,
  ListItem,
  ListItemIcon,
  ListItemText,
  Chip,
  Typography,
} from "@material-ui/core";
import {  useEffect } from "react";
import TagGroupServices from "./TagGroupServicesClass";

import {setTagGroup,setTagGroupTags} from '../../../redux/TagGroups/tagGroups.action';
import { connect } from "react-redux";

const TagGroupServ = new TagGroupServices();

const useStyles = makeStyles((theme) => ({
  root: {
    width: "100%",
    backgroundColor: theme.palette.background.paper,
  },
  danger: {
    background: "#DC004E",
    color: "white",
  },
  success: {
    background: "#48B330",
    color: "white",
  },
}));

function TagGroupDesc(props) {
  const classes = useStyles();
 
 
  useEffect(() => {
      
    getOne(props.id);
    console.log(props);
    
  // eslint-disable-next-line react-hooks/exhaustive-deps
  }, []);

  async function getOne(id) {
    const resp = await TagGroupServ.findOne(id);
    props.SetStateTagGroup(resp.data);
    props.SetStateTagGroupTags(resp.data.tags);
    console.log("GET ONE CALLED");
  }

  return (
    <Box boxShadow={3} p={2} style={{ background: "#ffffff" }}>
      <Typography variant="h5">Group Details</Typography>
      <div className={classes.root}>
        <List component="nav" aria-label="main mailbox folders">
          <ListItem button>
            <ListItemIcon style={{ width: "35%" }}>
              <ListItemText primary="Group Name" />
            </ListItemIcon>
            <ListItemText
              style={{ float: "right" }}
              primary={" : " + props.StateTagGroup.TagGroup.TagGroupName}
            />
          </ListItem>
          <ListItem button>
            <ListItemIcon style={{ width: "35%" }}>
              <ListItemText primary="Table Name" />
            </ListItemIcon>
            <ListItemText
              style={{ float: "right" }}
              primary={" : " + props.StateTagGroup.TagGroup.TagTableName}
            />
          </ListItem>
          <ListItem button>
            <ListItemIcon style={{ width: "35%" }}>
              <ListItemText primary="Server" />
            </ListItemIcon>
            <ListItemText
              style={{ float: "right" }}
              primary={" : " + props.StateTagGroup.TagGroup.TagGroupServer}
            />
          </ListItem>
          <ListItem button>
            <ListItemIcon style={{ width: "35%" }}>
              <ListItemText primary="Description " />
            </ListItemIcon>
            <ListItemText
              style={{ float: "right" }}
              primary={" : " + props.StateTagGroup.TagGroup.Description}
            />
          </ListItem>
          <ListItem button>
            <ListItemIcon style={{ width: "35%" }}>
              <ListItemText primary="Status " />
            </ListItemIcon>
            :&nbsp;
            {props.StateTagGroup.TagGroup.Status ? (
              <Chip label={"ON"} className={classes.success} />
            ) : (
              <Chip label={"OFF"} className={classes.danger} />
            )}
          </ListItem>
        </List>
      </div>
    </Box>
  );
}

const mapStateToProps = (state) => {
  return {
    StateTagGroup: state.state_tag_group,
    auth: state.auth,
  };
};

const mapDispatchToProps = (dispatch ) => {
  return {
    SetStateTagGroup: (p) => dispatch(setTagGroup(p)),
    SetStateTagGroupTags: (p) => dispatch(setTagGroupTags(p)),
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(TagGroupDesc);