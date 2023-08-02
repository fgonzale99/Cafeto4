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
import Header from "../../components/general/Header"

import Button from "../../components/general/Button"
import Timeline from "../../components/general/Timeline"


class Track extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      modalIsOpen: false,
      res: [],
      resReview: [],
      reviewTrack: [],
    }
  }

  async componentDidMount() {

    try{
        const res = await reviewServices.getReviewTrack(this.props.match.params.id);
        if(res.success == true){
          this.setState({ reviewTrack: res.data, isLoading: false });
        }
    }catch (error){
        this.state.isLoading = false;
        this.state.error = error;
    }

  }

  render() {

    var header = [];
    var content = [];
    var footer = [];

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
        label: 'Trazabilidad Evaluación',
        active: 'active',
        link: '#',
      }
    ];

    const headerContent = {
      title: 'Trazabilidad Evaluación',
      breadcrumb: breadData,
    };

    const headerElement = <Header data={ headerContent }/>;
    header.push(headerElement);
    console.log(this.state.reviewTrack);

    const dataTimeline = {
      events: this.state.reviewTrack,
    };
    const timeline = <Timeline data={ dataTimeline }/>
    content.push(timeline);

    const data = {
      header: {
        title: "Trazabilidad Evaluación",
        actions: [],
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

export default Track;
