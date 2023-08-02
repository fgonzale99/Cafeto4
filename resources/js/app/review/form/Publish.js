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


import Button from "../../../components/general/Button"


class Publish extends React.Component {

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


    async publish(e) {
      e.preventDefault()

        const res = await reviewServices.published(this.state.moduleData.id);

        if (res.success) {
          var redirect = '/crud/cuestionarios/list?message=updated';
          window.location.href = redirect;
        }
        else {
          alert(res.message)
        }
    }

    async draft(e) {
      e.preventDefault()

        const res = await reviewServices.draft(this.state.moduleData.id);

        if (res.success) {
          var redirect = '/crud/cuestionarios/list?message=updated';
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

    if (this.state.isLoading) {
      return <div className="App">Cargando...</div>;
    }

    this.state.dataForm.fields = this.state.moduleData.fields;
    this.state.dataForm.form = this.state.res;

    var content = [];

    var dataStepper = [
      {
        id: 'new',
        value: '<',
        label: 'Crear',
        withLine: true,
        active: '',
        link: '/formreview/edit/' + this.state.moduleData.id
      },
      {
        id: 'questions',
        value: '',
        label: 'Definir Preguntas',
        withLine: true,
        active: '',
        link: '/formreview/questions/' + this.state.moduleData.id + '/1'
      },
      {
        id: 'publish',
        value: '>',
        label: 'Publicar',
        withLine: false,
        active: 'active',
        link: '#'
      }
    ];

    const stepper = <Stepper data = { dataStepper } />;

    content.push(stepper);

    var dataTabs = [];

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

    var actions = {
      publish: this.publish.bind(this),
      draft: this.draft.bind(this),
    }

    const footer = [];

    var button = <Button onClick={ actions.draft } text="Guardar Borrador" className="btn-info" />;
    footer.push(button);
    button = <Button onClick={ actions.publish } text="Publicar" className="btn-success" />;
    footer.push(button);

    const data = {
      header: {
        title: "Publicar Cuestionario",
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

export default Publish;
