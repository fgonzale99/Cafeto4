import React, { Component, Suspense, lazy  } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Switch, Route, Link} from "react-router-dom";

import Breadcrum from "../components/general/Breadcrum"

const List = lazy(() => import('../components/crud/List'));
const New = lazy(() => import('../components/crud/New'));
const Edit = lazy(() => import('../components/crud/Edit'));
const Show = lazy(() => import('../components/crud/Show'));

const CustomerDashboard = lazy(() => import('./customer/dashboard/Dashboard'));

const moduleInfo = {name: 'cliente', title: 'Clientes', }

function Cafeto(){
  return (
    <Router>
      <main>
        <Suspense fallback={<div>Cafeto...</div>}>
          <Switch>

            <Route path="/customer/list" component={ List } />
            <Route path="/customer/new" component={ New } />
            <Route path="/customer/edit/:id" component={ Edit } />
            <Route path="/customer/show/:id" component={ Show } />

            <Route path="/customer/dashboard" component={ CustomerDashboard } />
          </Switch>
        </Suspense>
      </main>
    </Router>
  )
}

export default Cafeto;
// for <div id="main-employee"></div>
ReactDOM.render(<Cafeto moduleInfo={ moduleInfo }/>, document.getElementById('main-app'));

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
