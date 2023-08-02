import React, { useEffect, useState } from 'react';

import processServices from "../services/Process"
import Column from "../../../components/general/Column"
import Row from "../../../components/general/Row"
import Card from "../../../components/general/Card"
import Table from "../../../components/general/Table"

import { Link } from "react-router-dom";

function List(props){

  const [ listProcess, setListProcess ] = useState([]);


  useEffect(()=>{

    async function fetchDataProcess(){
        const res = await processServices.listP();
        setListProcess(res.data);

    }
    fetchDataProcess();
  });

  const onClickDelete = async (i,id) => {

    var yes = confirm("are you sure to delete this item?");
    if (yes === true){

      const res = await processServices.delete(id)

      if (res.success) {
        alert(res.message)
        const newList = listProcess
        newList.splice(i,1)
        setListProcess(newList);
      }
      else{
        alert(res.message);
      }
    }

  }

  const tableContent = {
      fields: [ { name: 'id', title: 'Id' },
                { name: 'nombreProceso', title: 'Nombre' },
                { name: 'institucion', title: 'Cliente' },
                { name: 'fechaInicio', title: 'Fecha de Inicio' },
                { name: 'fechaTermino', title: 'Fecha de Terminación' },
              ],
      data: listProcess,
      actions: [ { name: 'show', title: 'Ver', type: 'link', link: '/process/show/', class: 'btn bg-gradient-info btn-sm' },
                { name: 'edit', title: 'Editar', type: 'link', link: '/process/edit/', class: 'btn bg-gradient-primary btn-sm' },
                { name: 'delete', title: 'Eliminar', type: 'a', onClick: 'processDelete', class: 'btn btn-danger btn-sm' },
              ],
    };

  const table = <Table tableContent={tableContent} />;

  const data = {
    header: {
      title: "Lista de ",
      name: '',
    },
    body: table,
  };

  const card = <Card data={ data }/>

  const columnData = {
      class: 'col-lg-12 col-12',
      content: card,
    };

  const column = <Column data={ columnData }/>

  return (
    <Row content={ column }/>
  )
}

export default List;
