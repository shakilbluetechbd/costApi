<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\costResource;
use App\Model\cost;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user= User::find(Auth()->id());
        $costs = $user->costs;
        return $this->sendResponse($costs, "successful");
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
        $cost = new cost;
        $cost->name = $request->name;
        $cost->details = $request->details;
        $cost->value = $request->value;
        $cost->date = $request->date;
        $cost->user_id = Auth::id();
        $cost->save();
        return response([
            'data' => new costResource($cost),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function show(cost $cost)
    {
        //
        if (Auth::id() != $cost->user_id) {
            return $this->sendError("Not the owner");
        }
        return $this->sendResponse($cost, "successful");
        // return response([
        //     'data' => new costResource($cost)
        // ],Response::HTTP_CREATED);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function edit(cost $cost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cost $cost)
    {
        if (Auth::id() != $cost->user_id) {
            return $this->sendError("Not the owner");
        }
        $request->user_id = Auth::id();
        $cost->update($request->all());
        return $this->sendResponse($request->all(), "successful");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function destroy(cost $cost)
    {
        $cost->delete();
        return $this->sendResponse($cost, "Deleted");
    }
    public function CostUserCheck($Cost)
    {
        if (Auth::id() !== $Cost->user_id) {
            // throw new CostNotBelongsToUser;
            return ['errors' => 'Product Not Belongs to User'];
        }
    }
}
