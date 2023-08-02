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
import FormReviewPage from "../../../components/forms/FormReviewPage"

import Button from "../../../components/general/Button"


class New extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      moduleData: {name: 'moduloPreguntas', id: this.props.match.params.id, page: this.props.match.params.page },
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
      res: [],
    }

    this.state.dataForm.fbsetup = {
      typeUserAttrs: {
        min: {
          label: 'Min',
          value: "0",
        },
        max: {
          label: 'Max',
          value: 10,
        },
        number: {
           ponderacion: {
              label: 'ponderacion',
              value: '1',
            },
        },
        text: {
            minlength: { label: 'Longitud Mínima', value: '', type: 'number',}
        },
        textarea: {
            minlength: { label: 'Longitud Mínima', value: '', type: 'number',}
        }
      },
      disableHTMLLabels: true,
      disabledAttrs: ["class", "name", "access"],
      controlOrder: [
       'header',
       'paragraph',
       'text',
       'textarea',
       'number',
       'select',
       'autocomplete',
     ],
     inputSets: [
        {
          label: 'Grupo Predefinido',
          name: 'user-details', // optional - one will be generated from the label if name not supplied
          showHeader: true, // optional - Use the label as the header for this set of inputs
          icon: '📝',
          fields: [
              {
                type: 'header',
                subtype: 'h1',
                label: 'Título',
              },
              {
                type: 'paragraph',
                subtype: 'p',
                label: 'Descripcion',
              },
              {
                type: 'text',
                label: 'Pregunta',
              },
              {
                type: 'number',
                label: 'Calificación',
              },
            ]
        },
     ],
     disabledActionButtons: ['save'],
     disableFields: ['button','hidden','file'],
     i18n: {
        locale: 'es-ES',
        location: '/js/formbuilder/',
        extension: '.lang',
        //override: {
        //    'en-US': {...}
        //}
      }
    };
  }

  async componentDidMount() {
    try{
      const moduleData = await crudServices.getModule(this.state.moduleData);
      if(moduleData.success == true){

        var pagesList = await reviewServices.pagesList(this.props.match.params.id);
        if(pagesList.success == true){
            this.setState({ pages:  Object.values(pagesList.pages) });
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

        var res = await reviewServices.getPage(this.state.moduleData);
        this.setState({ res: res });

        this.setState({ isLoading: false });
      }
    }
    catch (error){
      this.setState({ isLoading: false});
      this.setState({ error: error});
    }
  }


    async saveContinue(e) {
      e.preventDefault()

        $(".fb-editor :input").each(function() {
          $(this).attr("disabled", "disabled");
        });
        const form = document.getElementById("formNew");
        const data = new FormData(form);
        const res = await reviewServices.saveQuestions(data, this.state.moduleData);

        if (res.success) {
          var nextPage = parseInt(res.idPage) + 1;
          var redirect = '/formreview/questions/' + this.state.moduleData.id + '/' + nextPage;
          window.location.href = redirect;
        } else {
          alert(res.message)
        }
    }

    async savePublish(e) {
      e.preventDefault()

        $(".fb-editor :input").each(function() {
          $(this).attr("disabled", "disabled");
        });
        const form = document.getElementById("formNew");
        const data = new FormData(form);
        const res = await reviewServices.saveQuestions(data, this.state.moduleData);

        if (res.success) {
          var redirect = '/formreview/publish/' + this.state.moduleData.id;
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
    this.state.dataForm.formValues = this.state.res;

    var actions = {
      saveContinue: this.saveContinue.bind(this),
      saveFinish: this.savePublish.bind(this),
    }

    const form = <FormReviewPage data={ this.state.dataForm } actions= { actions } />;

    const footer = "";

    const data = {
      header: {
        title: "Nuevo " + this.state.moduleData.props.label.singular,
      },
      body: form,
      footer: footer,
    };

    const card = <Card data={ data }/>

    var content = [];
/*
    var dataStepper = [
      {
        id: 'new',
        value: '1',
        label: 'Crear',
        withLine: true,
        active: '',
        link: '/formreview/edit/' + this.state.moduleData.id
      },
      {
        id: 'questions',
        value: '2',
        label: 'Definir Preguntas',
        withLine: true,
        active: 'active',
        link: '#'
      },
      {
        id: 'publish',
        value: '3',
        label: 'Publicar',
        withLine: false,
        active: '',
        link: '/formreview/publish/' + this.state.moduleData.id
      }
    ];*/


    var dataStepper = [];

    var step = {
      id: 'new',
      value: '<',
      label: 'Crear',
      withLine: true,
      active: '',
      link: '/formreview/edit/' + this.state.moduleData.id
    }
    dataStepper.push(step);

    this.state.pages.map((item,i)=>{
      var active = '';
      if(item.page==this.state.moduleData.page) active = 'active';

      var step = {
        id: item.page,
        value: item.page,
        label: item.pageName,
        withLine: true,
        active: active,
        link: '/formreview/questions/' + this.state.moduleData.id + '/' + item.page
      }
      dataStepper.push(step);
    })

    var step = {
      id: 'publish',
      value: '>',
      label: 'Publicar',
      withLine: false,
      active: '',
      link: '/formreview/publish/' + this.state.moduleData.id
    }
    dataStepper.push(step);

    const stepper = <Stepper data = { dataStepper } />;
    content.push(stepper);
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

export default New;
