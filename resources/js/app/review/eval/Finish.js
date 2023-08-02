import React, { useEffect, useState, useRef  } from 'react';
import ReactDOM from 'react-dom';

import crudServices from "../../crud/Services"
import moduleServices from "../../general/services/Module"
import reviewServices from "../../review/Services"

import Column from "../../../components/general/Column"
import Row from "../../../components/general/Row"
import Card from "../../../components/general/Card"
import Modal from "../../../components/general/Modal"
import Form from "../../../components/forms/Form"
import Header from "../../../components/general/Header"
import Stepper from "../../../components/general/Stepper"
import Tabs from "../../../components/general/Tabs"
import FormBuilderPage from "../../../components/forms/FormBuilderPage"
import { Doughnut } from 'react-chartjs-2'

import Button from "../../../components/general/Button"


class Finish extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      moduleData: {name: 'evaluacionPagina', id: this.props.match.params.id, page: this.props.match.params.page },
      dataForm: {
        action: '',
        method: 'POST',
        enctype: 'multipart/form-data',
        id: 'formReview',
        formRef: React.createRef(),
        fields: [],
        formValues: [],
        notDefaultButton: true,
      },
      pages: [],
      modalIsOpen: false,
      res: [],
      resReview: [],
    }

    this.finishReview = async (e) => {
      e.preventDefault();
      const form = document.getElementById("formReview");
      const data = new FormData(form);

      const res = await reviewServices.reviewFinish(data, this.state.moduleData);

      if (res.success) {
        var redirect = '/review/summary/' + this.props.match.params.id;
        window.location.href = redirect;
      }
      else {
        alert(res.message)
      }
    }

  }

  async componentDidMount() {
    try{
      const moduleData = await crudServices.getModule(this.state.moduleData);
      if(moduleData.success == true){

        this.state.moduleData.model = moduleData.data.model;
        var res = await crudServices.get(this.state.moduleData);
        if(res.success == true){
          this.setState({ reviewData: res.data });
        }

        var infoModule =  { name: 'proyectos', id: res.data.project, model: 'project' }
        const moduleProject = await crudServices.getModule(infoModule);
        const resProject = await crudServices.get(infoModule);

        var resReview = await reviewServices.getReview(this.state.moduleData.id);
        var pagesList = await reviewServices.pagesList(resProject.data.get_formreview.id);
        if(pagesList.success == true){
            this.setState({ pages:  Object.values(pagesList.pages).filter(e => e.state === "active") });
        }

        this.setState({ moduleData: {
            model: moduleData.data.model,
            fields: moduleData.data.fields.filter(e => e.new === true),
            actions: moduleData.data.actions,
            props: moduleData.data.props,
            name: this.state.moduleData.name,
            id: this.state.moduleData.id,
            page: this.state.moduleData.page,
          }
        });

        if(resReview.success == true){
          this.setState({ resReview: resReview.form });
          this.setState({ isLoading: false });
        }

      }
    }
    catch (error){
      this.setState({ isLoading: false});
      this.setState({ error: error});
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
      active: '',
      link: '/review/start/' + this.state.moduleData.id
    }
    dataStepper.push(step);

    this.state.pages.map((item,i)=>{

      var step = {
        id: item.page,
        value: item.page,
        label: item.pageName,
        withLine: true,
        active: '',
        link: '/review/form/' + this.state.moduleData.id + '/' + item.page
      }
      dataStepper.push(step);
    })

    var step = {
      id: 1000,
      value: '>',
      label: 'Finalizar',
      withLine: false,
      active: 'active',
      link: '/review/finish/' + this.state.moduleData.id
    }
    dataStepper.push(step);

    const stepper = <Stepper data = { dataStepper } />;
    content.push(stepper);

    var dataTabs = [];

    this.state.resReview.pages.map((tab,i)=>{

      var form = JSON.stringify(tab.questions);

      var page = <FormBuilderPage data = { form } />;

      var tabData= {
        name: tab.pageName,
        content: page,
      }
      dataTabs.push(tabData);
    })

    const tabs = <Tabs data = { dataTabs } />;

    this.state.dataForm.fields = [{
      type: "signature",
      required: false,
      label: "Firma Código de Ética",
      description: "Firma Código de Ética",
      placeholder: "Firma",
      className: "form-control",
      name: "codeSignature",
      access: false,
      subtype: "text",
      list: true,
      new: true,
      edit: true,
      filter: true,
      show: true,
      order: 0
    }];

    const dataChart = {
      datasets: [
        {
          data: [this.state.reviewData.result],
          backgroundColor: [
            'rgba(0, 189, 0, 0.6)',
          ],
          borderColor: [
            'rgba(0, 189, 0, 0.6)',
          ],
          borderWidth: 1,
        },
      ],
    }

    const result = <div className="row" style={{'marginTop': '100px', 'marginBottom': '100px'}}>
                    <div className="col-sm-6 text-center">
                      <h3>Puntaje Resultante</h3>
                      <h1>{ this.state.reviewData.result }</h1>
                    </div>
                    <div className="col-sm-2">
                      <Doughnut data={ dataChart } />
                    </div>
                  </div>;
    content.push(result);

    if(this.state.reviewData.state == 'Activo'){
      const form = <div className="row">
                    <div className="col-sm-6  offset-md-3">
                      <Form data={ this.state.dataForm } onSubmit={ this.finishReview.bind(this) } />
                    </div>
                  </div>;
      content.push(form);

      var actions = {
        finishReview: this.finishReview.bind(this),
      }

      var button = <Button onClick={ actions.finishReview } text="Firmar y Finalizar" className="btn-info" align="justify-content-center"  />;
      footer.push(button);
    }
    //content.push(tabs);

    const data = {
      header: {
        title: "Finalizar Evaluación",
      },
      body: content,
      footer: footer,
    };

    const card = <Card data={ data }/>

    const columnData = {
        class: 'col-lg-10 col-10 offset-md-1',
        content: card,
      };

    var column = <Column data={ columnData }/>

    return (
      <>
        <Row content={ header }/>
        <Row content={ column } />
      </>
    )
  }
}

export default Finish;
