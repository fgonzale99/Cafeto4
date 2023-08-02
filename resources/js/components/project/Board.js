import React, { Component, useEffect, useState } from 'react';

import crudServices from "../../app/crud/Services"
import moduleServices from "../../app/general/services/Module"

import Column from "../../components/general/Column"
import Row from "../../components/general/Row"
import Card from "../../components/general/Card"
import Displaycolumns from "../../components/general/Displaycolumns"
import Button from "../../components/general/Button"


class Board extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      elementsList: [],
      moduleData: {name: 'proyectos', id: this.props.match.params.id},
      content: [],
      modalIsOpen: false,
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

    this.state.content = {
        fields: this.state.moduleData.fields,
        data: this.state.moduleData.values,
        actions: this.state.moduleData.actions.filter(e => e.list === "true"),
        onDelete: this.onDelete,
    };

    const table = <Displaycolumns content={this.state.content} />;

    const data = {
      header: {
        title: "Ficha de " + this.state.moduleData.props.label.singular,
        name: this.state.moduleData.name,
        actions: this.state.moduleData.actions.filter(e => e.element === "true"),
      },
      body: table,
    };

    const card = <Card data={ data }/>

    const columnData = {
        class: 'col-lg-10 col-10 offset-md-1',
        content: card,
      };

    const column = <Column data={ columnData }/>

    return (
      <Row content={ column }/>
    )
  }
}

export default Board;
