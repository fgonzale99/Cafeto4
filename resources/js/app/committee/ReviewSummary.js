import React, { useEffect, useState, useRef  } from 'react';
import ReactDOM from 'react-dom';
import Parser from 'html-react-parser';

import crudServices from "../crud/Services"
import moduleServices from "../general/services/Module"
import reviewServices from "../review/Services"

import Column from "../../components/general/Column"
import Row from "../../components/general/Row"
import Card from "../../components/general/Card"
import Modal from "../../components/general/Modal"
import Form from "../../components/forms/Form"
import Header from "../../components/general/Header"
import Stepper from "../../components/general/Stepper"
import Tabs from "../../components/general/Tabs"
import FormBuilderPage from "../../components/forms/FormBuilderPage"
import Displaycolumns from "../../components/general/Displaycolumns"
import { Doughnut } from 'react-chartjs-2'

import Button from "../../components/general/Button"


class ReviewSummary extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      moduleData: {name: 'evaluacionAceptar', id: this.props.match.params.id, page: this.props.match.params.page },
      pages: [],
      modalIsOpen: false,
      res: [],
      resReview: [],
    }
  }

  async componentDidMount() {
    try{
      const moduleData = await crudServices.getModule(this.state.moduleData);
      if(moduleData.success == true){

        this.state.moduleData.model = moduleData.data.model;
        var res = await reviewServices.getReviewInfo(this.state.moduleData.id);
        if(res.success == true){
          this.setState({ reviewData: {
              fields: moduleData.data.fields.filter(e => e.show === true),
              values: res.data} });
        }

        var resReview = await reviewServices.getReview(this.state.moduleData.id);
        if(resReview.success == true){
          this.setState({ resReview: resReview });
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
    var footer = [];
    var dataTabs = [];

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
        label: 'Ficha Evaluación',
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

    var displayContent = {
        fields: this.state.reviewData.fields,
        data: this.state.reviewData.values,
    };

    const display = <Displaycolumns content={ displayContent } />;
    content.push(display);

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
    content.push(displayProcess);

    const dataChart = {
      datasets: [
        {
          data: [this.state.reviewData.values.result],
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

    const result = <div className="row">
                    <div className="col-sm-6 text-center">
                      <h3>Puntaje Resultante</h3>
                      <h1>{ this.state.reviewData.values.result }</h1>
                    </div>
                    <div className="col-sm-2">
                      <Doughnut data={ dataChart } />
                    </div>
                  </div>;


    content.push(result);

    var answers = this.state.resReview.form.pages;

    answers.map((tab,i)=>{
        var form = JSON.stringify(tab.questions);
        var page = <FormBuilderPage data = { form } />;

        var tabData= {
          name: tab.pageName,
          content: page,
        }
        dataTabs.push(tabData);
    });

    const tabs = <Tabs data = { dataTabs } />;

    content.push(tabs);

    const data = {
      header: {
        title: "Ficha Evaluación",
        actions: [
              {"name":"download","title":"Descargar Reporte","type":"link","target":"_blank","link":"/review/reportstandard/","class": "btn bg-gradient-warning btn-sm","list":"false","header":"true","element":"false"},
              {"name":"timeline","title":"Línea de Tiempo","type":"link","link":"/review/track/","class": "btn bg-gradient-success btn-sm","list":"false","header":"true","element":"false"}],
        linkComplement: this.props.match.params.id,
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

export default ReviewSummary;
