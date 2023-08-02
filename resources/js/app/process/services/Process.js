const baseUrl = "/process"
import axios from "axios";
const process = {};

process.save = async (data) => {
  const urlSave= baseUrl+"/create"
  const res = await axios.post(urlSave,data)
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}

process.listP = async () => {
  const urlList = baseUrl+"/getlist"
  const res = await axios.get(urlList)
  .then(response=>{ return response.data; })
  .catch(error=>{ return error; })
  return res;
}

process.get = async (id) => {

  const urlGet = baseUrl+"/get/"+id
  const res = await axios.get(urlGet)
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;

}

process.update = async (data) => {
  const urlUpdate = baseUrl+"/update/"+data.id
  const res = await axios.put(urlUpdate,data)
  .then(response=>{ return response.data; })
  .catch(error =>{ return error; })
  return res;
}

process.delete = async (id) => {
  const urlDelete = baseUrl+"/delete/"+id
  const res = await axios.delete(urlDelete)
  .then(response=> { return response.data })
  .catch(error =>{ return error })
  return res;
}

process.paymentAvailable = async (id) => {
  const url= baseUrl+"/payment/available/"+id
  const res = await axios.get(url)
  .then(response=> { return response.data })
  .catch(error =>{ return error })
  return res;
}

export default process
