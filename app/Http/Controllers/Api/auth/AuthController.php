<?php

namespace App\Http\Controllers\Api\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{
    /**
     * @apiDefine headerjson
     * @apiHeader {json} Accept
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Accept": "application/json"
     *     }
     */

    /**
     * @api {post} /api/register 02 Register
     * @apiVersion 0.0.1
     * @apiGroup Auth
     * @apiName Register
     * @apiDescription Service for new users registration.
     * @apiUse headerjson
     * @apiBody {string{3..50}} name Nombre del usuario que se registra
     * @apiBody {string{2...}} email Email del usuario que se registra unique EMAIL
     * @apiBody {string{8..30}} password Contraseña del del usuario que se registra
     * @apiBody {string{8..30}} confirm_password Confirmacion de contraseña
     * @apiParamExample {json} Request-Example:
     *     {
     *          "name"              : "Shakira Shakira",
     *          "email"             : "cgtest@gmail.com",
     *          "password"          : "12345678",
     *          "confirm_password"  : "12345678",
     *     }
     * @apiPermission none
     * @apiSuccess {String} token User Access token
     * @apiSuccess {User} user  User Data.
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMTRjY2JiYjVlOWRkOTQ4ZDU3MGU3MThhZDA5M2ZkMWI4Y2VjZjU1OGFjNzA0OGVjYWE0OThiMTBjODQxMzUyMGMyNjlhNGJlMWQyM2I0YzciLCJpYXQiOjE2NzQwNDQ0NDkuMDM0ODEzLCJuYmYiOjE2NzQwNDQ0NDkuMDM0ODE5LCJleHAiOjE3MDU1ODA0NDkuMDIxMjM3LCJzdWIiOiIzIiwic2NvcGVzIjpbXX0.UPEK_5yELNd4iOJEdOwU_IhaYPM798or3ocJ_jnyvTlVlGNdSWf6wNNPtDLjLe0Y3VD4u7b_qrUZpUZzNd7-cMH_I8J-hJCj2QmGXejEn1EhSd3ntbafEQ8I5bPOl5WcqqmaNPd832jD5IWIP0Ce5XcvlU7xfmP180l08N_nP2FpOj68jcIWM_MUVrO_LzPdbHuPuCjTjhRPpK5zC1vHSF6qo3AxsR22qlev6nSwddjYx1xf583ZHYMXJds3hUZO9wdzTvZ8iU9BwAYxaXE-4e504nC5px79HfGx-AljxJd9XrTxRE0DCHXV-_9zTGvDQf5FS5VDbMom35DYyrNPWqdfL3WMlabSAyhXxcTpxrLHIZJolWMW6u3AQRB-2C_HQZm837Eg-AwXGF_uC-SAz-X95VZziL5yuoajkI1C8eOiRsSEiQ2dWXzulz1SO_EzEAi3QYxmeaA8I94CWebtwZDJXSRqtft088ePfiwTLu0PeEg2Ucfy74pfKZ00OA6gKW1q1fg_LLd8dGgRXkrHpypGL8JgMJJ_6CVIXZko_0cB2Q-VwUrCAmPWtTwKTfy_70_cpTv3lJ-eLRQ1S8WSeqfNnPmhLjtcroA-dPl7oJmSEC55PSsIjMaHREuYEZrxoGFpj7Egy5UIi7cFVAhSMP6mXt9Ew2JcMfiihCbQUmo",
     *      "user": {
     *          "id": 3
     *          "name": "Another Photographer",
     *          "email": "cgtest@gmail.com",
     *          "phone": "333-333-3333",
     *          "bio": "Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam id consectetur aperiam obcaecati quasi aliquid beatae quibusdam, blanditiis ratione accusamus veritatis. Officia enim numquam tenetur",
     *          "created_at": "2023-01-18T12:20:48.000000Z",
     *      }
     *  }
     * @apiError (422) Valitador data inserted has errors or is not found in the request
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 422 Unprocessable Content
     *      {
     *       "error": {
     *          "name": [
     *             "The name field is required.",
     *             "The name must be at least 3 characters.",
     *             "The name may not be greater than 50 characters."
     *          ],
     *          "email": [
     *              "The email has already been taken.",
     *              "The email must be a valid email address."
     *          ],
     *          "bio": [
     *             "The bio field is required.",
     *          ],
     *          "phone": [
     *             "The phone field is required.",
     *             "The phone must be at least 10 characters."
     *          ],
     *          "password": [
     *             "The password field is required.",
     *             "The password must be at least 8 characters."
     *          ],
     *          "confirm_password": [
     *             "The confirm password field is required.",
     *             "The confirm password and password must match."
     *          ],
     *       }
     *      }
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50|min:3',
            'email' => 'required|email',
            'phone' => 'required|string|min:10',
            'bio' => 'required|string',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $input = $request->all();
        $input['password'] = bcrypt($request->get('password'));
        $user = User::create($input);
        $token =  $user->createToken(env('SECRET_TOKEN'))->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ], 200);
    }

    /**
     * @api {post} /api/login 01 Login
     * @apiVersion 0.0.1
     * @apiGroup Auth
     * @apiName Login
     * @apiDescription Allows users to login into the platform using email and password.
     * @apiUse headerjson
     * @apiBody {string{2...}} email User's email required to login unique EMAIL
     * @apiBody {string{8..30}} password Assciated password for the account
     * @apiParamExample {json} Request-Example:
     *     {
     *          "email"             : "cgtest@gmail.com",
     *          "password"          : "12345678",
     *     }
     * @apiPermission none
     * @apiSuccess {String} token User Access token
     * @apiSuccess {User} user  User information.
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOTM5MGQxM2FiMDg2NjUwOTQyY2UxMTJhYmMxYzVjZTJhZTMxNTZmM2FkMzA3NmY2MDc1OTE4NmM0MTkwOWVlMmNjOTgwYWE0MjFiOGUzOWYiLCJpYXQiOiIxNjExMjc5OTk2Ljg0OTY2MyIsIm5iZiI6IjE2MTEyNzk5OTYuODQ5NjcxIiwiZXhwIjoiMTY0MjgxNTk5Ni44NDI3NjUiLCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.lH44AyTb_tWMnCNXAtRlEG-dOTEmKM6FIGpPqV31iyqN3I0byKvj_vlzF8llGOXUwDH-YPgoTSVK1j8zVacHfhS7aZ2mmzL_R8_Nr5f-Ecptl8nlpfW6micPDzkG-PcIlWSRxe8Ss3X5yzjbjGtneRB7dUyN-mRSA1vdUDTVhITnepAleJ-KnS5w8Ip3qGpgq6ro0KHMnAR2GPivXx3h0XT8JQGhVLI7LbQHLoZqPyL0xTYosbKy_mttwXIxipgQ4JHsy7qOaFbR3YawJ0Upr4UNr31hCn1UrR8WKaGr2A7hCBHm2aruhgIAIievEAOzmJcbP7n_sARW2jyuGgnGUq4uo28yv0o_ylbLpnNNupZLnQaErx0os2YHV8SDU4ZcmG2ZtZTVrSHL4L-khsGu0oVOUybZJ5xBW6-xef5VXKjWL00l8124DjyNHB5usrjpkcHsuD6gJE9MPmEZgn_S7iye_m6G6cXlCQzzHV0o3m9kdF3Y5l3QLUvW1l2rJmAPB-vOrxgRLqtGjCE6pcLUX8l8EDq0tqoijMIrG1GGxlsA2Z8dOFCcMTeD0hLlaCRx-G3XCtZ6P0V0X5bcSxSdonY8dGrpkPqlCP4Xa4qNEFDlDLvvHB2WscquXia1Rxfgg6q_qdZE7z_ZAGKJHkZq6pji56mIAKgcXPfB6bVknIA",
     *      "user": {
     *          "id": 2,
     *          "name": "Shakira Shakira",
     *          "phone": "555-555-5555",
     *          "bio": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ",
     *          "profile_picture": "img/profile.png",
     *          "email": "cgtest@gmail.com",
     *          "email_verified_at": null,
     *          "created_at": "2015-05-01T00:00:00.000000Z",
     * }
     * @apiError (422) Valitador inserted data has errors
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 422 Unprocessable Content
     *      {
     *       "error": {
     *          "email": [
     *              "The email field is required."
     *              "The email must be a valid email address.",
     *          ],
     *          "password": [
     *             "The password field is required.",
     *             "The password must be at least 8 characters."
     *          ],
     *       }
     *      }
     * @apiError (401) Valitador Data inserted not match for any account
     * @apiErrorExample {json} Error-Response:
     *      HTTP/1.1 401 Unauthorized
     *      {
     *          "error": "Unauthorised"
     *      }
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token =  $user->createToken(env('SECRET_TOKEN'))->accessToken;
            return response()->json([
                'token' => $token,
                'user' => $user
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
