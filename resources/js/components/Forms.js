import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import Nav from "./Nav"
import New from "./form/New"
import List from "./form/List"

import {
  BrowserRouter as Router,
  Switch,
  Route
} from "react-router-dom";

function Customers(){
  return (
    <Router>
      <main>
        <Nav/>
        <Switch>
          <Route path="/form/crud" exact component={List} />
          <Route path="/form/new"  component={New} />
        </Switch>
      </main>
    </Router>
  )
}

export default Customers;
// for <div id="main-employee"></div>
ReactDOM.render(<Customers />, document.getElementById('main-customer'));
