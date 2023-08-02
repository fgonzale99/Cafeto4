import React, { useEffect, useState, useRef  } from 'react';

import crudServices from "../../app/crud/Services"
import moduleServices from "../../app/general/services/Module"

import Column from "../../components/general/Column"
import Row from "../../components/general/Row"
import Card from "../../components/general/Card"
import Display from "../../components/general/Display"
import Button from "../../components/general/Button"
import Header from "../../components/general/Header"
import Stepper from "../../components/general/Stepper"
import Alert from "../../components/general/Alert"


class PaymentProfile extends React.Component {

    constructor(props) {
      super(props);

      this.state = {
        isLoading: true,
        error: '',
        elementsList: [],
        moduleData: {name: 'usuarioPerfil'},
        content: [],
        modalIsOpen: false,
      }
    }

    async componentDidMount() {
      try{
          const moduleData = await crudServices.getModule(this.state.moduleData);

          if(moduleData.success == true){
            this.state.moduleData.model = moduleData.data.model;
            const res = await crudServices.getUserCurrent();

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

    profileEdit(e) {
      e.preventDefault()
      var redirect = '/user/profile/edit';
      window.location.href = redirect;
    }

    paymentRequest(e) {
      e.preventDefault()
      var redirect = '/review/payment/request/' + this.props.match.params.id;
      window.location.href = redirect;
    }

    render() {

      var header = [];
      var content = [];
      var footer = [];
      var datosCompletos = true;

      if (this.state.isLoading) {
        return <div className="App">Cargando...</div>;
      }

      this.state.moduleData.fields.map((field,i)=>{
          if(!this.state.moduleData.values[field.name] && field.type != "file"){
            datosCompletos = false;
          }
      })

      console.log(this.state.moduleData.values);
      if(this.state.moduleData.values.documentsCompleted==0){
        datosCompletos = false;
      }

      const breadData = [
        {
          label: 'Inicio',
          active: '',
          link: '/',
        },
        {
          label: 'Actualizar Datos',
          active: 'active',
          link: '#',
        }
      ];

      const headerContent = {
        title: 'Datos Para Pago',
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
          active: 'active',
          link: '#'
        },
        {
          id: 'documents',
          value: '>',
          label: 'Cuenta de Cobro',
          withLine: false,
          active: '',
          link: '#'
        }
      ]

      const stepper = <Stepper data = { dataStepper } />;
      content.push(stepper);

      const alert = <Alert data={ "payment" }/>;
      if (!datosCompletos) {
        content.push(alert);
      }

      this.state.content = {
          fields: this.state.moduleData.fields,
          data: this.state.moduleData.values,
          actions: this.state.moduleData.actions.filter(e => e.list === true),
          onDelete: this.onDelete,
      };

      const table = <Display content={this.state.content} />;

      if(datosCompletos){
        var submitButton = <Button type="submit" text="Continuar" className="btn-success" align="justify-content-center" onClick={ this.paymentRequest.bind(this) } />;
        footer.push(submitButton);
      }else{
        var submitButton = <Button type="submit" text="Editar Datos" className="btn-info" align="justify-content-center" onClick={ this.profileEdit.bind(this) } />;
        footer.push(submitButton);
      }

      const data = {
        header: {
          title: "Verificar Datos",
          name: this.state.moduleData.name,
          actions: this.state.moduleData.actions.filter(e => e.element === true),
        },
        body: table,
        footer: footer
      };

      const card = <Card data={ data }/>

      content.push(card);

      const columnData = {
          class: 'col-lg-8 col-8 offset-md-2',
          content: content,
        };

      const columnContent = <Column data={ columnData }/>

      return (
        <>
          <Row content={ header }/>
          <Row content={ columnContent }/>
        </>
      )
    }
}

export default PaymentProfile;
