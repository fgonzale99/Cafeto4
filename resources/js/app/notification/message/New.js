import React, { useEffect, useState, useRef  } from 'react';
import ReactDOM from 'react-dom';
import Redirect from "react-router-dom";


import crudServices from "../../../app/crud/Services"
import notificationServices from "../../../app/notification/Services"

import Column from "../../../components/general/Column"
import Row from "../../../components/general/Row"
import Card from "../../../components/general/Card"
import Modal from "../../../components/general/Modal"
import Form from "../../../components/forms/Form"
import Header from "../../../components/general/Header"
import Button from "../../../components/general/Button"

class New extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      moduleData: {name: 'mensajes', id: this.props.match.params.id },
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
      message: false
    }

  }

  async componentDidMount() {
    try{
      const moduleData = await crudServices.getModule(this.state.moduleData);
      if(moduleData.success == true){
        this.setState({ moduleData: {
            model: moduleData.data.model,
            fields: moduleData.data.fields.filter(e => e.new === true),
            actions: moduleData.data.actions,
            props: moduleData.data.props,
            name: 'mensajes',
            id: this.props.match.params.id
          }
        });

        this.setState({ isLoading: false });
      }
    }
    catch (error){
      this.setState({ isLoading: false});
      this.setState({ error: error});
    }
  }


    async saveNew(e) {
      e.preventDefault()
        /*$(".fb-editor :input").attr("disabled", "disabled");*/

        $(".fb-editor :input").each(function() {
          $(this).attr("disabled", "disabled");
        });
        const form = document.getElementById("formNew");
        const data = new FormData(form);
        const res = await notificationServices.messageSave(data, this.state.moduleData);

        if (res.success) {
          var redirect = '/notification/board/' + this.state.moduleData.id + '?message=updated';
          window.location.href = redirect;
        } else {
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
        link: '/mensajes/' +  this.state.moduleData.name + '/list',
      },
      {
        label: 'Nuevo',
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

    this.state.dataForm.fields = this.state.moduleData.fields;

    const form = <Form data={ this.state.dataForm } onSubmit={ this.saveNew.bind(this) } />;

    const footer = "";

    const data = {
      header: {
        title: "Nuevo " + this.state.moduleData.props.label.singular,
      },
      body: form,
      footer: footer,
    };

    const card = <Card data={ data }/>

    const columnData = {
        class: 'col-lg-10 col-10 offset-md-1',
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

export default New;
