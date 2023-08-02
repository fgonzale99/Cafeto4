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
import Display from "../../components/general/Display"

import Button from "../../components/general/Button"


class PaymentEnable extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      moduleData: {name: 'habilitarCuenta', id: this.props.match.params.id},
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

          const reviewData = await reviewServices.getReviewInfo(this.props.match.params.id);

          this.setState({ reviewData: { fields: moduleData.data.fields.filter(e => e.show === true),
            values: reviewData.data }
          });

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

  async paymentCancel(e) {
    e.preventDefault()
    var redirect = '/review/list';
    window.location.href = redirect;
  }

  async paymentSend(e) {
    e.preventDefault()
    const res = await reviewServices.paymenSend(this.props.match.params.id);
    if(res.success == true){
      alert('Se habilito el pago correctamente.');
      var redirect = '/review/list';
      window.location.href = redirect;
    }else{
      alert(res.message);
    }

  }

  render() {

    var header = [];
    var content = [];
    var footer = [];

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
        label: 'Cuenta de Cobro',
        active: 'active',
        link: '#',
      }
    ];

    const headerContent = {
      title: 'Cuenta de Cobro',
      breadcrumb: breadData,
    };

    const headerElement = <Header data={ headerContent }/>;
    header.push(headerElement);

    var dataStepper = [
      {
        id: 'new',
        value: '<',
        label: 'Verificar Datos',
        withLine: true,
        active: '',
        link: '/user/profile/edit'
      },
      {
        id: 'documents',
        value: '>',
        label: 'Cuenta de Cobro',
        withLine: false,
        active: 'active',
        link: '#'
      }
    ]

    const stepper = <Stepper data = { dataStepper } />;
    content.push(stepper);

    this.state.content = {
        fields: this.state.moduleData.fields,
        data: this.state.moduleData.values,
        actions: this.state.moduleData.actions.filter(e => e.list === true),
        onDelete: this.onDelete,
    };

    const table = <Display content={this.state.content}/>;

    var footer = [];

    if(this.state.reviewData.values.paymentState=='Inactivo'){

      var submitButton = <Button type="submit" text="Enviar" className="btn-success" align="justify-content-center" onClick={ this.paymentSend.bind(this) } />;
      footer.push(submitButton);

    }

    this.data = {
      header: {
        title: "Habilitar Cuenta de Cobro",
      },
      body: table,
      footer: footer,
    };

    const card = <Card data={ this.data } />
    content.push(card);

    const columnData = {
        class: 'col-lg-8 col-8 offset-md-2',
        content: content,
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

export default PaymentEnable;
