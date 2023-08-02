import React, { useEffect, useState } from 'react';
import Label from "./Label"

class Textarea extends React.Component {

    componentDidMount() {
      if(this.props.data.subtype == 'tinymce'){
        CKEDITOR.replace(this.props.data.name, {
            height: '300px',
          })
      }
    }

  render() {
    return (
      <div className="form-group">
        <Label data={ this.props.data } />
        <textarea name={"" + this.props.data.name } className="form-control" id={"" + this.props.data.name } rows="3" placeholder={"" + this.props.data.placeholder } defaultValue={"" + this.props.value } required={this.props.data.required === "true" ? true : false}></textarea>
      </div>
    )
  }
}

export default Textarea;
