import React, { useEffect, useState } from 'react';
import Label from "./Label"


class Checkbox extends React.Component {

  render() {
    return (
      <div className="form-group">
        <Label data={ this.props.data } key={"label" + this.props.data.name } />

        {
          this.props.data.values.map((item,i)=>{
            return(
              <div className="form-check" key={ "div_" + i } style={{float: 'left'}}>
                <input className="form-check-input" key={this.props.data.name + "_" + i } type="checkbox" name={"" + this.props.data.name } id={"" + this.props.data.name } value={"" + item.value } onChange={ (this.props.onChange) ? this.props.onChange.bind(this) : null } />
                <label className="form-check-label" key={this.props.data.name + "_label_" + i }>{ item.label }</label>
              </div>
            )
          })
        }
      </div>
    )
  }
}

export default Checkbox;
