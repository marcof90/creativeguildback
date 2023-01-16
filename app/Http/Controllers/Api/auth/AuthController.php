<?php

namespace App\Http\Controllers\Api;

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
     *       "Accept": "Accept: application/json"
     *     }
     */

    /**
     * @apiGroup Auth
     * @apiName Registro
     * @apiDescription Registro de usuarios nuevos.
     * @api {post} /api/register 02 Register
     * @apiUse headerjson
     * @apiParam {string{3..50}} name Nombre del usuario que se registra
     * @apiParam {string{2...}} email Email del usuario que se registra unique EMAIL
     * @apiParam {string{8..30}} password Contraseña del del usuario que se registra
     * @apiParam {string{8..30}} confirm_password Confirmacion de contraseña
     * @apiParamExample {json} Request-Example:
     *     {
     *          "name"              : "juan",
     *          "email"             : "alertas@gmail.com",
     *          "password"          : "12345678",
     *          "confirm_password"  : "12345678",
     *     }
     * @apiPermission admin
     * @apiSuccess {String} token Token de acceso del usuario.
     * @apiSuccess {User} user  Datos del usuario.
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *  "user": {
     *      "id": 4
     *      "email": "email@gmail.com",
     *      "name": "nombre",
     *      "updated_at": "2021-01-22T03:45:16.000000Z",
     *      "created_at": "2021-01-22T03:45:16.000000Z",
     *      }
     *  }
     * @apiError (422) Valitador error en los datos ingresados
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 422 Unprocessable Entity
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
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $input = $request->all();
        $input['password'] = bcrypt($request->get('password'));
        $user = User::create($input);
        $token =  $user->createToken('creativeguild-app')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ], 200);
    }

    /**
     * @apiGroup Auth
     * @apiName Login
     * @apiDescription Login de usuario.
     * @api {post} /api/login 01 Login
     * @apiUse headerjson
     * @apiParam {string{2...}} email Email del usuario que ingresa unique EMAIL
     * @apiParam {string{8..30}} password Contraseña del del usuario que ingresa
     * @apiParamExample {json} Request-Example:
     *     {
     *          "email"             : "alertas@gmail.com",
     *          "password"          : "12345678",
     *     }
     * @apiPermission none
     * @apiSuccess {String} token Token de acceso del usuario.
     * @apiSuccess {User} user  Datos del usuario.
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOTM5MGQxM2FiMDg2NjUwOTQyY2UxMTJhYmMxYzVjZTJhZTMxNTZmM2FkMzA3NmY2MDc1OTE4NmM0MTkwOWVlMmNjOTgwYWE0MjFiOGUzOWYiLCJpYXQiOiIxNjExMjc5OTk2Ljg0OTY2MyIsIm5iZiI6IjE2MTEyNzk5OTYuODQ5NjcxIiwiZXhwIjoiMTY0MjgxNTk5Ni44NDI3NjUiLCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.lH44AyTb_tWMnCNXAtRlEG-dOTEmKM6FIGpPqV31iyqN3I0byKvj_vlzF8llGOXUwDH-YPgoTSVK1j8zVacHfhS7aZ2mmzL_R8_Nr5f-Ecptl8nlpfW6micPDzkG-PcIlWSRxe8Ss3X5yzjbjGtneRB7dUyN-mRSA1vdUDTVhITnepAleJ-KnS5w8Ip3qGpgq6ro0KHMnAR2GPivXx3h0XT8JQGhVLI7LbQHLoZqPyL0xTYosbKy_mttwXIxipgQ4JHsy7qOaFbR3YawJ0Upr4UNr31hCn1UrR8WKaGr2A7hCBHm2aruhgIAIievEAOzmJcbP7n_sARW2jyuGgnGUq4uo28yv0o_ylbLpnNNupZLnQaErx0os2YHV8SDU4ZcmG2ZtZTVrSHL4L-khsGu0oVOUybZJ5xBW6-xef5VXKjWL00l8124DjyNHB5usrjpkcHsuD6gJE9MPmEZgn_S7iye_m6G6cXlCQzzHV0o3m9kdF3Y5l3QLUvW1l2rJmAPB-vOrxgRLqtGjCE6pcLUX8l8EDq0tqoijMIrG1GGxlsA2Z8dOFCcMTeD0hLlaCRx-G3XCtZ6P0V0X5bcSxSdonY8dGrpkPqlCP4Xa4qNEFDlDLvvHB2WscquXia1Rxfgg6q_qdZE7z_ZAGKJHkZq6pji56mIAKgcXPfB6bVknIA",
     *      "user": {
     *          "id": 2,
     *          "name": "Admin xyz",
     *          "email": "hospitalxyz@gmail.com",
     *          "email_verified_at": null,
     *          "created_at": "2021-01-21T20:46:23.000000Z",
     *          "updated_at": null
     * }
     * @apiError (422) Valitador error en los datos ingresados
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 422 Unprocessable Entity
     *      {
     *       "error": {
     *          "email": [
     *              "The email must be a valid email address."
     *          ],
     *          "password": [
     *             "The password field is required.",
     *             "The password must be at least 8 characters."
     *          ],
     *       }
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
            $token =  $user->createToken('creativeguild-app')->accessToken;
            return response()->json([
                'token' => $token,
                'user' => $user
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
