import React, { Component, useEffect, useState } from 'react';

class Row extends React.Component {

    render() {
      return (
        <div className="row" key="row">
        { this.props.content }
        </div>
      )
    }
}

export default Row;
