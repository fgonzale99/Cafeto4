const baseUrl = "/notification"
import axios from "axios";
const notification = {};

notification.messageSave = async (data, moduleData) => {
  const urlSave= baseUrl+"/message/save"
  const res = await axios.post(urlSave, data, {params: {modelName: moduleData.model, notificationId: moduleData.id}})
  .then(response=> {return response.data })
  .catch(error=>{ return error; })
  return res;
}

export default notification
