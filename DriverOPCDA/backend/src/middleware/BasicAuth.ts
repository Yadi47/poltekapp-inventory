var auth = require("basic-auth");
export default (req: any, res: any, next: any) => {
  const token = "ardhi";
  let basicAuth = req.headers.authorization;
  var user = auth(req);
  console.log(user.name);
  if (user.name != token) {
    res.statusCode = 401;
    // res.setHeader("WWW-Authenticate", 'Basic realm="MyRealmName"');
    res.end("Unauthorized");
  } else {
    next();
  }
};
