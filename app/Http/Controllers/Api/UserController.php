<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->only(['show']);
    }

    /**
     * @api {get} /users/ 01 Users list
     * @apiVersion 0.0.1
     * @apiGroup Users
     * @apiName Users list
     * @apiDescription fetch a lists of registrated users
     * @apiHeader {json} Accept
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Accept": "application/json"
     *     }
     * @apiPermission none
     * @apiSampleRequest http://localhost:8001/api/users
     * @apiSuccess {json} Json wiht a list of users
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "users": [
     *          {
     *              "id": 1,
     *              "name": "Marco Sanabria",
     *              "phone": "555-555-5555",
     *              "bio": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ",
     *              "profile_picture": "img/marco.png",
     *              "email": "ingmarcosanabria@gmail.com",
     *              "email_verified_at": null,
     *              "created_at": "2015-05-01T00:00:00.000000Z"
     *          },
     *          {
     *              "id": 2,
     *              "name": "Nandhaka Pieris",
     *              "phone": "555-555-5555",
     *              "bio": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ",
     *              "profile_picture": "img/profile.png",
     *              "email": "nick.reynolds@domain.co",
     *              "email_verified_at": null,
     *              "created_at": "2015-05-02T00:00:00.000000Z"
     *          },
     *          {
     *              "id": 3,
     *              "name": "Another Photographer",
     *              "phone": "333-333-3333",
     *              "bio": "Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam id consectetur aperiam obcaecati quasi aliquid beatae quibusdam, blanditiis ratione accusamus veritatis. Officia enim numquam tenetur",
     *              "profile_picture": "img/profile.png",
     *              "email": "cgtest@gmail.com",
     *              "email_verified_at": null,
     *              "created_at": "2023-01-18T12:20:48.000000Z"
     *          }
     *      ]
     *  }
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json(['users' => User::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * @api {get} /users/:id 02 Get User by id
     * @apiVersion 0.0.1
     * @apiGroup Users
     * @apiName Get User by id
     * @apiDescription fetch a user photographer with his album.
     * @apiHeader {json} Accept
     * @apiHeaderExample {json} Header-Example:
     * {
     *      "Accept": "application/json",
     *      "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZDg1NDliYzAxZWM5MGZhMzBjODNiNjI5YWQyY2QwY2QyMmNmZmMwZDc5ZDQ1ZGU4ZTRkZGMzNTQ0NzBlYmE1MGQ3MDhlNDRkZTdkZmY0M2EiLCJpYXQiOjE2NzM4OTUzOTYuOTUwNjI1LCJuYmYiOjE2NzM4OTUzOTYuOTUwNjI5LCJleHAiOjE3MDU0MzEzOTYuOTQzODcxLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.KDdwiNjPOi0qFEvYlFhE_AkyYKpCXDlmdt8pWg9nWGbWv9ZVOCOmELbOlVvlRwZz2_00UOpX1RmXQU2poK4JpktvL4DGwyRmuFPU1snXT7NJJPQTaE3SlRPJzCNI3lv3oP1FVcFMERCeFsBetfT8bcjuaYn0jF4Ys3GgCn-_1VyN7wz_7o1RqWsdNDFeDIzk2Ui26YPhgfnU7Mi35096mrVrDdw7_zptZl2VodJErbbg4YnpoyqGng8DE95XFea73c0-scIEEwkQt60GXCsBp019rPIhn5pwyZcxHHtuqRXL5IFV5HEaMmp17CRGrcYBAyhYAeeiVVQarJqtY11tFqcqqWR_lOyJKR3PnHybaKgoM3QdsCuRWlruXpVHtY7D-Qzw_MlRU0JhRTD7K0NRk4Zy6xHGP9guzuJrnLPUwqfPj8cKEb4T5mfaJ5tuLkqeaLFKNY6JSqDg1j7AfAAe8_LHuWVxoGu0AETUHvoVOt1uCgorrwe-e4_G8xKclxUo2qI9jZGxHLkdqpAUmXe-usPV8Pdh1oVCbfjiPeAGnYdVUJDeYrvDdbf0meVvXnxTslsJaA2cPllbf6CKiWo2LR25je1huCuRZFj0WdFh6D7qhIfSO6WQh2mtPZ4CJ2Yt38a59jSxlfF3QjDsQcUepJtWYkWZ9lyBJRACjsuY4zk"
     * }
     * @apiParam {Number} id Users unique ID
     * @apiPermission Auth authorization Bearer Token
     * @apiSuccess {json} Users photographer information with album
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "id": 1,
     *      "name": "Marco Sanabria",
     *      "phone": "555-555-5555",
     *      "bio": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ",
     *      "profile_picture": "img/marco.png",
     *      "email": "ingmarcosanabria@gmail.com",
     *      "email_verified_at": null,
     *      "created_at": "2015-05-01T00:00:00.000000Z",
     *      "album": [
     *          {
     *              "id": 1,
     *              "title": "Nandhaka Pieris",
     *              "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
     *              "img": "img/landscape1.jpg",
     *              "featured": 1,
     *              "created_at": "2015-05-01 00:00:00",
     *              "updated_at": null,
     *              "album_id": 1
     *          },
     *          {
     *              "id": 2,
     *              "title": "New West Calgary",
     *              "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
     *              "img": "img/landscape2.jpg",
     *              "featured": 0,
     *              "created_at": "2016-05-01 00:00:00",
     *              "updated_at": null,
     *              "album_id": 1
     *          },
     *          {
     *              "id": 3,
     *              "title": "Australian Landscape",
     *              "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
     *              "img": "img/landscape3.jpg",
     *              "featured": 0,
     *              "created_at": "2016-05-02 00:00:00",
     *              "updated_at": null,
     *              "album_id": 1
     *          },
     *          {
     *              "id": 4,
     *              "title": "Halvergate Marsh",
     *              "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
     *              "img": "img/landscape4.jpg",
     *              "featured": 1,
     *              "created_at": "2014-04-01 00:00:00",
     *              "updated_at": null,
     *              "album_id": 1
     *          },
     *          {
     *              "id": 5,
     *              "title": "Rikkis Landscape",
     *              "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
     *              "img": "img/landscape5.jpg",
     *              "featured": 0,
     *              "created_at": "2010-09-01 00:00:00",
     *              "updated_at": null,
     *              "album_id": 1
     *          },
     *          {
     *              "id": 6,
     *              "title": "Kiddi Kristjans Iceland",
     *              "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
     *              "img": "img/landscape6.jpg",
     *              "featured": 1,
     *              "created_at": "2015-07-21 00:00:00",
     *              "updated_at": null,
     *              "album_id": 1
     *          }
     *      ]
     *  }
     * @apiError (404) Exception id user param sent does not exist on the data base
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *      {
     *          "message": "No query results for model [App\\Models\\User] 4"
     *      }
     * @apiError (401) Unauthorized missed Authorization header or expired token
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 401 Unauthorized
     *      {
     *          "message": "Unauthenticated."
     *      }
     */
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        $user = User::findOrFail($user->id);

        $response = $user;
        $response->album = User::findOrFail($user->id)->album->pictures;

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
