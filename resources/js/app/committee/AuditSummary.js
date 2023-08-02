import React, { Component, useEffect, useState } from 'react';

import crudServices from "../../app/crud/Services"
import moduleServices from "../../app/general/services/Module"
import reviewServices from "../review/Services"


import Column from "../../components/general/Column"
import Row from "../../components/general/Row"
import Card from "../../components/general/Card"
import Displaycolumns from "../../components/general/Displaycolumns"
import Button from "../../components/general/Button"
import List from "../../components/general/List"
import Header from "../../components/general/Header"


class AuditShow extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      elementsList: [],
      moduleData: {name: 'comiteRevision', id: this.props.match.params.id},
      content: [],
      modalIsOpen: false,
    }

  }

  async componentDidMount() {
    try{
        const moduleData = await crudServices.getModule(this.state.moduleData);

        if(moduleData.success == true){
          this.state.moduleData.model = moduleData.data.model;
          const res = await reviewServices.getCommitteSummary(this.state.moduleData.id);

          this.state.moduleData.fields = moduleData.data.fields.filter(e => e.show === true);
          this.state.moduleData.values = res.data;
          this.state.moduleData.actions = moduleData.data.actions;
          this.state.moduleData.props = moduleData.data.props;

          if(res.success == true){
            this.setState({ isLoading: false });
          }
        }

    }
    catch (error){
        this.state.isLoading = false;
        this.state.error = error;
    }
  }

  render() {

    if (this.state.isLoading) {
      return <div className="App">Cargando...</div>;
    }

    var content = [];
    var header = [];

    this.state.content = {
        fields: this.state.moduleData.fields,
        data: this.state.moduleData.values,
        actions: this.state.moduleData.actions.filter(e => e.list === true),
        onDelete: this.onDelete,
    };

    const breadData = [
      {
        label: 'Inicio',
        active: '',
        link: '/',
      },
      {
        label: this.state.moduleData.props.label.plural,
        active: '',
        link: '/committee/review/list',
      },
      {
        label: 'Ficha',
        active: 'active',
        link: '#',
      },
    ];

    const headerContent = {
      title: this.state.moduleData.props.label.plural,
      breadcrumb: breadData,
    };

    const headerElement = <Header data={ headerContent }/>;
    header.push(headerElement);

    const table = <Displaycolumns content={this.state.content} />;

    const data = {
      header: {
        title: "Ficha de " + this.state.moduleData.props.label.singular,
        name: this.state.moduleData.name,
        actions: [{"name":"show","title":"Ver Evaluación","type":"link","link":"/committee/summary/" + this.state.moduleData.values.review, "target": "_blank", "class": "btn bg-gradient-info btn-sm","list":"false","header":"true","element":"false"},{"name":"show","title":"Ver Evaluador","type":"link","link":"/committee/reviewer/" + this.state.moduleData.values.review, "target": "_blank", "class": "btn bg-gradient-success btn-sm","list":"false","header":"true","element":"false"}],
      },
      body: table,
    };

    const card = <Card data={ data }/>

    var columnData = {
        class: 'col-lg-10 col-10 offset-md-1',
        content: card,
      };

    const column = <Column data={ columnData }/>

    content.push(column);


    columnData = {
        class: 'col-lg-10 col-10 offset-md-1',
        content: [],
      };

    const columnList = <Column data={ columnData }/>

    content.push(columnList);

    return (
      <>
        <Row content={ header }/>
        <Row content={ content }/>
      </>
    )
  }
}

export default AuditShow;
