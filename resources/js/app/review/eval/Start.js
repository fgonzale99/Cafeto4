import React, { useEffect, useState, useRef  } from 'react';

import crudServices from "../../crud/Services"
import moduleServices from "../../general/services/Module"
import reviewServices from "../../review/Services"


import Column from "../../../components/general/Column"
import Row from "../../../components/general/Row"
import Card from "../../../components/general/Card"
import Displaycolumns from "../../../components/general/Displaycolumns"
import Button from "../../../components/general/Button"
import Header from "../../../components/general/Header"
import Stepper from "../../../components/general/Stepper"
import Form from "../../../components/forms/Form"


class Start extends React.Component {

    constructor(props) {
      super(props);

      this.state = {
        isLoading: true,
        error: '',
        elementsList: [],
        moduleData: {name: 'evaluacionAceptar', id: this.props.match.params.id},
        content: [],
        modalIsOpen: false,
        projectData: [],
        pages: [],
        dataForm: {
          action: '',
          method: 'POST',
          enctype: 'multipart/form-data',
          id: 'formAccept',
          formRef: React.createRef(),
          fields: [],
          formValues: [],
          notDefaultButton: true,
        },
      }

      this.reviewDecline = async (id) => {

        //this.setState({ modalIsOpen: true});
        var yes = confirm("Confirme si desea rechazar la evaluación asignada.");
        if (yes === true){

          const res = await reviewServices.reviewDecline(this.state.moduleData.id);
          if (res.success) {
            var redirect = '/reviewer/projects?message=deleted';
            window.location.href = redirect;
          }else{
            alert(res.message);
          }
        }
      }

      this.Continue = async (id) => {
        var pages = this.state.pages;
        var nextPage = pages[0].page;
        var redirect = '/review/form/' + this.state.moduleData.id + '/' + nextPage;
        window.location.href = redirect;
      }
    }

    async componentDidMount() {

      try{
        const moduleData = await crudServices.getModule(this.state.moduleData);

        if(moduleData.success == true){

          this.setState({ moduleData: {
              model: moduleData.data.model,
              name: 'evaluacionAceptar',
              fields: moduleData.data.fields.filter(e => e.new === true),
              actions: moduleData.data.actions,
              props: moduleData.data.props,
              name: this.state.moduleData.name,
              id: this.props.match.params.id
            }
          });
          const res = await reviewServices.getReviewInfo(this.state.moduleData.id);

          var infoModule =  { name: 'proyectos', id: res.data.project, model: 'project' }
          const moduleProject = await crudServices.getModule(infoModule);
          const resProject = await crudServices.get(infoModule);

          if(resProject.success == true){

            var pagesList = await reviewServices.pagesList(resProject.data.get_formreview.id);
            if(pagesList.success == true){
                this.setState({ pages:  Object.values(pagesList.pages).filter(e => e.state === "active") });
            }

            this.setState({ reviewData: { fields: moduleData.data.fields.filter(e => e.show === true),
              values: res.data,
              props: moduleProject.data.prop }
            });

            if(this.state.projectData.values){
              this.setState({ isLoading: false });
            }

          }
        }
      }
      catch (error){
          this.state.isLoading = false;
          this.state.error = error;
      }
    }

    async startReview(e) {
      e.preventDefault()

      const form = document.getElementById("formAccept");
      const data = new FormData(form);
      const res = await crudServices.update(data, this.state.moduleData);

      if (res.success) {
        var pages = this.state.pages;
        var nextPage = pages[0].page;

        var reviewAccept = await reviewServices.reviewAccept(this.props.match.params.id);

        if (nextPage) {
          var redirect = '/review/form/' + this.state.moduleData.id + '/' + nextPage;
          window.location.href = redirect;
        } else {
          alert(res.message)
        }
      }
      else {
        alert(res.message)
      }

    }

    render() {

      var header = [];
      var content = [];
      var contentCard = [];
      const footer = [];

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
          link: '/reviewer/projects',
        },
        {
          label: 'Evaluación Documento',
          active: 'active',
          link: '#',
        }
      ];

      const headerContent = {
        title: 'Evaluación Documento',
        breadcrumb: breadData,
      };

      const headerElement = <Header data={ headerContent }/>;
      header.push(headerElement);

      var dataStepper = [];

      var step = {
        id: 0,
        value: '<',
        label: 'Inicio',
        withLine: true,
        active: 'active',
        link: '/review/start/' + this.state.moduleData.id
      }
      dataStepper.push(step);

      this.state.pages.map((item,i)=>{
        var active = ''
        if(item.page==this.state.moduleData.page) active = 'active';

        var step = {
          id: item.page,
          value: item.page,
          label: item.pageName,
          withLine: true,
          active: active,
          link: '/review/form/' + this.state.moduleData.id + '/' + item.page
        }
        dataStepper.push(step);
      })

      var step = {
        id: 1000,
        value: '>',
        label: 'Finalizar',
        withLine: false,
        active: '',
        link: '/review/finish/' + this.state.moduleData.id
      }
      dataStepper.push(step);

      const stepper = <Stepper data = { dataStepper } />;
      content.push(stepper);

      contentCard.push(<h3>Aceptar Términos y Condiciones</h3>);

      var displayContent = {
          fields: this.state.reviewData.fields,
          data: this.state.reviewData.values,
      };

      const display = <Displaycolumns content={ displayContent } />;
      contentCard.push(display);

      var processData = {
        fields:  [{
            "type": "select",
            "required": true,
            "label": "Proceso",
            "description": "Proceso",
            "placeholder": "Proceso",
            "className": "form-control",
            "name": "process",
            "access": false,
            "multiple": false,
            "list": true,
            "new": true,
            "edit": true,
            "filter": true,
            "show": true,
            "order": 0,
            "origin": "model",
            "modelOrigin": "process",
            "fieldOrigin": "name",
            "alias": "getProcess",
            "values": [
            ]
          },
          {
            "type": "file",
            "required": false,
            "label": "Documento Evaluación",
            "description": "Archivo Propuesta",
            "placeholder": "Archivo Propuesta",
            "className": "form-control",
            "name": "proposalFile",
            "access": false,
            "subtype": "file",
            "multiple": false,
            "list": false,
            "new": true,
            "edit": true,
            "filter": false,
            "show": true,
            "order": 0
          }]
      };

      var displayContentProcess = {
          fields: processData.fields,
          data: this.state.reviewData.values.get_project,
      };
      const displayProcess = <Displaycolumns content={ displayContentProcess } />;
      contentCard.push(displayProcess);

      if(this.state.reviewData.values.state=='Inactivo'){

        contentCard.push(<h5>Recuerde que para inicar la evaluación debe aceptar los términos y condiciones.</h5>);

        this.state.dataForm.fields = this.state.moduleData.fields;
        const form = <Form data={ this.state.dataForm } onSubmit={ this.startReview.bind(this) } />;
        contentCard.push(form);

        var submitButton = <Button type="submit" text="Aceptar" className="btn-success" align="justify-content-center" onClick={ this.startReview.bind(this) } />;
        footer.push(submitButton);

        var declineButton = <Button text="Rechazar" className="btn-danger" align="justify-content-center" onClick={ this.reviewDecline.bind(this) } />;
        footer.push(declineButton);

      }else{

        var submitButton = <Button text="Continuar" className="btn-success" align="justify-content-center" onClick={ this.Continue.bind(this) } />;
        footer.push(submitButton);

      }

      const data = {
        header: {
          title: "Iniciar Evaluación",
          name: this.state.projectData.name
        },
        body: contentCard,
        footer: footer,
      };

      const card = <Card data={ data }/>
      content.push(card);

      const columnData = {
          class: 'col-lg-10 col-10 offset-md-1',
          content: content,
        };

      const column = <Column data={ columnData }/>


      return (
        <>
          <Row content={ header }/>
          <Row content={ column }/>
        </>
      )
    }
}

export default Start;
