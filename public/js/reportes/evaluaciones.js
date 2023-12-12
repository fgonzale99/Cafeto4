const formRevisiones = document.querySelector('#form-revisiones')
let resultadosConsulta = document.getElementById('resultados-Consulta')
let selectCustomersList = document.getElementById('customersList')
let selectProcessesList = document.getElementById('processesList')
let selectProjectsList = document.getElementById('projectsList')
let selectAssignedDate = document.getElementById('assignedDate')
let selectAssignedDateEnd = document.getElementById('assignedDateEnd')
let selectReviewDate = document.getElementById('reviewDate')
let selectReviewDateEnd = document.getElementById('reviewDateEnd')
let customer_text = ''
let process_text = ''
let project_text = ''
let customer_id = '';
let process_id = '';

$(document).ready(function() {
  $('.customersList').select2().on('select2:select', function () {
      getProcesses()
      getSelectedCustomerText()
  });
});

function getCustomers(){
    fetch(URL + '/reportes-customers/')
    .then(response => response.json())
    .then(customers =>{
      var optionsCustomers = '';
      optionsCustomers += `
                        <option value="" disabled selected hidden>Filtrar por cliente</option>
                        <option value="" >Consultar todos los clientes</option>
                        `
      customers.forEach(customer => {
      optionsCustomers += `
                    <option value="${customer.customer}">${customer.customer} - ${customer.cliente}</option>
                    `
      });
    document.getElementById('customersList').innerHTML = optionsCustomers
    optionsCustomers = '';
    })
    .catch(error => console.error(error));
}
document.addEventListener('DOMContentLoaded', getCustomers, false);

function getProcesses(){
    document.getElementById('processesList').innerHTML = '';
    document.getElementById('projectsList').innerHTML = '';
    customer_id = selectCustomersList.options[selectCustomersList.selectedIndex].value
    if (customer_id) {
        $('.processesList').select2().on('select2:select', function () {
            getProjects()
            getSelectedProcessText()
          });
    }
    fetch(URL + '/reportes-procesos/' + customer_id)
      .then(response => response.json())
      .then(processes =>{
        var optionsProcesses = '';
        optionsProcesses += `
                          <option value="" disabled selected hidden>Filtrar por proceso</option>`
        processes.forEach(process => {
        optionsProcesses += `
                      <option value="${process.process}">${process.process} - ${process.name}</option>
                      `
        });
      document.getElementById('processesList').innerHTML = optionsProcesses
      optionsProcesses = '';
      })
      .catch(error => console.error(error));
}

function getProjects(){
    process_id = selectProcessesList.options[selectProcessesList.selectedIndex].value
    /* console.log(customer_id + "-" + process_id + "-" + process_text); */
    if (process_id) {
        $('.projectsList').select2().on('select2:select', function () {
            getSelectedProjectText()
          });
    }
    fetch(URL + '/reportes-proyectos/' + customer_id+"/"+process_id)
      .then(response => response.json())
      .then(projects =>{
        var optionsProjects = '';
        optionsProjects += `
                          <option value="" disabled selected hidden>Filtrar por proyecto</option>`
        projects.forEach(project => {
        optionsProjects += `
                      <option value="${project.project}">${project.project} - ${project.proyecto}</option>
                      `
        });
      document.getElementById('projectsList').innerHTML = optionsProjects
      optionsProjects = '';
      })
      .catch(error => console.error(error));
}

function getSelectedCustomerText () {
    customer_text = selectCustomersList.options[selectCustomersList.selectedIndex].text
}

function getSelectedProcessText () {
    process_text = selectProcessesList.options[selectProcessesList.selectedIndex].text
}

function getSelectedProjectText () {
    project_text = selectProjectsList.options[selectProjectsList.selectedIndex].text
}

function startDatatableConfig () {
    $('#tableReport').DataTable({
      "iDisplayLength": 8,
      order: [[2, 'desc']],
      scrollX: true,
      language: {
          url: '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
      },
      "dom": "Brtip",
      buttons: [
        {
          extend: 'excel',
          text: '<i class="fa fa-file-excel-o"></i>&nbsp;&nbsp; Excel',
          filename: `Reprt. Unds. Evaluacion - ${customer_text}`,
          title: `${customer_text}`,
          /* messageTop: `PROCESO: -${process_text} //PROYECTO: -${project_text}`, */
          excelStyles:[
            {
                cells: 'st',
                style:{
                    font:{
                        size:"16",
                        b: true
                    }
                }
            },
            /* {
              cells: 'sm',
              height: 45,
              style: {
                  alignment: {
                      vertical: "center",
                      horizontal: "left",
                      wrapText: true,
                    }
                }
            } */
          ],
        },
        {
          extend: 'copy',
          text: '<i class="fa fa-copy"></i>&nbsp;&nbsp; Copy'
        },
        {
          extend: 'pdf',
          text: '<i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp; PDF',
          filename: `Reprt. - ${customer_text}`,
          title: `${customer_text}`
        },
        {
          extend: 'print',
          text: '<i class="fa fa-print"></i>&nbsp;&nbsp; Print'
        }
      ]
    })
}

const getRevisiones = async e => {
    e.preventDefault()
    const formData = new FormData(formRevisiones);
    let resultados = '';
    const mostrar = (revisiones) => {
        resultados += `<table id="tableReport" class="display compact" style="width:100%; ">
        <thead>
          <tr>
          <!--  <th scope="col" class="celda-popup">Clientes</th>
            <th scope="col" style="text-align: center">Cliente_ID</th>
            <th scope="col" class="celda-popup">Proceso</th>
            <th scope="col" style="text-align: center">Proceso_ID</th>
            <th scope="col" class="celda-popup">Proyecto</th>
            <th scope="col" style="text-align: center">Proyecto_ID</th>-->
            
            <th scope="col" style="text-align: left">Id</th>
            <th scope="col" style="text-align: left">Proceso</th>
            <th scope="col" style="text-align: left">Proyecto</th>
            <th scope="col" style="text-align: left">Evaluador</th>
            <th scope="col" style="text-align: center">email</th>
            <th scope="col" style="text-align: center">Asignado</th>
            <th scope="col" style="text-align: center">Evaluado</th>
            <th scope="col" style="text-align: center">Plazo</th>
            <th scope="col" style="text-align: center">Estado</th>
            <th scope="col" style="text-align: center">Desv. Plazo</th>
            <th scope="col" style="text-align: center">Est. Revisión</th>
            <th scope="col" style="text-align: center">Est. Pago</th>
            <th scope="col" style="text-align: center">Acciones</th>
          </tr>
        </thead>
        <tbody>
        `
        revisiones.forEach(revision => {
          
            resultados += `
                <tr>
                <td class="">${revision.reviewId}</td>
              <!--   <td class="celda-popup">${revision.name}</td>
                  <td class="alignment-center">
                      <a href="#" class="verNombre" data-toggle="modal" data-target="#textModal">${revision.customer}</a>
                  </td>


                  <td class="celda-popup">${revision}</td>
                  <td class="alignment-center">
                      <a href="#" class="verNombre" data-toggle="modal" data-target="#textModal">${revision.process}</a>
                  </td>
                  <td class="celda-popup">${revision.proyecto}</td> -->

                  <td class="alignment-left">${revision.proceso}</td>
                  <td class="alignment-left">${revision.proyecto}</td>
                  <td class="alignment-left">${revision.evaluador}</td>
                  <td class="alignment-left">${revision.email}</td>
                  <td class="alignment-center">${revision.assignDate}</td>
                  <td class="alignment-center">${revision.reviewDate}</td>
                  <td class="alignment-center">${revision.daysLimit}</td>
                  <td class="alignment-center">${revision.state}</td>
                  <td class="alignment-center">${revision.desviacion}</td>
                  <td class="alignment-center">${revision.estadoRevision}</td>
                  <td class="alignment-center">${revision.paymentState}</td>
                  <td class="alignment-center">
                      <a href="https://cafeto.cimaonline.com.co/review/reportcustom2/${revision.reviewId}" target="_blank"><i class="fa fa-chart-bar"></i></a>
                      <a href="https://cafeto.cimaonline.com.co/review/ethiccode/download/${revision.reviewId}" target="_blank"><i class="fa fa-balance-scale"></i></a>
                 
                      </td>
                </tr>
                        `
        });
        resultados += `</tbody>
                        </table>
                        `
        resultadosConsulta.innerHTML = resultados
        startDatatableConfig();
        resultados = "";
    }
    fetch(URL + '/reportes-resultados', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
          body: formData
    })
    .then(response =>response.json())
    .then(data => mostrar(data))
    .catch(error => console.error(error));
}

document.addEventListener('DOMContentLoaded', async () => {
    if (formRevisiones) {
      formRevisiones.addEventListener('submit', getRevisiones)
    }
})

const fired = (element, event, selector, handler) => {
    element.addEventListener(event, e => {
        if(e.target.closest(selector)){
            handler(e)
        }
    })
}

/* funcion de prueba */
/* fired(document, 'click', '.btnConsultar', e => {
    e.preventDefault();
    getRevisiones();
}) */
/* fin funcion prueba */

fired(document, 'click', '.verNombre', e => {
    e.preventDefault()
    const el = e.target.parentNode
    const cell = el.cellIndex
    const name = el.parentNode.children[cell-1].innerHTML
    console.log(name)
    document.getElementById('body-textModal').innerHTML = name
})

fired(document, 'change', '.fechaAsignado', e => {
    e.preventDefault()
    const ahora1 = new Date().toJSON().slice(0,10);
    const fecha = e.target.value
    selectAssignedDateEnd.value = ahora1;
    selectReviewDate.setAttribute('min',fecha);
    selectAssignedDateEnd.setAttribute('min',fecha);
})

fired(document, 'change', '.fechaEvaluado', e => {
    e.preventDefault()
    const ahora2 = new Date().toJSON().slice(0,10);
    const fecha2 = e.target.value
    selectReviewDateEnd.value = ahora2;
    selectReviewDateEnd.setAttribute('min',fecha2);
})

fired(document, 'click', '.btnLimpiar', e => {

    resultadosConsulta.innerHTML = '';
    selectProcessesList.innerHTML = '';
    selectProjectsList.innerHTML = '';
    getCustomers();
    selectAssignedDate.value = '';
    selectAssignedDateEnd.value = '';
    selectReviewDate.value = '';
    selectReviewDateEnd.value = '';
})
