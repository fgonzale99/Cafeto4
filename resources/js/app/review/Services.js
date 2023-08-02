const baseUrl = "/formreview"
import axios from "axios";
const formreview = {};

formreview.saveQuestions = async (data, moduleData) => {
  const urlSave= baseUrl + "/questions/save"
  const res = await axios.post(urlSave, data, {params: {modelName: moduleData.model, id: moduleData.id, page: moduleData.page}})
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}

formreview.getPage = async (moduleData) => {
  const urlGet = baseUrl + "/page/get"
  const res = await axios.get(urlGet, {params: {modelName: moduleData.model, id: moduleData.id, page: moduleData.page}})
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

formreview.getPageReview = async (moduleData) => {
  const urlGet = "/review/page/get"
  const res = await axios.get(urlGet, {params: {modelName: moduleData.model, reviewId: moduleData.id, page: moduleData.page}})
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

formreview.pagesList = async (id) => {
  const urlGet = "/review/pageslist/"+id
  const res = await axios.get(urlGet)
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}


formreview.savePage = async (data, moduleData) => {
  const urlSave= "/review/page/save"
  const res = await axios.post(urlSave, {params: {modelName: moduleData.model, id: moduleData.id, page: moduleData.page, formData: data}})
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}


formreview.getFormReview = async (id, moduleData) => {
  const urlGet = baseUrl + "/getform/"+id
  const res = await axios.get(urlGet, {params: {modelName: moduleData.model, id: moduleData.id, page: moduleData.page}})
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

formreview.getReview = async (id) => {
  const urlGet = "/review/get/"+id
  const res = await axios.get(urlGet)
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

formreview.getReviewTrack = async (id) => {
  const urlGet = "/review/gettrack/"+id
  const res = await axios.get(urlGet)
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

formreview.getReviewInfo = async (id) => {
  const urlGet = "/review/getreview/"+id
  const res = await axios.get(urlGet)
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

formreview.published = async (id) => {
  const urlGet = baseUrl + "/published/"+id
  const res = await axios.get(urlGet, {params: {id: id}})
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

formreview.draft = async (id) => {
  const urlGet = baseUrl + "/draft/"+id
  const res = await axios.get(urlGet, {params: {id: id}})
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

formreview.assign = async (data, moduleData) => {

  const urlSave= "/project/assign"
  const res = await axios.post(urlSave, data, {params: {modelName: moduleData.model, id: moduleData.id}})
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}

formreview.reviewerProjects = async (moduleData, dataFilter, page) => {

  var filters = [];
  if(dataFilter){
    for(var input of dataFilter.entries()) {
       if(input[1]) filters.push(input);
    }
    filters = JSON.stringify(filters);
  }

  const urlList = "/reviewer/getProjects"
  const res = await axios.get(urlList, {params: {modelName: moduleData.model, moduleName: moduleData.name, filters: filters, page: page}})
  .then(response=>{ return response.data; })
  .catch(error=>{ return error; })
  return res;
}

formreview.reviewAccept = async (id) => {

  const urlList = "/review/accept"
  const res = await axios.get(urlList, {params: {id: id}})
  .then(response=>{ return response.data; })
  .catch(error=>{ return error; })
  return res;
}

formreview.reviewDecline = async (id) => {
  const urlList = "/review/decline"
  const res = await axios.get(urlList, {params: {id: id}})
  .then(response=>{ return response.data; })
  .catch(error=>{ return error; })
  return res;
}

formreview.reviewFinish = async (data, moduleData) => {
  const urlList = "/review/finishsave"
  const res = await axios.post(urlList, data, {params: {id: moduleData.id}})
  .then(response=>{ return response.data; })
  .catch(error=>{ return error; })
  return res;
}

formreview.reviewerChange = async (id) => {
  const urlList = "/customer/reviewerchange"
  const res = await axios.post(urlList, {params: {id: id}})
  .then(response=>{ return response.data; })
  .catch(error=>{ return error; })
  return res;
}


formreview.auditAssign = async (data) => {
  const urlSave= "/audit/assign/save"
  const res = await axios.post(urlSave, data)
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}

formreview.auditAssignUpdate = async (data) => {
  const urlSave= "/audit/assign/update"
  const res = await axios.post(urlSave, data)
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}

formreview.committeDocuments = async (dataFilter, page) => {
  const urlList = "/committee/review/getlist"
  const res = await axios.get(urlList)
  .then(response=>{ return response.data; })
  .catch(error=>{ return error; })
  return res;
}

formreview.delete = async (id) => {
  const urlDelete = "/review/delete/"+id
  const res = await axios.delete(urlDelete)
  .then(response=> { return response.data })
  .catch(error =>{ return error })
  return res;
}

formreview.getAudit = async (id) => {
  const urlGet = "/review/getaudit/"+id
  const res = await axios.get(urlGet)
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

formreview.getSummary = async (id) => {
  const urlGet = "/committee/getaudit/"+id
  const res = await axios.get(urlGet)
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

formreview.getCommitteSummary = async (id) => {
  const urlGet = "/committee/getaudit/"+id
  const res = await axios.get(urlGet)
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

formreview.getReviewer = async (id) => {
  const urlGet = "/committee/getreviewer/"+id
  const res = await axios.get(urlGet)
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

formreview.auditSave = async (data, moduleData) => {
  const urlSave= "/committee/eval/save"
  const res = await axios.post(urlSave, data, {params: {id: moduleData.id}})
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}

formreview.auditEdit = async (data, moduleData) => {
  const urlSave= "/committee/eval/update"
  const res = await axios.post(urlSave, data, {params: {id: moduleData.id}})
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}

formreview.paymenSend = async (id) => {
  const urlSave= "/review/payment/send/"+id
  const res = await axios.get(urlSave)
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}

/*formreview.processReviews = async (id) => {
  const urlSave= "/process/review/list/"+id
  const res = await axios.get(urlSave)
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}*/

formreview.processReviews = async (moduleData, dataFilter, page) => {

  var filters = [];
  if(dataFilter){
    for(var input of dataFilter.entries()) {
       if(input[1]) filters.push(input);
    }
    filters = JSON.stringify(filters);
  }

  const urlList = "/process/review/list"
  const res = await axios.get(urlList, {params: {modelName: moduleData.model, moduleName: moduleData.name, id: moduleData.id, filters: filters, page: page}})
  .then(response=>{ return response.data; })
  .catch(error=>{ return error; })
  return res;
}

formreview.paymentEnable = async (id) => {
  const urlSave= "/review/payment/enable/"+id
  const res = await axios.get(urlSave)
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}

export default formreview
