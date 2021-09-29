import {
  Box,
  makeStyles,
  TableContainer,
  Table,
  TableHead,
  TableRow,
  TableCell,
  TableBody,
  Paper,
  Button,
  Typography,
  Chip,
} from "@material-ui/core";
import { Link, withRouter } from "react-router-dom";
import { setTagGroupTags } from "../../../redux/TagGroups/tagGroups.action";

import { connect } from "react-redux";
import TagServices from "./TagServicesClass";
import TagGroupServices from "./TagGroupServicesClass";

const TagGroupServ = new TagGroupServices();

const tagServ = new TagServices();

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

function TagGroupTags(props) {
  const classes = useStyles();

  async function handleClick(id) {
    const resp = await tagServ.delete(id);
    if (resp.success) {
      alert(resp.message);
      getOne(props.match.params.id);
    } else {
      alert(resp.message);
    }
  }

  async function getOne(id) {
    const resp = await TagGroupServ.findOne(id);
    props.SetStateTagGroupTags(resp.data.tags);
    console.log("GET ONE CALLED");
  }

  return (
    <Box boxShadow={3} p={2} style={{ background: "#ffffff" }}>
      <Typography variant="h5">Tags List</Typography>
      <Button
        variant="contained"
        component={Link}
        to={"/opc/tags/add/" + props.match.params.id}
        color={"primary"}
        style={{ float: "right" }}
      >
        Add Tag
      </Button>
      <TableContainer component={Paper}>
        <Table className={classes.table} aria-label="simple table">
          <TableHead>
            <TableRow>
              <TableCell align="left">No</TableCell>
              <TableCell>Column Name</TableCell>
              <TableCell align="left">Tag Address</TableCell>
              <TableCell align="left">Status</TableCell>
              <TableCell align="left">Static Value</TableCell>
              <TableCell align="left">Action</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {props.StateTagGroup.TagGroupTags.length > 0 ? (
              props.StateTagGroup.TagGroupTags.map((tag, i) => (
                <TableRow key={i}>
                  <TableCell align="left">{i + 1}</TableCell>
                  <TableCell component="th" scope="row">
                    {tag.ColumnName}
                  </TableCell>
                  <TableCell align="left">{tag.TagAddress}</TableCell>
                  <TableCell align="left">
                    {tag.Status === true ? (
                      <Chip
                        size="small"
                        label={"enable"}
                        className={classes.success}
                      />
                    ) : (
                      <Chip
                        size="small"
                        label={"disable"}
                        className={classes.danger}
                      />
                    )}
                  </TableCell>
                  <TableCell align="left">{tag.StaticValue}</TableCell>
                  <TableCell align="left">
                    <Box>
                      <Button
                        component={Link}
                        to={"/opc/tags/edit/" + tag.id}
                        variant="contained"
                        size="small"
                        style={{ marginRight: "8px" }}
                      >
                        Edit
                      </Button>
                      <Button
                        variant="contained"
                        size="small"
                        onClick={(e) => {
                          if (window.confirm("Delete Tag ?")) {
                            handleClick(tag.id, e);
                          }
                        }}
                      >
                        Delete
                      </Button>
                    </Box>
                  </TableCell>
                </TableRow>
              ))
            ) : (
              <TableRow>
                
              </TableRow>
            )}
          </TableBody>
        </Table>
      </TableContainer>
    </Box>
  );
}

const mapStateToProps = (state) => {
  return {
    StateTagGroup: state.state_tag_group,
  };
};

const mapDispatchToProps = (dispatch) => {
  return {
    SetStateTagGroupTags: (p) => dispatch(setTagGroupTags(p)),
  };
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(TagGroupTags));
