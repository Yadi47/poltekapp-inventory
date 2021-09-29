import React from "react";
import { useEffect } from "react";
import { makeStyles } from "@material-ui/core/styles";
import Table from "@material-ui/core/Table";
import TableBody from "@material-ui/core/TableBody";
import TableCell from "@material-ui/core/TableCell";
import TableContainer from "@material-ui/core/TableContainer";
import TableHead from "@material-ui/core/TableHead";
import TableRow from "@material-ui/core/TableRow";
import Paper from "@material-ui/core/Paper";
import { connect } from "react-redux";
import { Box, Typography } from "@material-ui/core";
const useStyles = makeStyles({
  table: {
    minWidth: 650,
  },
});

function DenseTable(props) {
  const classes = useStyles();
  useEffect(() => {
    return () => {};
  }, [props.realtimeValues]);
  return (
    <Box>
      <Typography style={{ marginBottom: "20px" }}>
        Content of '{props.realtimeSelected.TagGroupName}'
      </Typography>
      <TableContainer component={Paper}>
        <Table
          className={classes.table}
          size="small"
          aria-label="a dense table"
        >
          <TableHead>
            <TableRow>
              <TableCell>Tag Name</TableCell>
              <TableCell >Tag Address</TableCell>
              <TableCell >Value</TableCell>
              <TableCell >Quality</TableCell>
              <TableCell >TimeStamp</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {props.realtimeValues.map((row, i) => (
              <TableRow key={i}>
                <TableCell width="20%" style={{"fontSize":'13px'}} align="left">
                  {row.TagName}
                </TableCell>
                <TableCell width="25%" style={{"fontSize":'13px'}} align="left">
                  {row.TagAddress}
                </TableCell>
                <TableCell width="20%" style={{"fontSize":'13px'}} >
                  {row.TagValue}
                </TableCell>
                <TableCell width="10%" style={{"fontSize":'13px'}} >
                  {row.TagStatusRead}
                </TableCell>
                <TableCell width="25%" style={{"fontSize":'13px'}} >
                  {row.TagTstampOpc}
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </TableContainer>
    </Box>
  );
}
const mapStateToProps = (state) => {
  return {
    realtimeValues: state.state_realtime_values.values,
    realtimeSelected: state.state_realtime_values.selected,
  };
};
export default connect(mapStateToProps, null)(DenseTable);
