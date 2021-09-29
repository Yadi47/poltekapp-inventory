import React from 'react'
import Typography from "@material-ui/core/Typography";

export default function PageTitle(props){
    return (
      <Typography variant="h5" paragraph>
        {props.pageTitle}
      </Typography>
    );
}