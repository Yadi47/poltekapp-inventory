import ResponseModifier from "../helper/ReponseModifier";
import {RESPONSE_MESSAGE} from '../Config/Const'
export abstract class Controller {
  public GET_ALL_SUCCESS: String = RESPONSE_MESSAGE.GET_ALL_SUCCESS;
  public GET_ALL_FAILED: String = RESPONSE_MESSAGE.GET_ALL_FAILED;
  public INSERT_SUCCESS: String = RESPONSE_MESSAGE.INSERT_SUCCESS;
  public INSERT_FAILED: String = RESPONSE_MESSAGE.INSERT_FAILED;
  public UPDATE_SUCCESS: String = RESPONSE_MESSAGE.UPDATE_SUCCESS;
  public UPDATE_FAILED: String = RESPONSE_MESSAGE.UPDATE_FAILED;
  public DELETE_SUCCESS: String = RESPONSE_MESSAGE.DELETE_SUCCESS;
  public DELETE_FAILED: String = RESPONSE_MESSAGE.DELETE_FAILED;
  public LOGIN_SUCCESS: String = RESPONSE_MESSAGE.LOGIN_SUCCESS;
  public LOGIN_FAILED: String = RESPONSE_MESSAGE.LOGIN_FAILED;
  timestamp(): String {
    return "2020";
  }

  response(
    successStatus: Boolean,
    code: number,
    messageResponse: String,
    data: any
  ): any {
    /*
    {
      success : true,
      code : 200,
      message : "Message success !",
      data : [],
    };

    */
    return ResponseModifier(successStatus, code, messageResponse, data);
  }

  message() {}
}
