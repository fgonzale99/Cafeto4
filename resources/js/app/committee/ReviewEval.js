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
import Form from "../../components/forms/Form"
import Header from "../../components/general/Header"

import Button from "../../components/general/Button"


class ReviewEval extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      moduleData: {name: 'comiteRevision', id: this.props.match.params.id},
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
          console.log(res);

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

    async saveEval(e) {
      e.preventDefault()
        const form = document.getElementById("formEdit");
        const data = new FormData(form);
        const res = await reviewServices.auditSave(data, this.state.moduleData);

        if (res.success) {
          var redirect = '/committee/review/list';
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

    var header = [];

    if (this.state.isLoading) {
      return <div className="App">Cargando...</div>;
    }

    this.state.dataForm.fields = this.state.moduleData.fields;
    this.state.dataForm.formValues = this.state.moduleData.values;

    const form = <Form data={ this.state.dataForm } onSubmit={ this.saveEval.bind(this) } />;

    const footer = "";

    const data = {
      header: {
        title: this.state.moduleData.props.label.singular,
        actions: [{"name":"show","title":"Ver Evaluación","type":"link","link":"/committee/summary/" + this.state.moduleData.values.review, "target": "_blank", "class": "btn bg-gradient-info btn-sm","list":"false","header":"true","element":"false"},{"name":"show","title":"Ver Evaluador","type":"link","link":"/committee/reviewer/" + this.state.moduleData.values.review, "target": "_blank", "class": "btn bg-gradient-success btn-sm","list":"false","header":"true","element":"false"}],

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

    const breadData = [
      {
        label: 'Inicio',
        active: '',
        link: '/',
      },
      {
        label: 'Revisiones',
        active: '',
        link: '/committee/review/list',
      },
      {
        label: this.state.moduleData.props.label.plural,
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

    return (
      <>
        <Row content={ header }/>
        <Row content={ this.column } />
      </>
    )
  }
}

export default ReviewEval;
