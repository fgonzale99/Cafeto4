import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import Breadcrum from "../components/general/Breadcrum"
import New from "./process/crud/New"
import List from "./process/crud/List"
import Edit from "./process/crud/Edit"
import Show from "./process/crud/Show"

import {
  BrowserRouter as Router,
  Switch,
  Route,
  Link
} from "react-router-dom";

const moduleInfo = {name: 'proceso', title: 'Procesos', }

function Process(){
  return (
    <Router>
      <main>
        <Switch>
          <Route path="/process/list">
            <List moduleInfo={ moduleInfo } />
          </Route>
          <Route path="/process/new">
            <New moduleInfo={ moduleInfo } />
          </Route>
          <Route path="/process/edit/:id">
            <New moduleInfo={ moduleInfo } />
          </Route>
          <Route path="/process/show/:id">
            <Show moduleInfo={ moduleInfo } />
          </Route>
        </Switch>
      </main>
    </Router>
  )
}

export default Process;
// for <div id="main-employee"></div>
ReactDOM.render(<Process moduleInfo={ moduleInfo }/>, document.getElementById('main-app'));

function Header(){
  return (
    <div className="row mb-2">
        <div className="col-sm-6">
          <h1>{ moduleInfo.title }</h1>
        </div>
        <div className="col-sm-6">
          <Breadcrum />
        </div>
      </div>
  )
}
ReactDOM.render(<Header />, document.getElementById('content-header'));
