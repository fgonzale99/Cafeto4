const baseUrl = "/reviewer"
import axios from "axios";
const reviewer = {};

reviewer.consultarhv = async (data, page) => {
  const urlSave= baseUrl+"/consultarhv"
  const res = await axios.post(urlSave, data, {params: { page: page}} )
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}

reviewer.consultarArticulos = async (data, page) => {
  const urlSave= baseUrl+"/consultararticulos"
  const res = await axios.post(urlSave, data, {params: { page: page}} )
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}

reviewer.consultarProyectos = async (data, page) => {
  const urlSave= baseUrl+"/consultarproyectos"
  const res = await axios.post(urlSave, data, {params: { page: page}} )
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}

reviewer.consultarLibros = async (data, page) => {
  const urlSave= baseUrl+"/consultarlibros"
  const res = await axios.post(urlSave, data, {params: { page: page}} )
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}

reviewer.setReviewer = async (id) => {
  const urlSave= baseUrl+"/setreviewer"
  const res = await axios.post(urlSave, { id: id} )
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}

export default reviewer
