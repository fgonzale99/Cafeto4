import React, { useEffect, useState, useRef } from 'react';
import ReactDOM from 'react-dom';

import crudServices from "../crud/Services"
import moduleServices from "../general/services/Module"

import Column from "../../components/general/Column"
import Row from "../../components/general/Row"
import Card from "../../components/general/Card"
import Modal from "../../components/general/Modal"
import Stepper from "../../components/general/Stepper"
import Form from "../../components/forms/Form"

import Button from "../../components/general/Button"


class New extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      moduleData: { name: 'proyectos' },
      dataForm: {
        action: '',
        method: 'POST',
        enctype: 'multipart/form-data',
        id: 'formNew',
        formRef: React.createRef(),
        fields: [],
        formValues: [],
      },
      modalIsOpen: false,
    }

  }

  async componentDidMount() {
    try {
      const moduleData = await crudServices.getModule(this.state.moduleData);
      if (moduleData.success == true) {
        this.setState({
          moduleData: {
            model: moduleData.data.model,
            fields: moduleData.data.fields.filter(e => e.new === true),
            actions: moduleData.data.actions,
            props: moduleData.data.props
          }
        });

        this.setState({ isLoading: false });
      }
    }
    catch (error) {
      this.setState({ isLoading: false });
      this.setState({ error: error });
    }
  }


  async saveNew(e) {
    e.preventDefault()
    const form = document.getElementById("formNew");
    const data = new FormData(form);
    //crud service para verificar si proceso ya tiene un formulario distinto
    const uniqueForm = await crudServices.uniqueForm(data.get("process"), data.get("formReview"));
    if (uniqueForm == 0) {
      const res = await crudServices.save(data, this.state.moduleData);

      if (res.success) {
        var idElement = res.data.id;
        var redirect = '/project/reviewer/' + idElement;
        window.location.href = redirect;
      }
      else {
        alert(res.message)
      }
    }
    else {
      alert('Ya existe un formulario distinto asignado en ese proceso.');
    }

  }

  onCloseModal(e) {
    this.setState({ modalIsOpen: false });
  }

  onOpenModal(e) {
    this.setState({ modalIsOpen: true });
  }

  render() {

    if (this.state.isLoading) {
      return <div className="App">Cargando...</div>;
    }

    this.state.dataForm.fields = this.state.moduleData.fields;

    const form = <Form data={this.state.dataForm} onSubmit={this.saveNew.bind(this)} />;

    const footer = "";

    const data = {
      header: {
        title: "Nuevo " + this.state.moduleData.props.label.singular,
      },
      body: form,
      footer: footer,
    };

    const card = <Card data={data} />

    var content = [];

    var dataStepper = [
      {
        id: 'new',
        value: '1',
        label: 'Información Proyecto',
        withLine: true,
        active: 'active',
      },
      {
        id: 'reviewer',
        value: '2',
        label: 'Asignar Evaluador',
        withLine: false,
        active: '',
      }
    ]


    const stepper = <Stepper data={dataStepper} />;

    content.push(stepper);
    content.push(card);

    const columnData = {
      class: 'col-lg-10 col-10 offset-md-1',
      content: content,
    };

    this.column = <Column data={columnData} />

    return (
      <>
        <Row content={this.column} />
      </>
    )
  }
}

export default New;
