import React, { useEffect, useState, useRef  } from 'react';
import ReactDOM from 'react-dom';

import crudServices from "../../crud/Services"
import moduleServices from "../../general/services/Module"
import reviewServices from "../../review/Services"

import Column from "../../../components/general/Column"
import Row from "../../../components/general/Row"
import Card from "../../../components/general/Card"
import Modal from "../../../components/general/Modal"
import Stepper from "../../../components/general/Stepper"
import Form from "../../../components/forms/Form"
import FormBuilderPage from "../../../components/forms/FormBuilderPage"
import Tabs from "../../../components/general/Tabs"
import Header from "../../../components/general/Header"
import Button from "../../../components/general/Button"


class Eval extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      moduleData: {name: 'moduloPreguntas', id: this.props.match.params.id },
      dataForm: {
        action: '',
        method: 'POST',
        enctype: 'multipart/form-data',
        id: 'formReview',
        formRef: React.createRef(),
        fields: [],
        formValues: [],
      },
      modalIsOpen: false,
      res: [],
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
            name: this.state.moduleData.name,
            id: this.state.moduleData.id,
            page: this.state.moduleData.page,
          }
        });

        var res = await reviewServices.getFormReview(this.state.moduleData.id, this.state.moduleData);
        this.setState({ res: res });

        this.setState({ isLoading: false });
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

    var content = [];
    var header = [];
    var dataTabs = [];

    if (this.state.isLoading) {
      return <div className="App">Cargando...</div>;
    }

    this.state.dataForm.fields = this.state.moduleData.fields;
    this.state.dataForm.form = this.state.res;

    const breadData = [
      {
        label: 'Inicio',
        active: '',
        link: '/',
      },
      {
        label: this.state.moduleData.props.label.plural,
        active: 'active',
        link: '/formreview/list',
      },
      {
        label: 'Ficha',
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

    this.state.dataForm.form.questions.map((tab,i)=>{

      var form = JSON.stringify(tab.questions);

      var page = <FormBuilderPage data = { form } />;

      var tabData= {
        name: tab.pageName,
        content: page,
      }
      dataTabs.push(tabData);
    })

    const tabs = <Tabs data = { dataTabs } />;

    const footer = [];

    const data = {
      header: {
        title: "Cuestionario",
      },
      body: tabs,
      footer: footer,
    };

    const card = <Card data={ data }/>

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

export default Eval;
