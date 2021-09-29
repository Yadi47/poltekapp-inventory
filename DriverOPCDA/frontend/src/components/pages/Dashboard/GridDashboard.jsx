import Grid from "@material-ui/core/Grid";
import Card from "@material-ui/core/Card";
import CardContent from "@material-ui/core/CardContent";
import { CardHeader } from "@material-ui/core";

import Typography from "@material-ui/core/Typography";

import { makeStyles } from "@material-ui/core/styles";

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

export default function GridDashboard() {
    const classes = useStyles();

    return (
      <Grid container spacing={1}>
        <Grid item lg={4} xs={12}>
          <Card className={classes.root}>
            <CardHeader
              className={classes.header}
              component="div"
              title={"Total Tag"}
            ></CardHeader>
            <CardContent>
              <Typography
                variant="h2"
                color="primary"
                component="h3"
                className={classes.pos}
              >
                1<span style={{ fontSize: "25px", color: "#3EAA87" }}>(8)</span>
              </Typography>
              <Typography className={classes.pos} color="textSecondary">
                All Tag Groups & tags
              </Typography>
            </CardContent>
          </Card>
        </Grid>
        <Grid item lg={4} xs={12}>
          <Card className={classes.root}>
            <CardHeader
              className={classes.header}
              component="div"
              title={"Total User"}
            ></CardHeader>
            <CardContent>
              <Typography variant="h2" component="h3" className={classes.pos}>
                5
              </Typography>
              <Typography className={classes.pos} color="textSecondary">
                All Users
              </Typography>
            </CardContent>
          </Card>
        </Grid>
      </Grid>
    );
}