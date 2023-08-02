import React, { useEffect, useState, useRef  } from 'react';

import crudServices from "../../app/crud/Services"
import moduleServices from "../../app/general/services/Module"

import Column from "../../components/general/Column"
import Row from "../../components/general/Row"
import Card from "../../components/general/Card"
import Display from "../../components/general/Display"
import Button from "../../components/general/Button"
import Header from "../../components/general/Header"

class Show extends React.Component {

    constructor(props) {
      super(props);

      this.state = {
        isLoading: true,
        error: '',
        elementsList: [],
        moduleData: {name: this.props.match.params.module, id: this.props.match.params.id},
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

      var header = [];
      var content = [];

      if (this.state.isLoading) {
        return <div className="App">Cargando...</div>;
      }

      const breadData = [
        {
          label: 'Inicio',
          active: '',
          link: '/',
        },
        {
          label: this.state.moduleData.props.label.plural,
          active: '',
          link: '/crud/' +  this.state.moduleData.name + '/list',
        },
        {
          label: 'Ficha',
          active: 'active',
          link: '#',
        }
      ];

      const headerContent = {
        title: this.state.moduleData.props.label.plural,
        breadcrumb: breadData,
      };

      const headerElement = <Header data={ headerContent }/>;
      header.push(headerElement);

      this.state.content = {
          fields: this.state.moduleData.fields,
          data: this.state.moduleData.values,
          actions: this.state.moduleData.actions.filter(e => e.list === true),
          onDelete: this.onDelete,
      };

      const table = <Display content={this.state.content} />;

      const data = {
        header: {
          title: "Ficha de " + this.state.moduleData.props.label.singular,
          name: this.state.moduleData.name,
          actions: this.state.moduleData.actions.filter(e => e.element === true),
        },
        body: table,
      };

      const card = <Card data={ data }/>

      const columnData = {
          class: 'col-lg-8 col-8 offset-md-2',
          content: card,
        };

      const column = <Column data={ columnData }/>

      content.push(column);

      return (
        <>
          <Row content={ header }/>
          <Row content={ content }/>
        </>
      )
    }
}

export default Show;
