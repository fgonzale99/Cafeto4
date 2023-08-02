import React, { useEffect, useState, useRef  } from 'react';
import ReactDOM from 'react-dom';

import crudServices from "../crud/Services"
import moduleServices from "../general/services/Module"
import reviewServices from "../review/Services"

import Column from "../../components/general/Column"
import Row from "../../components/general/Row"
import Card from "../../components/general/Card"
import Modal from "../../components/general/Modal"
import Stepper from "../../components/general/Stepper"
import List from "../../components/general/List"
import Form from "../../components/forms/Form"
import Header from "../../components/general/Header"

import Button from "../../components/general/Button"


class Editassign extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      moduleData: {name: 'evaluacionAsignarEvaluador', id: this.props.match.params.id},
      dataForm: {
        action: '',
        method: 'POST',
        enctype: 'multipart/form-data',
        id: 'formEdit',
        formRef: React.createRef(),
        fields: [],
        formValues: [],
      },
      modalIsOpen: false,
    }
  }

  async componentDidMount(){
    try{
        const moduleData = await crudServices.getModule(this.state.moduleData);

        if(moduleData.success == true){
          this.state.moduleData.model = moduleData.data.model;
          const res = await crudServices.get(this.state.moduleData);

          this.state.moduleData.fields = moduleData.data.fields.filter(e => e.edit === true);
          this.state.moduleData.values = res.data;
          this.state.moduleData.actions = moduleData.data.actions;
          this.state.moduleData.props = moduleData.data.props;
          this.state.moduleData.name = this.props.match.params.module;

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

  async saveEdit(e) {
    e.preventDefault()
      const form = document.getElementById("formEdit");
      const data = new FormData(form);
      const res = await crudServices.update(data, this.state.moduleData);

      if (res.success) {
        var redirect = '/review/list?message=updated';
        window.location.href = redirect;
      }
      else {
        alert(res.message)
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
        label: 'Evaluaciones',
        active: '',
        link: '/review/list',
      },
      {
        label: 'Editar',
        active: 'active',
        link: '#',
      }
    ];

    const headerContent = {
      title: 'Editar Asignación',
      breadcrumb: breadData,
    };

    const headerElement = <Header data={ headerContent }/>;
    header.push(headerElement);

    this.state.dataForm.fields = this.state.moduleData.fields;
    this.state.dataForm.formValues = this.state.moduleData.values;

    const form = <Form data={ this.state.dataForm } onSubmit={ this.saveEdit.bind(this) } />;

    const footer = "";

    this.data = {
      header: {
        title: "Editar " + this.state.moduleData.props.label.singular,
      },
      body: form,
      footer: footer,
    };

    const card = <Card data={ this.data } />

    const columnData = {
        class: 'col-lg-8 col-8 offset-md-2',
        content: card,
      };

    const column = <Column data={ columnData } />
    content.push(column);

    return (
      <>
        <Row content={ header }/>
        <Row content={ content }/>
      </>
    )


  }
}

export default Editassign;
