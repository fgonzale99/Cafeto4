import React, { useEffect, useState } from 'react';

import Column from "../../../components/general/Column"
import Row from "../../../components/general/Row"
import Card from "../../../components/general/Card"
import Header from "../../../components/general/Header"


import dashboardServices from "../../dashboard/Services"

import { Line, Bar, HorizontalBar, Radar, Doughnut, PolarArea, Bubble, Pie, Scatter } from 'react-chartjs-2'


class Dashboard extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      isLoading: true,
      error: '',
      elementsList: [],
      moduleData: { name: 'dashboard' },
      chartsData: [],
      modalIsOpen: false,
    }
  }

  async componentDidMount() {
    try{
      const customerByState = await dashboardServices.customerByState();

      if(customerByState.success == true){
        this.state.chartsData.customerByState = customerByState.data;
      }
      consle.log(this.state.chartsData);
    }
    catch (error){
      this.setState({ isLoading: false});
      this.setState({ error: error});
    }
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
        label: 'Panel de Reportes',
        active: 'active',
        link: '#',
      }
    ];

    const headerContent = {
      title: 'Panel de Reportes',
      breadcrumb: breadData,
    };

    const headerElement = <Header data={ headerContent }/>;
    header.push(headerElement);

    var charts = [];

    const row1 = [];
    const row2 = [];
    const row3 = [];

    const chart1Labels = [];
    const chart1Values = [];

    this.state.chartsData.customerByState.map((item,i)=>{
      chart1Labels.push(item.state)
      chart1Values.push(item.total)
    });

    const chart1Data = {
      labels: chart1Labels,
      datasets: [
        {
          label: '# de Clientes',
          data: chart1Values,
          backgroundColor: [
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 99, 132, 0.2)',
          ],
          borderColor: [
            'rgba(54, 162, 235, 1)',
            'rgba(255, 99, 132, 1)',
          ],
          borderWidth: 1,
        },
      ],
    };

    const chart1 = <Pie data={ chart1Data} />

    const data1 = {
      header: {
        title: 'Total de Clientes',
      },
      body: chart1,
    };

    const card1 = <Card data={ data1 }/>
    const columnData1 = {
        class: 'col-lg-5 col-5 offset-md-1',
        content: card1,
      };
    const column1 = <Column data={ columnData1 }/>

    row1.push(column1)

    const chart2Data = {
      labels: ['Activos', 'Inactivos'],
      datasets: [
        {
          label: '# de Procesos',
          data: [19, 11],
          backgroundColor: [
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 99, 132, 0.2)',
          ],
          borderColor: [
            'rgba(54, 162, 235, 1)',
            'rgba(255, 99, 132, 1)',
          ],
          borderWidth: 1,
        },
      ],
    };

    const chart2 = <Doughnut data={ chart2Data} />

    const data2 = {
      header: {
        title: 'Cantidad de Procesos',
      },
      body: chart2,
    };

    const card2 = <Card data={ data2 }/>
    const columnData2 = {
        class: 'col-lg-5 col-5',
        content: card2,
      };
    const column2 = <Column data={ columnData2 }/>
    row1.push(column2)

    const chart3Data = {
      labels: ['Activos', 'Inactivos'],
      datasets: [
        {
          label: '# de Evaluadores',
          data: [19, 11, 10, 22],
          backgroundColor: [
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
          ],
          borderColor: [
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
          ],
          borderWidth: 1,
        },
      ],
    };

    const chart3 = <Bar data={ chart3Data} />

    const data3 = {
      header: {
        title: 'Cantidad de Evaluadores',
      },
      body: chart3,
    };

    const card3 = <Card data={ data3 }/>
    const columnData3 = {
        class: 'col-lg-5 col-5 offset-md-1',
        content: card3,
      };
    const column3 = <Column data={ columnData3 }/>

    row2.push(column3)


    const chart4Data = {
      labels: ['Activas', 'Inactivas', 'Aceptadas', 'Finalizadas'],
      datasets: [
        {
          label: '# de Evaluaciones',
          data: [19, 11, 10, 22],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
          ],
          borderWidth: 1,
        },
      ],
    };

    const chart4 = <Bar data={ chart4Data} />

    const data4 = {
      header: {
        title: 'Cantidad de Evaluaciones',
      },
      body: chart4,
    };

    const card4 = <Card data={ data4 }/>
    const columnData4 = {
        class: 'col-lg-5 col-5',
        content: card4,
      };
    const column4 = <Column data={ columnData4 }/>

    row2.push(column4)




    const chart5Data = {
      labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
      datasets: [
        {
          label: 'Evaluaciones por Mes',
          data: [3, 15, 6, 9, 8, 2, 12],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(75, 192, 192, 0.2)',
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(75, 192, 192, 1)',
          ],
          borderWidth: 1,
        },
      ],
    };

    const chart5 = <Line data={ chart5Data} />

    const data5 = {
      header: {
        title: 'Cantidad de Evaluaciones',
      },
      body: chart5,
    };

    const card5 = <Card data={ data5 }/>
    const columnData5 = {
        class: 'col-lg-10 col-10 offset-md-1',
        content: card5,
      };
    const column5 = <Column data={ columnData5 }/>

    row3.push(column5)

console.log(header);
      return (
        <>
          <Row content={ header }/>
          <Row content={ row1 }/>
          <Row content={ row2 }/>
          <Row content={ row3 }/>
        </>
      )
    }
}

export default Dashboard
