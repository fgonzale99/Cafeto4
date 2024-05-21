import React, { useEffect, useState, useRef  } from 'react';
import ReactDOM from 'react-dom';

import crudServices from "../../app/crud/Services"
import moduleServices from "../../app/general/services/Module"

import Column from "../../components/general/Column"
import Row from "../../components/general/Row"
import Card from "../../components/general/Card"
import Modal from "../../components/general/Modal"
import Stepper from "../../components/general/Stepper"
import Form from "../../components/forms/Form"
import Button from "../../components/general/Button"


class TopBudget extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      moduleData: {name: 'topesProceso', id: this.props.match.params.id},
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

          console.log(this.state.moduleData);

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
          var redirect = '/process/list?model=procesos';
          window.location.href = redirect;
        }
        else {
          alert(res.message)
        }
    }

    onCloseModal(e){
      this.setState({ modalIsOpen: false});
    }

    onOpenModal(e) {
      this.setState({ modalIsOpen: true});
    }

  render() {

    if (this.state.isLoading) {
      return <div className="App">Cargando...</div>;
    }

    this.state.dataForm.fields = this.state.moduleData.fields;
    this.state.dataForm.formValues = this.state.moduleData.values;

    const form = <Form data={ this.state.dataForm } onSubmit={ this.saveEdit.bind(this) } />;

    const footer = "";

    const data = {
      header: {
        title: this.state.moduleData.props.label.singular,
      },
      body: form,
      footer: footer,
    };

    const card = <Card data={ data }/>

    var content = [];

    content.push(card);

    const columnData = {
        class: 'col-lg-10 col-10 offset-md-1',
        content: content,
      };

    this.column = <Column data={ columnData }/>

    return (
      <>
        <Row content={ this.column } />
      </>
    )
  }
}

export default TopBudget;
