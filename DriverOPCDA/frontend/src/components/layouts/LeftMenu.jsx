import React from "react";
import List from "@material-ui/core/List";
import { NavLink } from "react-router-dom";
import * as Icon from "@material-ui/icons";

import MenuItem from "./MenuItem";
import MenuItemNested from "./MenuItemNested";


const subOpc = [
  {
    component: NavLink,
    link: "/opc/realtime",
    menu: "Realtime Value",
    icon: Icon.Speed,
  },
  {
    component: NavLink,
    link: "/opc/tag-groups",
    menu: "Tag Groups",
    icon: Icon.AccountTree,
  },
];

const subMasterData = [
  {
    component: NavLink,
    link: "/users",
    menu: "Users ",
    icon: Icon.SupervisorAccount,
  },
  {
    component: NavLink,
    link: "/roles",
    menu: "Roles ",
    icon: Icon.HowToReg,
  },
];

export default function LeftMenu() {
  let subOPC = subOpc;


  return (
    <List>
      <MenuItem
        component={NavLink}
        link="/dashboard"
        menu="Dashboard"
        icon={<Icon.Home />}
      />
      <MenuItemNested
        menu="OPC Server"
        icon={<Icon.Storage />}
        subMenu={subOPC}
      />
      {/* <MenuItemNested
        menu="Master Data"
        icon={<Icon.Folder />}
        subMenu={subMasterData}
      /> */}
      {/* <MenuItem
        component={NavLink}
        link="/users"
        menu="Users Management"
        icon={<Icon.SupervisorAccount />}
      />
      <MenuItem
        component={NavLink}
        link="/roles"
        menu="Roles Management"
        icon={<Icon.SupervisorAccount />}
      /> */}

      {/* <MenuItem
        component={NavLink}
        link="/logout"
        menu="Logout"
        icon={<Icon.ExitToApp />}
      /> */}
    </List>
  );
}
