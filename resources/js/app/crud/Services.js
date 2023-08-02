const baseUrl = "/crud"
import axios from "axios";
const crud = {};

crud.save = async (data, moduleData) => {
  const urlSave= baseUrl+"/create"
  const res = await axios.post(urlSave, data, {params: {modelName: moduleData.model, id: moduleData.id}})
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}

crud.list = async (moduleData, dataFilter, page, prefilter) => {

  var filters = [];
  if(dataFilter){
    for(var input of dataFilter.entries()) {
       if(input[1]) filters.push(input);
    }
    filters = JSON.stringify(filters);
  }

  const urlList = baseUrl+"/getlist"
  const res = await axios.get(urlList, {params: {modelName: moduleData.model, moduleName: moduleData.name, filters: filters, page: page, prefilter: prefilter}})
  .then(response=>{ return response.data; })
  .catch(error=>{ return error; })
  
  
  return res;
}

crud.get = async (moduleData) => {
  const urlGet = baseUrl+"/get"
  const res = await axios.get(urlGet, {params: {modelName: moduleData.model, id: moduleData.id, moduleName: moduleData.name}})
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

crud.getModule = async (moduleData) => {
  const urlGet = baseUrl+"/getModule"
  const res = await axios.get(urlGet, {params: {moduleName: moduleData.name}})
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

crud.getFile = async (fileModel, fieldName, elementId) => {
  const urlGet = baseUrl+"/getFile"
  const res = await axios.get(urlGet, {params: { fileModel: fileModel, fieldName: fieldName, elementId: elementId }})
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

crud.update = async (data, moduleData) => {
  const urlUpdate = baseUrl+"/update"
  const res = await axios.post(urlUpdate, data, {params: {modelName: moduleData.model, id: moduleData.id}})
  .then(response=>{ return response.data; })
  .catch(error =>{ return error; })
  return res;
}

crud.delete = async (id, moduleData) => {
  const urlDelete = baseUrl+"/delete/"+id
  const res = await axios.delete(urlDelete, {params: {modelName: moduleData.model}})
  .then(response=> { return response.data })
  .catch(error =>{ return error })
  return res;
}

crud.duplicate = async (id, moduleData) => {
  const urlDuplicate = baseUrl+"/duplicate/"+id
  const res = await axios.get(urlDuplicate, {params: {modelName: moduleData.model}})
  .then(response=> { return response.data })
  .catch(error =>{ return error })
  return res;
}


crud.getModel = async (data) => {
  const urlGet = baseUrl+"/getModel"
  const res = await axios.get(urlGet, {params: {modelName: data.model}})
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

crud.getEnum = async (data) => {
  const urlGet = baseUrl+"/getEnum"
  const res = await axios.get(urlGet, {params: {modelName: data.model, field: data.fieldOrigin}})
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

crud.options = async (moduleData) => {
  const urlList = baseUrl+"/getOptions"
  const res = await axios.get(urlList, {params: {modelName: moduleData.model, moduleName: moduleData.name, filters: moduleData.DataFilters }})
  .then(response=>{ return response.data; })
  .catch(error=>{ return error; })
  return res;
}

crud.selectFunction = async (url, fatherId) => {
  var urlGet = url;
  if(fatherId) urlGet = url + '/' + fatherId;
  const res = await axios.get(urlGet)
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

crud.getUserCurrent = async () => {
  const urlGet = "/user/getcurrent"
  const res = await axios.get(urlGet)
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

crud.userUpdate = async (data) => {
  const urlGet = "/user/profile/update"
  const res = await axios.post(urlGet, data)
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

crud.userDocumentsUpload = async (data) => {
  const urlGet = "/user/documents/upload"
  const res = await axios.post(urlGet, data)
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

crud.uniqueForm = async (processId, formId) => {
  const urlGet = "/formreview/uniqueForm/" + processId +'/' + formId;
  const res = await axios.get(urlGet)
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}



export default crud
