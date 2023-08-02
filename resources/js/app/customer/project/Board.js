import React, { Component, useEffect, useState } from 'react';

import crudServices from "../../../app/crud/Services"
import moduleServices from "../../../app/general/services/Module"
import reviewServices from "../../review/Services"


import Column from "../../../components/general/Column"
import Row from "../../../components/general/Row"
import Card from "../../../components/general/Card"
import Displaycolumns from "../../../components/general/Displaycolumns"
import Button from "../../../components/general/Button"
import List from "../../../components/general/List"
import Header from "../../../components/general/Header"


class Board extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      elementsList: [],
      moduleData: {name: 'clienteDocumentos', id: this.props.match.params.id},
      content: [],
      modalIsOpen: false,
    }

    this.onDelete = async (id) => {

      //this.setState({ modalIsOpen: true});
      var yes = confirm("Confirme si desea eliminar el elemento.");
      if (yes === true){

        const res = await reviewServices.delete(id);

        if (res.success) {
          alert("El cambio se solicito correctamente.");
        }
        else{
          alert(res.message);
        }
      }
    }

    this.reviewerChange = async (id) => {

      //this.setState({ modalIsOpen: true});
      var yes = confirm("Confirme si desea solicitar el cambio.");
      if (yes === true){

        const res = await reviewServices.reviewerChange(id);

        if (res.success) {
          alert("El cambio se solicito correctamente.");
        }
        else{
          alert(res.message);
        }
      }
    }

  }

  async componentDidMount() {
    try{
        const moduleData = await crudServices.getModule(this.state.moduleData);

        if(moduleData.success == true){
          this.state.moduleData.model = moduleData.data.model;
          const res = await crudServices.get(this.state.moduleData);

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
        reviewerChange: this.reviewerChange,
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
        link: '/customer/process/list',
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
        actions: this.state.moduleData.actions.filter(e => e.element === true),
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

    const listData = {
        module: 'clienteEvaluaciones',
        functions: { reviewerChange: this.reviewerChange },
        title: 'Unidades de Evaluación',
        prefilter: { 'project': this.props.match.params.id, 'state': 'Activo' },
        linkComplement: this.props.match.params.id,
    };

    //const column = <Column data={ columnData }/>
    const list = <List data={ listData }/>

    columnData = {
        class: 'col-lg-10 col-10 offset-md-1',
        content: list,
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

export default Board;
