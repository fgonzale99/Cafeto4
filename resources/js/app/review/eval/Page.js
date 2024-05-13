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
import FormBuilderRender from "../../../components/forms/FormBuilderRender"
import { Doughnut } from 'react-chartjs-2'

import Button from "../../../components/general/Button"


class Page extends React.Component {

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
        sendButton: false,
      },
      pages: [],
      modalIsOpen: false,
      res: [],
    }

    this.instructionsShow = async (e) => {
      this.setState({ modalIsOpen: true });
    }

  }

  async componentDidMount() {
    try{
      const moduleData = await crudServices.getModule(this.state.moduleData);

      if(moduleData.success == true){

        this.state.moduleData.model = moduleData.data.model;
        var res = await reviewServices.getReviewInfo(this.state.moduleData.id);
        this.setState({ reviewData: res.data });

        var infoModule =  { name: 'proyectos', id: res.data.project, model: 'project' }
        const moduleProject = await crudServices.getModule(infoModule);
        const resProject = await crudServices.get(infoModule);

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

        var res = await reviewServices.getPageReview(this.state.moduleData);
        this.setState({ res: res });
        this.setState({ isLoading: false });
      }
    }
    catch (error){
      this.setState({ isLoading: false});
      this.setState({ error: error});
    }



    //update conditionals

    this.setStateFormElement();

    const selects = document.querySelectorAll('select');

    selects.forEach(select => {
      select.addEventListener('change',() => {
        this.setStateFormElement();
      
      });
    });



  }





  setStateFormElement()
  {

  const elements = document.querySelectorAll('[dependencia]');


  elements.forEach(element => {
    if (element.dependencia !== '') {
      // Do something with the dependent element
      var dependency= element.getAttribute('dependencia');
      var enabledValue= element.getAttribute('condicion');
      var parentElement = document.querySelector("select[name='"+dependency+"']");  // Targets first img element with src="image.jpg"
      

      if(enabledValue!=parentElement.value)
      {
        element.disabled=true;
        console.log('disabled')
      }
      else
      {
        element.disabled=false;
        console.log('enabled')
      }


    }
  });
}





    async saveReview(e) {
      e.preventDefault()
        var data = $("#formReview").serializeArray();

    
        const res = await reviewServices.savePage(data, this.state.moduleData);

        if (res.success) {
          var pages = this.state.pages;
          var currentIndex = '';

          pages.map((item,i)=>{
            if(Number(item.page) == Number(this.state.moduleData.page)) currentIndex = i;
          });

          if(currentIndex == (this.state.pages.length - 1)){
            var redirect = '/review/finish/' + this.state.moduleData.id;
          }else{
            var nextPage = pages[currentIndex + 1].page;
            var redirect = '/review/form/' + this.state.moduleData.id + '/' + nextPage;
          }
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


    var header = [];
    var content = [];
    var cardContent = [];

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


    if(this.state.reviewData.state == "Inactivo"){
      alert('No ha aceptado la evaluación');


      var redirect= '/review/start/' + this.state.reviewData.id;
      window.location.href = redirect;


      return false;
    }


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
      var active = '';
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

    const result = <div className="row offset-md-6">
                    <div className="col-sm-10">
                      <h3>Puntaje Acumulado: { this.state.reviewData.result }</h3>
                    </div>
                    <Modal isOpen={ this.state.modalIsOpen } onClose={ this.onCloseModal.bind(this) }>
                      <h3>Instrucciones</h3>
                      <div dangerouslySetInnerHTML={{__html: this.state.reviewData.get_project.get_form_review.instructions}} />
                    </Modal>
                  </div>;
    cardContent.push(result);


    this.state.dataForm.fields = this.state.moduleData.fields;
    this.state.dataForm.form = this.state.res;

    if(this.state.reviewData.state == "Activo"){
      this.state.dataForm.sendButton = true;
    }

    var form = <FormBuilderRender data={ this.state.dataForm } onSubmit={ this.saveReview.bind(this) } />;
    cardContent.push(form);

    var actions = {
      instructionsShow: this.instructionsShow.bind(this),
    }

    const footer = [];

    var button = <Button onClick={ actions.instructionsShow } text="Ver Instrucciones" className="btn-info" align="justify-content-center"  />;

    const data = {
      header: {
        title: this.state.moduleData.props.label.singular,
        functions: { instructionsShow:  this.instructionsShow},
        extra: button,
      },
      body: cardContent,
      footer: footer,
    };

    const card = <Card data={ data }/>

    content.push(card);

    const columnData = {
        class: 'col-lg-10 col-10 offset-md-1',
        content: content,
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

export default Page;
