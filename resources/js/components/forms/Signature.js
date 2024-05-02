import React, { useEffect, useState } from 'react';
import Label from "./Label"

import SignaturePad from 'react-signature-pad-wrapper'
import Button from "../../components/general/Button"
//require("signature_pad");


class Signature extends React.Component {

  constructor(props) {

    super(props);

      this.clearPad = async (e) => {
        e.preventDefault();
        this.signaturePad.clear();
        document.getElementById(this.props.data.name).value = "";
      }



   




      this.handleOnEnd = async (e) => {
        const isValid = this.hasComplexity(this.signaturePad, 20);

       if (isValid)
       {
        var img = this.signaturePad.toDataURL("img/png");
        document.getElementById(this.props.data.name).value = img;
       }
       else
       document.getElementById(this.props.data.name).value = "";
       
      }



      


  }

  hasComplexity(pad,complexity)  {
    if (!complexity) {
      complexity = 10;
    }
    const points = pad.toData();
    const pointCount = [].concat.apply([], points).length;
    return points && pointCount >= complexity;
         
  };


  componentDidMount() {

    this.signaturePad.clear();
    this.signaturePad.dotSize = '0.2';
  }

  render() {
    return (
      <>
        <Label data={ this.props.data } key={"label" + this.props.data.name } />
        <SignaturePad options={{minWidth: 2, maxWidth: 3, dotSize: 0.8, backgroundColor: 'rgb(220, 220, 220)', onEnd: this.handleOnEnd.bind(this)}} ref={ref => this.signaturePad = ref} />
        <Button text="Limpiar" className="btn-danger" onClick={this.clearPad.bind(this)} align="justify-content-end"/>
        <input id={"" + this.props.data.name } name={"" + this.props.data.name } type="hidden" value="" required/>
      </>
    )
  }
}

export default Signature;
