import React, { useEffect, useState } from 'react';

import processServices from "../services/Process"
import crudServices from "../../../app/crud/Services"
import Column from "../../../components/general/Column"
import Row from "../../../components/general/Row"
import Card from "../../../components/general/Card"
import Alert from "../../../components/general/Alert"
import Table from "../../../components/general/Table"
import Header from "../../../components/general/Header"
import Filters from "../../../components/general/Filters"
import Paginator from "../../../components/general/Paginator"


import { Link } from "react-router-dom";

class List extends React.Component {

  constructor(props) {
    super(props);

    var searchParams = new URLSearchParams(this.props.location.search);
    this.state = {
      isLoading: true,
      error: '',
      elementsList: [],
      moduleData: { name: 'procesos' },
      modalIsOpen: false,
      message: searchParams.get("message")
    }


  
    this.onDelete = async (id) => {

      //this.setState({ modalIsOpen: true});
   
      var yes = confirm("Confirme si desea eliminar el elemento.");
      if (yes === true){

        const res = await crudServices.delete(id, this.state.moduleData);

        if (res.success) {
          var redirect = '/crud/'+ this.state.moduleData.name +'/list?message=deleted';
          window.location.href = redirect;
        }
        else{
          alert(res.message);
        }
      }
    }

    this.onChangeFilter = async (e) => {

        const form = document.getElementById("filtersForm");
        const dataFilter = new FormData(form);
        const page = 1;
        const rest = await crudServices.list(this.state.moduleData, dataFilter, page);
        this.setState({ elementsList: rest.data});
        this.setState({ pages: rest.pagesTotal });

    }

    this.onChangePage = async (page, e) => {
        const form = document.getElementById("filtersForm");
        const dataFilter = new FormData(form);
        const rest = await crudServices.list(this.state.moduleData, dataFilter, page);
        this.setState({ elementsList: rest.data});
        this.setState({ currentPage: page });
    }

  }

  async componentDidMount() {
    try{
      
        const moduleData = await crudServices.getModule(this.state.moduleData);

        if(moduleData.success == true){

            this.setState({ moduleData: {
                model: moduleData.data.model,
                fields: moduleData.data.fields.filter(e => e.list === true),
                filters: moduleData.data.fields.filter(e => e.filter === true),
                actions: moduleData.data.actions,
                props: moduleData.data.props,
                name: this.state.moduleData.name
              }
             
            });
           
      
            

          //  const res = await reviewServices.reviewerProjects(this.state.moduleData);
            const res = await crudServices.list(this.state.moduleData,[],1);
  

            this.setState({ elementsList: res.data });
            this.setState({ pages: res.pagesTotal });

            if(res.success == true){
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

  render() {

    var header = [];
    var content = [];
    var cardBody = [];

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
        label: this.state.moduleData.props.label.plural,
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

    const alert = <Alert data={ this.state.message }/>;
    if (this.state.message) {
      content.push(alert);
    }

    const filtersData = {
      fields: [ { name: 'id', type: 'number', required: false, label: 'Id' },
      { name: 'name', type: 'text', required: false, label: "Nombre" },
      { name: 'customer', type: 'select', required: false, origin: 'model', modelOrigin: 'customer','placeholder': 'Responsable', list: true, filter: true, fieldOrigin: 'name', label: "Cliente" }
    
    ],
      formValues: [],
      onChangeFilter: this.onChangeFilter,
    }

    const filters = <Filters data={ filtersData } />

     
    console.log(filtersData);
    
    cardBody.push(filters);




      var tableContent = {
    fields: [ { name: 'id', type: 'number', required: false, label: 'Id' },
              { name: 'name', type: 'text', required: false, label: "Nombre" },
              { name: 'customer', type: 'select', required: false, origin: 'model', modelOrigin: 'customer','placeholder': 'Responsable', list: true, filter: true, fieldOrigin: 'name', label: "Cliente" }
            
            ],
     data: this.state.elementsList,
     actions: [ { name: 'show', title: 'Asignar Tope Presupuestal', type: 'link', link: '/process/show/', class: 'btn bg-gradient-info btn-sm' },
              ],
  };

      

    const table = <Table tableContent={tableContent} />;

    cardBody.push(table);

    const paginator = <Paginator pages={ this.state.pages } currentPage={ this.state.currentPage } onClick={ this.onChangePage } />;

    const data = {
      header: {
        title: "Lista de " + this.state.moduleData.props.label.plural,
        name: this.state.moduleData.name,
        actions: [], //this.state.moduleData.actions.filter(e => e.header === "true"),
      },
      body: cardBody,
      footer: paginator,
    };

    const card = <Card data={ data }/>
    const columnData = {
        class: 'col-lg-12 col-12',
        content: card,
      };
    const column = <Column data={ columnData }/>
    content.push(column);

    return (
      <>
        <Row content={ header }/>
        <Row content={ content }/>
      </>
    )
  }
}

export default List;
