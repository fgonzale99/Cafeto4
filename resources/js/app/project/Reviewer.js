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

import Button from "../../components/general/Button"

class Reviewer extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      moduleData: {name: 'proyectos', id: this.props.match.params.id },
      asignForm: {
        action: '',
        method: 'POST',
        enctype: 'multipart/form-data',
        id: 'formAsign',
        formRef: React.createRef(),
        fields: [],
        formValues: [],
        notDefaultButton: true,
      },
      modalIsOpen: false,
      res: [],
    }

    this.saveReviewer = async (id) => {



      const validateTopBudget = await reviewServices.validateTopBudget( this.state.moduleData);
    
      
      if(!validateTopBudget)
      {
        alert('Se ha alcanzado el tope presupuestal para este proceso, no puede seguir asignando evaluadores');
        return;
      }
      else{

        //var yes = confirm("Confirme si desea asignar el evaluador al proceso actual.");

        const form = document.getElementById("formAsign");
        const data = new FormData(form);
        const res = await reviewServices.assign(data, this.state.moduleData);
  
        if (res.success) {
            this.onCloseModal();
            alert("La evaluación se asigno correctamente.");
        }else{
            alert(res.message);
        }
      }
    
    }

    this.setReviewer = async (id) => {
        this.onOpenModal();
        this.state.asignForm.formValues.reviewer = id;
        this.state.asignForm.formValues.project = this.state.moduleData.id;
    }

    this.onChangeFilter = async (e) => {
        const dataFilter = new FormData(e.target.form);
        const rests = await crudServices.list(this.state.moduleData, dataFilter);
        this.setState({ elementsList: rests.data});
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

        const formData = await crudServices.getModule({name: 'evaluacionAsignarEvaluador' });
        if(formData.success == true){
          this.setState({ asignForm: {  ...this.state.asignForm,
              fields: formData.data.fields.filter(e => e.new === true),
            }
          });


        }

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

    if (this.state.isLoading) {
      return <div className="App">Cargando...</div>;
    }

    var content = [];

    var dataStepper = [
      {
        id: 'new',
        value: '1',
        label: 'Información Proyecto',
        withLine: true,
        active: '',
        link: '/project/edit/' + this.state.moduleData.id
      },
      {
        id: 'reviewer',
        value: '2',
        label: 'Asignar Evaluador',
        withLine: false,
        active: 'active',
        link: '#'
      }
    ];

    const stepper = <Stepper data = { dataStepper } />;

    var columnData = {
        class: 'col-lg-10 col-10 offset-md-1',
        content: stepper,
      };

    const columnStepper = <Column data={ columnData }/>

    content.push(columnStepper);

    const listData = {
        module: 'evaluadoresAsignar',
        functions: { setReviewer: this.setReviewer}
    };

    //const column = <Column data={ columnData }/>
    const listReviewer = <List data={ listData }/>

    var columnData = {
        class: 'col-lg-10 col-10 offset-md-1',
        content: listReviewer,
      };

    const columnCard = <Column data={ columnData }/>

    content.push(columnCard);

    var modalForm = <Modal isOpen={ this.state.modalIsOpen } onClose={ this.onCloseModal.bind(this) }>
                    <h3>Asignar Evaluador</h3>
                    <Form data={ this.state.asignForm } onSubmit={ this.saveReviewer.bind(this) } />
                    <Button onClick={ this.saveReviewer.bind(this) } text="Enviar" className="btn-info" align="justify-content-center"  />
                  </Modal>;

    content.push(modalForm);

    return (
      <>
        <Row content={ content } />
      </>
    )
  }
}

export default Reviewer;
