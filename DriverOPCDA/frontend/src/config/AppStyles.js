import { makeStyles } from "@material-ui/core/styles";

const drawerWidth = 240;
export default makeStyles((theme) => ({
    root: {
        display: 'flex',
    },
    drawer: {

        [theme.breakpoints.up('sm')]: {
            width: drawerWidth,
            flexShrink: 0,
        },
    },
    appBar: {
        
        [theme.breakpoints.up('sm')]: {
            width: `calc(100% - ${drawerWidth}px)`,
            marginLeft: drawerWidth,
        },
    },

    appBarToggled: {
        zIndex: theme.zIndex.drawer + 1,
        marginLeft: drawerWidth,
        transition: theme.transitions.create(['margin', 'width'], {
            easing: theme.transitions.easing.sharp,
            duration: theme.transitions.duration.enteringScreen,
        }),
    },
    menuButtonMobile: {
        marginRight: theme.spacing(2),
        [theme.breakpoints.up('sm')]: {
            display: 'none',
        },
    },
    menuButtonDesktop: {
        marginRight: theme.spacing(2),
        [theme.breakpoints.down('sm')]: {
            display: 'none',
        },
    },
    hide: {
        display: 'none',
    },
    // necessary for content to be below app bar
    toolbar: {

        display: 'flex',
        alignItems: 'center',
        justifyContent: 'flex-end',
        padding: theme.spacing(0, 1),
        // necessary for content to be below app bar
        ...theme.mixins.toolbar,
    },
    drawerPaper: {
        width: drawerWidth,
    },
    content: {
        width: '100%',
        padding: theme.spacing(3),
        marginLeft : -drawerWidth,
        marginTop: 80,
        transition: theme.transitions.create('margin', {
            easing: theme.transitions.easing.sharp,
            duration: theme.transitions.duration.leavingScreen,
        }),
    },
    contentToggle: {
        width:'100%',
        padding: theme.spacing(3),
        marginTop: 80,
        transition: theme.transitions.create('margin', {
            easing: theme.transitions.easing.easeOut,
            duration: theme.transitions.duration.enteringScreen,
        }),
        marginLeft: 0
    },
    logo: {
        maxWidth: 160,
    },
    fixedHeight: {
        height: 240,
    },
    baseLayout :  {
        background: '#e9e9e9',
        width: '100%' ,
        position: 'fixed',
        height: '100%' ,
        zIndex: - 9999,
    },
    
}));