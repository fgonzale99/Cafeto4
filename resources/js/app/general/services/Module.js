const baseUrl = "/module"
import axios from "axios";
const customer = {};

customer.save = async (data) => {
  const urlSave= baseUrl+"/create"
  const res = await axios.post(urlSave,data)
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}

customer.listCustomer = async () => {
  const urlList = baseUrl+"/getlist"
  const res = await axios.get(urlList)
  .then(response=>{ return response.data; })
  .catch(error=>{ return error; })
  return res;
}

customer.get = async (id) => {
  const urlGet = baseUrl+"/get/"+id
  const res = await axios.get(urlGet)
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

customer.getByName = async (name) => {
  const urlGet = baseUrl+"/getByName/"+name
  const res = await axios.get(urlGet)
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

customer.update = async (data) => {
  const urlUpdate = baseUrl+"/update/"+data.id
  const res = await axios.put(urlUpdate,data)
  .then(response=>{ return response.data; })
  .catch(error =>{ return error; })
  return res;
}

customer.delete = async (id) => {
  const urlDelete = baseUrl+"/delete/"+id
  const res = await axios.delete(urlDelete)
  .then(response=> { return response.data })
  .catch(error =>{ return error })
  return res;
}

export default customer
