import React, { useEffect, useState } from 'react';
import { Link } from "react-router-dom";
import crudServices from "../../app/crud/Services"


class Display extends React.Component {

  render() {
    return (
        <>
          {
            this.props.content.fields.map((field,j)=>{

              var value = '';

              if(this.props.content.data[field.name]) value = this.props.content.data[field.name];

              if(field.origin == "model"){
                var alias = "get_" + field.name.toLowerCase();
                if(this.props.content.data[alias]) value = this.props.content.data[alias].name;
              }

              if(field.type == "file"){
                var file = this.props.content.data.files.filter(e => e.field === field.name)[0];
                if(file){
                  value = <><a href={ "/storage/files/" + file.file } target="_blank">{ file.file }</a><a href={ "/storage/files/" + file.file } target="_blank" type="button" className="btn btn-primary btn-sm">Ver Documento</a></>;
                }
              }

              if(value !== null){
                if(field.type == "textarea"){
                    value = <div dangerouslySetInnerHTML = {{ __html: value }} />;
                }

                if(field.subtype == "url"){
                    value = <a href={ "" + value } target="_blank">{ value }</a>;
                }

                if(field.subtype == "money"){
                    value =  value.toLocaleString('es-CO', { style: 'currency', currency: 'COP' });
                }
              }

              return(
                <>
                  <strong key={"" + j }>{field.label}</strong>
                  <p className="text-muted">
                    { value }
                  </p>
                  <hr/>
                </>
              )
            })
          }
        </>
    )
  }
}

export default Display;
