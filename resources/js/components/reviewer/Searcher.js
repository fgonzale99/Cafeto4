import React, { Component, useEffect, useState } from 'react';

import Input from "../forms/Input"
import Number from "../forms/Number"
import Email from "../forms/Email"
import Password from "../forms/Password"
import File from "../forms/File"
import Hidden from "../forms/Hidden"
import Textarea from "../forms/Textarea"
import Areaeditor from "../forms/Areaeditor"
import Select from "../forms/Select"
import Radio from "../forms/Radio"
import Checkbox from "../forms/Checkbox"
import DateField from "../forms/DateField"
import FormBuilder from "../forms/FormBuilder"
import Button from "../../components/general/Button"

class Searcher extends React.Component {

  constructor(props) {
    super(props);

    var formContent = [];

    this.props.data.fields.map((item,i)=>{

      let value = '';
      if(this.props.data.formValues[item.name]){
        value = this.props.data.formValues[item.name];
      }else if (item.value) {
        value = item.value;
      }

      switch(item.type) {
        case 'text':
          var inputContent = <Input data={ item } value={ value } />;
          break;
        case 'number':
          var inputContent = <Number data={ item } value={ value } />;
          break;
        case 'date':
          var inputContent = <Date data={ item } value={ value } />;
          break;
        case 'email':
          var inputContent = <Email data={ item } value={ value } />;
          break;
        case 'password':
          var inputContent = <Password data={ item } value={ value } />;
          break;
        case 'hidden':
          var inputContent = <Hidden data={ item } value={ value } />;
          break;
        case 'file':
          var inputContent = <File data={ item } value={ value } />;
          break;
        case 'textarea':
          var inputContent = <Textarea data={ item } value={ value } />;
          break;
        case 'areaeditor':
          var inputContent = <Areaeditor data={ item } value={ value } />;
          break;
        case 'select':
          var inputContent = <Select data={ item } value={ value } />;
          break;
        case 'radio':
          var inputContent = <Radio data={ item } value={ value } />;
          break;
        case 'checkbox-group':
          var inputContent = <Checkbox data={ item } value={ value } />;
          break;
        case 'formbuilder':
          var inputContent = <FormBuilder data={ item } fbsetup={ this.props.data.fbsetup } value={ value } />;
          break;
        default:
          var inputContent = <Input data={ item } value={ value } />;
      }

      formContent.push(inputContent);
    })

    this.formContent = formContent;

  }

  render() {
    return (
        <div className="col-md-10 offset-md-1" >
          <div className="card card-outline card-info">
            <div className="card-header">
              <h3 className="card-title">Filtros</h3>

              <div className="card-tools">
                <button type="button" className="btn btn-tool" data-card-widget="collapse"><i className="fas fa-minus"></i>
                </button>
                <button type="button" className="btn btn-tool" data-card-widget="remove"><i className="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div className="card-body">
              <form role="form" id={"" + this.props.data.id} ref={"" + this.props.data.formRef} action="" method={"" + this.props.data.method} encType={"" + this.props.data.enctype} onSubmit={ this.props.onSubmit }>
                { this.formContent }
                <Button type="submit" text="Buscar" className="btn-success" />
                </form>
            </div>
          </div>
        </div>
    )
  }
}

export default Searcher;
