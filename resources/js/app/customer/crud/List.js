import React, { useEffect, useState } from 'react';

import customerServices from "../services/Customer"
import moduleServices from "../../general/services/Module"

import Column from "../../../components/general/Column"
import Row from "../../../components/general/Row"
import Card from "../../../components/general/Card"
import Table from "../../../components/general/Table"

import { Link } from "react-router-dom";

function List(props){

  const [ listCustomer, setListCustomer ] = useState([]);
  const [ moduleData, setModuleData ] = useState([]);

  useEffect(()=>{

    async function fetchDataCustomer(){
      const res = await customerServices.listCustomer();
      const moduleData = await moduleServices.getByName('customer');

      setListCustomer(res.data);
      setModuleData(moduleData.data);
    }

    fetchDataCustomer();

  },[]);

  const customerDelete = async (i,id) => {

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
      fields: moduleData.fields,
      data: listCustomer,
      actions: [ { name: 'show', title: 'Ver', type: 'link', link: '/customer/show/', class: 'btn bg-gradient-info btn-sm' },
                { name: 'edit', title: 'Editar', type: 'link', link: '/customer/edit/', class: 'btn bg-gradient-primary btn-sm' },
                { name: 'delete', title: 'Eliminar', type: 'a', onClick: customerDelete, class: 'btn btn-danger btn-sm' },
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
