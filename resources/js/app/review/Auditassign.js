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


class Auditassign extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      moduleData: {name: 'evaluacionAsignarComite', id: this.props.match.params.id },
      asignForm: {
        action: '',
        method: 'POST',
        enctype: 'multipart/form-data',
        id: 'formAssign',
        formRef: React.createRef(),
        fields: [],
        formValues: [],
        notDefaultButton: true,
      },
      modalIsOpen: false,
      res: [],
    }

    this.saveAudit = async (id) => {
      const form = document.getElementById("formAssign");
      const data = new FormData(form);

      const res = await reviewServices.auditAssign(data);

      if (res.success) {
          this.onCloseModal();
          alert("La revisión se asigno correctamente.");
      }else{
          alert(res.message);
      }
    }

    this.setAudit = async (id) => {
        this.onOpenModal();
        this.state.asignForm.formValues.user = id;
        this.state.asignForm.formValues.review = this.state.moduleData.id;
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

        const formData = await crudServices.getModule({name: 'revisionAsignar' });
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

    this.state.asignForm.fields = this.state.moduleData.fields;
    this.state.asignForm.formValues = this.state.res;


    const listData = {
        module: 'revisionAsignar',
        functions: { saveAudit: this.saveAudit, setAudit: this.setAudit }
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
                    <h3>Asignar Comite</h3>
                    <Form data={ this.state.asignForm } onSubmit={ this.saveAudit.bind(this) } />
                    <Button onClick={ this.saveAudit.bind(this) } text="Enviar" className="btn-info" align="justify-content-center"  />
                  </Modal>;

    content.push(modalForm);

    return (
      <>
        <Row content={ content } />
      </>
    )
  }
}

export default Auditassign;
