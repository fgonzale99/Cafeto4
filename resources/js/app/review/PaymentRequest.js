import React, { useEffect, useState, useRef  } from 'react';

import crudServices from "../../app/crud/Services"
import moduleServices from "../../app/general/services/Module"
import reviewServices from "../review/Services"

import Column from "../../components/general/Column"
import Row from "../../components/general/Row"
import Card from "../../components/general/Card"
import Displaycolumns from "../../components/general/Displaycolumns"
import Button from "../../components/general/Button"
import Header from "../../components/general/Header"
import Stepper from "../../components/general/Stepper"


class PaymentProfile extends React.Component {

    constructor(props) {
      super(props);

      this.state = {
        isLoading: true,
        error: '',
        elementsList: [],
        moduleData: {name: 'habilitarcuenta', id: this.props.match.params.id},
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

    async paymentSend(e) {
      e.preventDefault()
      const res = await reviewServices.paymenSend(this.props.match.params.id);
      if(res.success == true){
        alert('Se habilito el pago correctamente.');
        var redirect = '/reviewer/projects';
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
          active: '',
          link: '/review/payment/profile/' + this.props.match.params.id
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
          actions: [{"name":"edit","title":"Editar","type":"link","link":"/crud/modulos/edit/","class":"btn bg-gradient-primary btn-sm","list":"true","header":"false","element":"true"}],
          onDelete: this.onDelete,
      };

      const table = <Displaycolumns content={this.state.content} />;

      var submitButton = <Button type="submit" text="Enviar Cuenta" className="btn-success" align="justify-content-center" onClick={ this.paymentSend.bind(this) }  />;
      footer.push(submitButton);

      const data = {
        header: {
          title: "Datos de la Evaluación",
          name: this.state.moduleData.name,
          actions: [{"name":"download","title":"Cuenta de Cobro","type":"link","link":"/review/payment/receipt/" + this.props.match.params.id,"target":"_blank","class":"btn bg-gradient-info btn-sm","list":"true","header":"false","element":"true"}],
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
