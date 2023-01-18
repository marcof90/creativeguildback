<?php

namespace App\Http\Controllers\Api\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    //
    /**
     * @apiDefine headerjson
     * @apiHeader {json} Accept
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Accept": "application/json"
     *     }
     */

    /**
     * @api {post} /password/reset 04 Reset Password
     * @apiVersion 0.0.1
     * @apiGroup Auth
     * @apiName Reset Password
     * @apiDescription Change the old password account using a verification code and the new password
     * @apiUse headerjson
     * @apiBody {string{6}} code Received code sent by email
     * @apiBody {string{8..30}} password Associated password for the account
     * @apiBody {string{8..30}} password_confirmation Password confirmation must match password param
     * @apiParamExample {json} Request-Example:
     *     {
     *          "code" : "J61Lvn",
     *          "password" : "newpassword"
     *          "password_confirmation" : "newpassword"
     *     }
     * @apiPermission none
     * @apiSuccess {json} message Confirmation message
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "message": "password updated"
     *  }
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 203 Non-Authoritative Information
     *  {
     *      "message": "Code expired"
     *  }
     * @apiError (422) Valitador inserted data has errors
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 422 Unprocessable Content
     *      {
     *          "message": "The given data was invalid.",
     *          "errors": {
     *              "code": [
     *                  "Code not valid"
     *                  "The code must not be greater than 6 characters.",
     *                  "The code must be at least 6 characters.",
     *                  "The code field is required."
     *              ],
     *              "password": [
     *                  "The password must be at least 6 characters.",
     *                  "The password confirmation does not match.",
     *                  "The password field is required."
     *              ]
     *          }
     *      }
     */
     /**
     * Change the password
     *
     * @param  mixed $request
     * @return json response
     */
    public function __invoke(ResetPasswordRequest $request)
    {
        $passwordReset = ResetPassword::firstWhere('code', $request->code);

        if ($passwordReset->expired()) {
            ResetPassword::where('email', $passwordReset->email)->delete();
            return response(['message' => 'Code expired'], 203);
        }

        $user = User::firstWhere('email', $passwordReset->email);

        $user->update(['password'=>Hash::make($request->only('password')['password'])]);

        ResetPassword::where('email', $passwordReset->email)->delete();

        return response(['message' => 'password updated'], 200);
    }
}
