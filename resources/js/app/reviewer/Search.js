import React, { useEffect, useState } from 'react';

import crudServices from "../../app/crud/Services"
import moduleServices from "../../app/general/services/Module"
import reviewerServices from "./Services"

import Column from "../../components/general/Column"
import Row from "../../components/general/Row"
import Card from "../../components/general/Card"
import Table from "../../components/general/Table"
import Button from "../../components/general/Button"
import Alert from "../../components/general/Alert"
import Header from "../../components/general/Header"
import Searcher from "../../components/reviewer/Searcher"
import Paginator from "../../components/general/Paginator"


import { Link } from "react-router-dom";

class List extends React.Component {

  constructor(props) {
    super(props);

    var searchParams = new URLSearchParams(this.props.location.search);
    this.state = {
      isLoading: true,
      error: '',
      filterForm: {
        action: '',
        method: 'POST',
        enctype: 'multipart/form-data',
        id: 'formSearch',
        formRef: React.createRef(),
        fields: [],
        formValues: [],
      },
      moduleData: { name: 'evaluadoresBusqueda' },
      investigadoresData: { name: 'investigadores' },
      articulosData: { name: 'evaluadoresArticulos' },
      proyectosData: { name: 'evaluadoresProyectos' },
      librosData: { name: 'evaluadoresLibros' },
      modalIsOpen: false,
      message: searchParams.get("message")
    }


    this.onSearch = async (e) => {
        e.preventDefault();
        const form = document.getElementById("formSearch");
        const dataFilter = new FormData(form);

        var checkedValue = [];
        var inputElements = document.getElementsByClassName('form-check-input');
        for(var i=0; inputElements[i]; ++i){
              if(inputElements[i].checked){
                   checkedValue.push(inputElements[i].value);
              }
        }

        if(checkedValue.includes("hv")){
          const resultInvestigador = await reviewerServices.consultarhv(dataFilter);
          this.setState({ investigadoresData: { ...this.state.investigadoresData,
                list:  resultInvestigador.data,
                currentPage: 1,
                pages: resultInvestigador.pagesTotal,
            }
          });
        }


        if(checkedValue.includes("articulos")){
          const resultArticulos = await reviewerServices.consultarArticulos(dataFilter);
          this.setState({ articulosData: { ...this.state.articulosData,
                list:  resultArticulos.data,
                currentPage: 1,
                pages: resultArticulos.pagesTotal,
            }
          });
        }

        if(checkedValue.includes("proyectos")){
          const resultProyectos = await reviewerServices.consultarProyectos(dataFilter);
          this.setState({ proyectosData: { ...this.state.proyectosData,
                list:  resultProyectos.data,
                currentPage: 1,
                pages: resultProyectos.pagesTotal,
            }
          });
        }

        if(checkedValue.includes("libros")){

        const resultLibros = await reviewerServices.consultarLibros(dataFilter);
          this.setState({ librosData: { ...this.state.librosData,
                list:  resultLibros.data,
                currentPage: 1,
                pages: resultLibros.pagesTotal,
            }
          });
        }
    }

    this.onChangePageInvestigador = async (page, e) => {
        var form = document.getElementById("formSearch");
        var dataFilter = new FormData(form);
        var rest = await reviewerServices.consultarhv(dataFilter, page);
        if(rest.success == true){
          this.setState({ investigadoresData: { ...this.state.investigadoresData,
                list:  rest.data,
                currentPage: page,
                pages: rest.pagesTotal,
            }
          });
        }
    }

    this.onChangePageArticulos = async (page, e) => {
        var form = document.getElementById("formSearch");
        var dataFilter = new FormData(form);
        var rest = await reviewerServices.consultarArticulos(dataFilter, page);
        if(rest.success == true){
          this.setState({ articulosData: { ...this.state.articulosData,
                list:  [],
                currentPage: page,
                pages: rest.pagesTotal,
            }
          });
        }
    }

    this.onChangePageProyectos = async (page, e) => {
        var form = document.getElementById("formSearch");
        var dataFilter = new FormData(form);
        var rest = await reviewerServices.consultarProyectos(dataFilter, page);
        if(rest.success == true){
          this.setState({ proyectosData: { ...this.state.proyectosData,
                list:  rest.data,
                currentPage: page,
                pages: rest.pagesTotal,
            }
          });
        }
    }

    this.onChangePageLibros = async (page, e) => {
        var form = document.getElementById("formSearch");
        var dataFilter = new FormData(form);
        var rest = await reviewerServices.consultarLibros(dataFilter, page);
        if(rest.success == true){
          this.setState({ librosData: { ...this.state.librosData,
                list:  rest.data,
                currentPage: page,
                pages: rest.pagesTotal,
            }
          });
        }
    }


    this.setReviewer = async (id) => {

        //this.setState({ modalIsOpen: true});
        var yes = confirm("Confirme si desea generar el perfil de evaluador.");
        if (yes === true){
          const res = await reviewerServices.setReviewer(id);

          if (res.success) {
            alert("El usuario se creo como evaluador.");
          }
          else{
            alert(res.message);
          }
        }
      }

  }

  async componentDidMount() {
    try{
        const moduleData = await crudServices.getModule(this.state.moduleData);
        if(moduleData.success == true){

            this.setState({ moduleData: {
                model: moduleData.data.model,
                filters: moduleData.data.fields.filter(e => e.filter === true),
                props: moduleData.data.props,
              }
            });
        }

        const investigadoresData = await crudServices.getModule(this.state.investigadoresData);
        if(investigadoresData.success == true){
            this.setState({ investigadoresData: {
                model: investigadoresData.data.model,
                fields: investigadoresData.data.fields.filter(e => e.list === true),
                filters: investigadoresData.data.fields.filter(e => e.filter === true),
                actions: investigadoresData.data.actions,
                props: investigadoresData.data.props,
                list: [],
                pages: 0,
                name: 'investigadores'
              }
            });
        }


        const articulosData = await crudServices.getModule(this.state.articulosData);
        if(articulosData.success == true){

            this.setState({ articulosData: {
                model: articulosData.data.model,
                fields: articulosData.data.fields.filter(e => e.list === true),
                filters: articulosData.data.fields.filter(e => e.filter === true),
                actions: articulosData.data.actions,
                props: articulosData.data.props,
                list: [],
                pages: 0,
                name: 'evaluadoresArticulos'
              }
            });
        }

        const proyectosData = await crudServices.getModule(this.state.proyectosData);
        if(proyectosData.success == true){

            this.setState({ proyectosData: {
                model: proyectosData.data.model,
                fields: proyectosData.data.fields.filter(e => e.list === true),
                filters: proyectosData.data.fields.filter(e => e.filter === true),
                actions: proyectosData.data.actions,
                props: proyectosData.data.props,
                list: [],
                pages: 0,
                name: 'evaluadoresProyectos'
              }
            });
        }

        const librosData = await crudServices.getModule(this.state.librosData);
        if(librosData.success == true){

            this.setState({ librosData: {
                model: librosData.data.model,
                fields: librosData.data.fields.filter(e => e.list === true),
                filters: librosData.data.fields.filter(e => e.filter === true),
                actions: librosData.data.actions,
                props: librosData.data.props,
                list: [],
                pages: 0,
                name: 'evaluadoresLibros'
              }
            });
        }

        if(moduleData.success == true){
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

  render() {

    var header = [];
    var content = [];

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
        label: 'Evaluadores',
        active: '',
        link: '/modulos/11',
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

    this.state.filterForm.fields = this.state.moduleData.filters;

    var filters = <Searcher data={ this.state.filterForm } onSubmit={ this.onSearch.bind(this) } />

    content.push(filters);

    var tableContent = {
        fields: this.state.investigadoresData.fields,
        data: this.state.investigadoresData.list,
        actions: this.state.investigadoresData.actions.filter(e => e.list === true),
        setReviewer: this.setReviewer,
      };

    var table = <Table tableContent={tableContent} />;

    var paginator = <Paginator pages={ this.state.investigadoresData.pages } currentPage={ this.state.investigadoresData.currentPage } onClick={ this.onChangePageInvestigador } />;

    var data = {
      header: {
        title: "Consulta Base Datos Colciencias Hoja de Vida General",
        name: this.state.investigadoresData.name,
        actions: this.state.investigadoresData.actions.filter(e => e.header === true),
      },
      body: table,
      footer: paginator
    };

    var card = <Card data={ data }/>
    var columnData = {
        class: 'col-lg-10 col-10 offset-md-1',
        content: card,
      };
    var column = <Column data={ columnData }/>
    content.push(column);


    var tableContent = {
        fields: this.state.articulosData.fields,
        data: this.state.articulosData.list,
        actions: this.state.articulosData.actions.filter(e => e.list === true),
      };

    var table = <Table tableContent={tableContent} />;

    var paginator = <Paginator pages={ this.state.articulosData.pages } currentPage={ this.state.articulosData.currentPage } onClick={ this.onChangePageArticulos } />;

    var data = {
      header: {
        title: "Consulta Base Datos Colciencias Artículos",
        name: this.state.articulosData.name,
        actions: this.state.articulosData.actions.filter(e => e.header === true),
      },
      body: table,
      footer: paginator
    };

    var card = <Card data={ data }/>
    var columnData = {
        class: 'col-lg-10 col-10 offset-md-1',
        content: card,
      };
    var column = <Column data={ columnData }/>
    content.push(column);



    var tableContent = {
        fields: this.state.proyectosData.fields,
        data: this.state.proyectosData.list,
        actions: this.state.proyectosData.actions.filter(e => e.list === true),
      };

    var table = <Table tableContent={tableContent} />;

    var paginator = <Paginator pages={ this.state.proyectosData.pages } currentPage={ this.state.proyectosData.currentPage } onClick={ this.onChangePageProyectos } />;

    var data = {
      header: {
        title: "Consulta Base Datos Colciencias Proyectos",
        name: this.state.proyectosData.name,
        actions: this.state.proyectosData.actions.filter(e => e.header === true),
      },
      body: table,
      footer: paginator
    };

    var card = <Card data={ data }/>
    var columnData = {
        class: 'col-lg-10 col-10 offset-md-1',
        content: card,
      };
    var column = <Column data={ columnData }/>
    content.push(column);




    var tableContent = {
        fields: this.state.librosData.fields,
        data: this.state.librosData.list,
        actions: this.state.librosData.actions.filter(e => e.list === true),
      };

    var table = <Table tableContent={tableContent} />;

    var paginator = <Paginator pages={ this.state.librosData.pages } currentPage={ this.state.librosData.currentPage } onClick={ this.onChangePageLibros } />;

    var data = {
      header: {
        title: "Consulta Base Datos Colciencias Libros",
        name: this.state.librosData.name,
        actions: this.state.librosData.actions.filter(e => e.header === true),
      },
      body: table,
      footer: paginator
    };

    var card = <Card data={ data }/>
    var columnData = {
        class: 'col-lg-10 col-10 offset-md-1',
        content: card,
      };
    var column = <Column data={ columnData }/>
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
