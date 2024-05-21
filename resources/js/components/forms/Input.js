import React, { useEffect, useState } from 'react';
import Label from "./Label"

class Input extends React.Component {

  render() {

    var required = "";
    if(this.props.data.required === true) required = "required";

    return (
        <div className={"form-group " + this.props.class } key={"" + this.props.data.name } >
          <Label data={ this.props.data } key={"label" + this.props.data.name } />
          <input   name={"" + this.props.data.name } key={"input" + this.props.data.name } type={"" + this.props.data.subtype } className="form-control input-sm" id={"" + this.props.data.name } placeholder={"" + this.props.data.placeholder } defaultValue={"" + this.props.value } onChange={ (this.props.onChange) ? this.props.onChange.bind(this) : null }  readOnly={this.props.data.readonly ? true : false}/>
        </div>
    )
  }
}

export default Input;
