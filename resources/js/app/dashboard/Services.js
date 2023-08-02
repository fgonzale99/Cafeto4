const baseUrl = "/dashboard"
import axios from "axios";
const dashboard = {};

dashboard.customerByState = async (moduleData) => {
  const urlGet = baseUrl + "/customer/state"
  const res = await axios.get(urlGet)
  .then(response=>{ return response.data })
  .catch(error => { return error })
  return res;
}

export default dashboard
