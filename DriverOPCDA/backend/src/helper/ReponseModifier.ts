const response = (
  success: Boolean,
  code: Number,
  message: String,
  data: any,
) => {
  let resp;
  resp = {
    success,
    code,
    message,
    data,
  };
  return resp;
};
export default response;
