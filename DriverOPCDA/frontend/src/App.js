import React from "react";
import { useEffect} from "react";
import {
  BrowserRouter as Router,
  Route,
  Switch
} from "react-router-dom";
import clsx from "clsx";
import { useTheme } from "@material-ui/core/styles";
import PropTypes from "prop-types";

import Drawer from "@material-ui/core/Drawer";
import AppBar from "@material-ui/core/AppBar";
import Toolbar from "@material-ui/core/Toolbar";
import CssBaseline from "@material-ui/core/CssBaseline";
import Typography from "@material-ui/core/Typography";
import Divider from "@material-ui/core/Divider";
import IconButton from "@material-ui/core/IconButton";
import Hidden from "@material-ui/core/Hidden";
import * as Icon from "@material-ui/icons";

import AppStyles from './config/AppStyles';
import logo from './assets/logo_groot.png'

// component
import LeftMenu from './components/layouts/LeftMenu'

// page
import PageDashboard from './components/pages/Dashboard'
import PageAdministrator from './components/pages/Administrator'

import PageUserManagement from './components/pages/UserManagement'
import PageUserAdd from "./components/pages/UserAdd";
import PageUserEdit from "./components/pages/UserEdit";

import PageRoleManagement from "./components/pages/RoleManagement";
import PageRoleAdd from "./components/pages/RoleAdd";
import PageRoleEdit from "./components/pages/RoleEdit";

import PageTagGroup from "./components/pages/TagGroup"
import PageTagGroupDetail from "./components/pages/TagGroupDetail"
import PageTagGroupAdd from "./components/pages/TagGroupAdd"
import PageTagGroupEdit from "./components/pages/TagGroupEdit"
import PageTagAdd from "./components/pages/TagAdd"
import PageTagEdit from "./components/pages/TagEdit"

import PageOpcRealtime from "./components/pages/OpcRealtime"

import PageLogin from "./components/pages/Login"


function App(props) {
  const theme = useTheme();
  const { window } = props;
  const classes = AppStyles();

  // --- toggle on mobile
  const [mobileOpen, setMobileOpen] = React.useState(false);
  const handleDrawerToggle = () => {
    setMobileOpen(!mobileOpen);
  };
  
  // --- toggle on desktop
  const [toggle, setToggle] = React.useState(true);
  const desktopToggle = () => {
    setToggle(!toggle);
  };
  
  useEffect(() => {
    console.log("BEGIN")
    return () => {
    };
  }, []);
  const container = window !== undefined ? () => window().document.body : undefined;
  
  

  return (

    
    <Router>
      <Switch>
        <Route
          exact
          path="/login"
          component={() => (
            <PageLogin></PageLogin>
          )}
        />
        <Route
          path="/"
          component={() => (
            <div className={classes.root}>
              <CssBaseline />
              <AppBar
                color="inherit"
                position="fixed"
                className={clsx(classes.appBarToggled, {
                  [classes.appBar]: toggle,
                })}
              >
                <Toolbar>
                  <IconButton
                    color="inherit"
                    aria-label="open drawer"
                    edge="start"
                    onClick={handleDrawerToggle}
                    className={classes.menuButtonMobile}
                  >
                    <Icon.Menu />
                  </IconButton>

                  <IconButton
                    color="inherit"
                    aria-label="open drawer"
                    edge="start"
                    onClick={desktopToggle}
                    className={classes.menuButtonDesktop}
                  >
                    <Icon.Menu />
                  </IconButton>
                  <Typography variant="h6" noWrap>
                    Tankvision Endress+Hauser
            </Typography>
                </Toolbar>
              </AppBar>
              <nav className={classes.drawer} aria-label="mailbox folders">
                {/* The implementation can be swapped with js to avoid SEO duplication of links. */}
                <Hidden smUp implementation="css">
                  <Drawer
                    container={container}
                    variant="temporary"
                    anchor={theme.direction === "rtl" ? "right" : "left"}
                    open={mobileOpen}
                    onClose={handleDrawerToggle}
                    classes={{
                      paper: classes.drawerPaper,
                    }}
                    ModalProps={{
                      keepMounted: true, // Better open performance on mobile.
                    }}
                  >
                    <Divider />
                    <LeftMenu />
                  </Drawer>
                </Hidden>
                <Hidden xsDown implementation="css">
                  <Drawer
                    classes={{
                      paper: classes.drawerPaper,
                    }}
                    variant="persistent"
                    anchor="left"
                    open={toggle}
                  >
                    <div className={classes.toolbar}>
                      <AppBar color="inherit">
                        <Toolbar>
                          <img src={logo} alt="logo" className={classes.logo} />
                        </Toolbar>
                      </AppBar>
                    </div>
                    <Divider />
                    <LeftMenu />
                  </Drawer>
                </Hidden>
              </nav>

              <div className={classes.baseLayout}></div>
              {/* MAIN CONTENT AREA */}
              <Switch>
                <Route
                  exact
                  path="/"
                  component={() => (
                    <PageDashboard
                      content={clsx(classes.content, {
                        [classes.contentToggle]: toggle,
                      })}
                      toolbar={classes.toolbar}
                    />
                  )}
                />
                <Route
                  exact
                  path="/dashboard"
                  component={() => (
                    <PageDashboard
                      content={clsx(classes.content, {
                        [classes.contentToggle]: toggle,
                      })}
                      toolbar={classes.toolbar}
                    />
                  )}
                />
                <Route
                  exact
                  path="/administrator"
                  component={() => (
                    <PageAdministrator
                      content={clsx(classes.content, {
                        [classes.contentToggle]: toggle,
                      })}
                      toolbar={classes.toolbar}
                    />
                  )}
                />

                {/* users route */}
                <Route
                  exact
                  path="/users"
                  component={() => (
                    <PageUserManagement
                      content={clsx(classes.content, {
                        [classes.contentToggle]: toggle,
                      })}
                      toolbar={classes.toolbar}
                    />
                  )}
                />
                <Route
                  exact
                  path="/users/add"
                  component={() => (
                    <PageUserAdd
                      content={clsx(classes.content, {
                        [classes.contentToggle]: toggle,
                      })}
                      toolbar={classes.toolbar}
                    />
                  )}
                />
                <Route
                  exact
                  path="/users/edit/:id"
                  component={() => (
                    <PageUserEdit
                      content={clsx(classes.content, {
                        [classes.contentToggle]: toggle,
                      })}
                      toolbar={classes.toolbar}
                    />
                  )}
                />

                {/* roles route */}
                <Route
                  exact
                  path="/roles"
                  component={() => (
                    <PageRoleManagement
                      content={clsx(classes.content, {
                        [classes.contentToggle]: toggle,
                      })}
                      toolbar={classes.toolbar}
                    />
                  )}
                />

                <Route
                  exact
                  path="/roles/add"
                  component={() => (
                    <PageRoleAdd
                      content={clsx(classes.content, {
                        [classes.contentToggle]: toggle,
                      })}
                      toolbar={classes.toolbar}
                    />
                  )}
                />

                <Route
                  exact
                  path="/roles/edit/:id"
                  component={() => (
                    <PageRoleEdit
                      content={clsx(classes.content, {
                        [classes.contentToggle]: toggle,
                      })}
                      toolbar={classes.toolbar}
                    />
                  )}
                />

                {/* tag groups route */}
                <Route
                  exact
                  path="/opc/tag-groups"
                  component={() => (
                    <PageTagGroup
                      content={clsx(classes.content, {
                        [classes.contentToggle]: toggle,
                      })}
                      toolbar={classes.toolbar}
                    />
                  )}
                />

                <Route
                  exact
                  path="/opc/tag-groups/detail/:id"
                  component={() => (
                    <PageTagGroupDetail
                      content={clsx(classes.content, {
                        [classes.contentToggle]: toggle,
                      })}
                      toolbar={classes.toolbar}
                    />
                  )}
                />
                <Route
                  exact
                  path="/opc/tag-groups/add"
                  component={() => (
                    <PageTagGroupAdd
                      content={clsx(classes.content, {
                        [classes.contentToggle]: toggle,
                      })}
                      toolbar={classes.toolbar}
                    />
                  )}
                />
                <Route
                  exact
                  path="/opc/tag-groups/edit/:id"
                  component={() => (
                    <PageTagGroupEdit
                      content={clsx(classes.content, {
                        [classes.contentToggle]: toggle,
                      })}
                      toolbar={classes.toolbar}
                    />
                  )}
                />

                {/* tags route */}
                <Route
                  exact
                  path="/opc/tags/add/:id"
                  component={() => (
                    <PageTagAdd
                      content={clsx(classes.content, {
                        [classes.contentToggle]: toggle,
                      })}
                      toolbar={classes.toolbar}
                    />
                  )}
                />
                <Route
                  exact
                  path="/opc/tags/edit/:id"
                  component={() => (
                    <PageTagEdit
                      content={clsx(classes.content, {
                        [classes.contentToggle]: toggle,
                      })}
                      toolbar={classes.toolbar}
                    />
                  )}
                />

                {/* OPC REALTIME ROUTE */}
                <Route
                  exact
                  path="/opc/realtime"
                  component={() => (
                    <PageOpcRealtime
                      content={clsx(classes.content, {
                        [classes.contentToggle]: toggle,
                      })}
                      toolbar={classes.toolbar}
                    />
                  )}
                />
              </Switch>
            </div>
          )}
        />
        </Switch>
      
    </Router>
  );
}

App.propTypes = {
  /**
   * Injected by the documentation to work in an iframe.
   * You won't need it on your project.
   */
  window: PropTypes.func,
};
export default App