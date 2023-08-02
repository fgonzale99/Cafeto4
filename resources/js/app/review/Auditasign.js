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

import Button from "../../components/general/Button"


class Auditasign extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      moduleData: {name: 'revisionAsignar', id: this.props.match.params.id },
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

    this.saveAudit = async (id) => {
      //this.setState({ modalIsOpen: true});
      var yes = confirm("Confirme si desea asignar el miembro del comité a la evaluación actual.");
      if (yes === true){

        const res = await reviewServices.auditAssign(id, this.state.moduleData);

        if (res.success) {
          var redirect = '/project/board/'+ this.state.moduleData.id +'?message=updated';
          window.location.href = redirect;
        }
        else{
          alert(res.message);
        }
      }
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

    this.state.dataForm.fields = this.state.moduleData.fields;
    this.state.dataForm.formValues = this.state.res;


    const listData = {
        module: 'revisionAsignar',
        functions: { saveAudit: this.saveAudit}
    };

    //const column = <Column data={ columnData }/>
    const listReviewer = <List data={ listData }/>

    var columnData = {
        class: 'col-lg-10 col-10 offset-md-1',
        content: listReviewer,
      };

    const columnCard = <Column data={ columnData }/>

    content.push(columnCard);

    return (
      <>
        <Row content={ content } />
      </>
    )
  }
}

export default Auditasign;
