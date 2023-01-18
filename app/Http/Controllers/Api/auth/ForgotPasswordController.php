<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Mail\SendCodeResetPassword;
use App\Models\ResetPassword;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
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
     * @api {post} password/email 03 Get code
     * @apiVersion 0.0.1
     * @apiGroup Auth
     * @apiName Get code
     * @apiDescription Sends a reset code to the mail given.
     * @apiUse headerjson
     * @apiBody {string{2...}} email User's email required to sent the code
     * @apiParamExample {json} Request-Example:
     *     {
     *          "email" : "cgtest@gmail.com",
     *     }
     * @apiPermission none
     * @apiExample {curl} Example usage:
     *     curl -i http://localhost/api/password/email
     * @apiSuccess {String} message Confirmation message
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "message": "We have emailed your password reset link!"
     *  }
     * @apiError (422) Valitador inserted data has errors
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 422 Unprocessable Content
     *      {
     *          "message": "The given data was invalid.",
     *          "errors": {
     *              "email": [
     *                  "The selected email is invalid.",
     *                  "The email field is required."
     *              ]
     *          }
     *      }
     */
     /**
     * Sent reset code
     *
     * @param  mixed $request
     * @return json response
     */
    public function __invoke(ForgotPasswordRequest $request)
    {
        $data = $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        ResetPassword::where('email', $request->email)->delete();

        $data['code'] = Str::random(6);

        $codeData = ResetPassword::create($data);

        Mail::to($request->email)->send(new SendCodeResetPassword($codeData->code));

        return response(['message' => trans('passwords.sent')], 200);
    }
}
