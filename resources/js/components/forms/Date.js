import React, { useEffect, useState } from 'react';
import Label from "./Label"

class Date extends React.Component {

  componentDidMount() {

  }

  render() {

    return (
      <div className="form-group">
        <Label data={ this.props.data } />
        <div className="input-group">
          <div className="input-group-prepend">
            <span className="input-group-text"><i className="far fa-calendar-alt"></i></span>
          </div>
          <input type="text" id={"" + this.props.data.name } name={"" + this.props.data.name } className="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask="" im-insert="false" defaultValue={"" + this.props.value }/>
        </div>
      </div>
    )
  }
}

export default Date;
