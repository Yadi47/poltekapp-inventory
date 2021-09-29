import Grid from "@material-ui/core/Grid";
import Card from "@material-ui/core/Card";
import CardContent from "@material-ui/core/CardContent";
import {
  CardHeader,
  Box,
  List,
  ListItem,
  ListItemIcon,
  ListItemText,
} from "@material-ui/core";

import { useEffect, useState } from "react";
import TagGroupServices from "../TagGroups/TagGroupServicesClass";
import { makeStyles } from "@material-ui/core/styles";
import OpcRealtimeValues from "./OpcRealtimeValues";
import { connect } from "react-redux";
import {setSelectedRealtime,setRealtime} from '../../../redux/Realtime/realtime.actions'
const TagGroupServ = new TagGroupServices();

const useStyles = makeStyles((theme) => ({
  root: {
    minWidth: 275,
  },
  bullet: {
    display: "inline-block",
    margin: "0 2px",
    transform: "scale(0.8)",
  },
  title: {
    fontSize: 14,
  },
  pos: {
    marginBottom: 12,
  },
  header: {
    background: "#F6F6F6",
  },
}));

function OpcRealtimeListGroup(props) {
  const [TagGroups, setTagGroups] = useState([]);
  const [TagGroupSelected, setTagGroupSelected] = useState(1);
  const classes = useStyles();
  useEffect(() => {
    getTagGroups();
  }, []);

  async function getTagGroups() {
    const resp = await TagGroupServ.getAll();
    setTagGroups(resp.data);
    props.setRealtimeSelected(resp.data[0]);
    setTagGroupSelected(resp.data[0].id);
  }

  async function tgSelected(id) {
    props.setRealtimeSelected(id);
    props.setRealtime([]);
  }

  return (
    <Grid container spacing={1}>
      <Grid item xl={3} lg={3} xs={12}>
        <Box borderRadius={4}>
          <Card className={classes.root} style={{ borderRadius: "20px" }}>
            <CardHeader
              className={classes.header}
              component="div"
              title={"Group List"}
            ></CardHeader>
            <CardContent>
              <Box width={"100%"}>
                <List component="nav" aria-label="">
                  {TagGroups.map((TagGroup, i) => (
                    <ListItem
                      button
                      key={i}
                      onClick={(e) => {
                        tgSelected(TagGroup);
                      }}
                    >
                      <ListItemIcon>
                        <ListItemText
                          primary={i + 1 + ". " + TagGroup.TagGroupName}
                        />
                      </ListItemIcon>
                      <ListItemText primary="" style={{ float: "right" }} />
                    </ListItem>
                  ))}
                </List>
              </Box>
            </CardContent>
          </Card>
        </Box>
      </Grid>
      <Grid item xl={12} lg={12} xs={12}>
        <Box borderRadius={4}>
          <Card className={classes.root} style={{ borderRadius: "20px" }}>
            {/* <CardHeader
              className={classes.header}
              component="div"
              title={"Value"}
            ></CardHeader> */}
            <CardContent>
              <Box width={"100%"}>
                <OpcRealtimeValues id={TagGroupSelected}></OpcRealtimeValues>
              </Box>
            </CardContent>
          </Card>
        </Box>
      </Grid>
    </Grid>
  );
}

const mapDispatchToProps = dispatch =>{
    return {
      setRealtime: (p) => dispatch(setRealtime(p)),
      setRealtimeSelected: (p) => dispatch(setSelectedRealtime(p)),
    };
}

export default connect(null, mapDispatchToProps)(OpcRealtimeListGroup);