import React, { useEffect, useState } from 'react';

import customerServices from "../services/Customer"
import Column from "../general/Column"
import Row from "../general/Row"
import Card from "../general/Card"
import Table from "../general/Table"

import { Link } from "react-router-dom";

function List(){

  const [ listCustomer, setListCustomer ] = useState([]);

  useEffect(()=>{

    async function fetchDataCustomer(){
      const res = await customerServices.listCustomer();
      setListCustomer(res.data);
    }

    fetchDataCustomer();
  },[]);

  const onClickDelete = async (i,id) => {

    var yes = confirm("are you sure to delete this item?");
    if (yes === true){

      const res = await customerServices.delete(id)

      if (res.success) {
        alert(res.message)
        const newList = listCustomer
        newList.splice(i,1)
        setListCustomer(newList);
      }
      else{
        alert(res.message);
      }
    }

  }

  const tableContent = {
      fields: [ {name: 'id', title: 'Id'},
                {name: 'name', title: 'Nombre'},
                {name: 'document', title: 'Documento'},
                {name: 'contact', title: 'Contacto'},
                {name: 'contactEmail', title: 'Correo Contacto'},
              ],
      data: listCustomer
    };

  const table = <Table fields={tableContent.fields} data={tableContent.data} />;

  const data = {
    header: {
      title: 'Clientes',
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
