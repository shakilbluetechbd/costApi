<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\costResource;
use App\Model\cost;
use App\User;
use Exception;
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
    public function index(Request $request)
    {
        try {

            $costs = cost::where('user_id', Auth()->id())->orderBy('id', 'DESC')->paginate($request->per_page);
            return $this->sendResponse($costs, "Costs fetched successfully");
        } catch (\Exception $e) {

            return $this->sendError($e);
        }
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

        try {
            $cost->save();
            return $this->sendResponse($cost, "Cost created successfully");
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function show(cost $cost)
    {
        try {
            if (Auth::id() !== $cost->user_id) {
                throw new Exception("Permission denied");
            }
            return $this->sendResponse($cost, "successful");
        } catch (\Exception $e) {
            return $this->sendError($e);
        }


        //
        // if (Auth::id() != $cost->user_id) {
        //     return $this->sendError("Not the owner");
        // }
        // return $this->sendResponse($cost, "successful");
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

        try {
            $request->user_id = Auth::id();
            $cost->update($request->all());
            return $this->sendResponse($request->all(), "Update successful");
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function destroy(cost $cost)
    {
        try {
            $cost->delete();
            return $this->sendResponse($cost, "Deleted");
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
    public function CostUserCheck($Cost)
    {
        if (Auth::id() !== $Cost->user_id) {
            // throw new CostNotBelongsToUser;
            return ['errors' => 'Product Not Belongs to User'];
        }
    }

    public function search(Request $request)
    {
        $name = $request->name;
        $toDate = $request->toDate ? $request->toDate : "3000-02-04";
        $fromDate = $request->fromDate ? $request->fromDate : "1900-02-04";
        $toValue = $request->toValue ? $request->toValue : "10000000";
        $fromValue = $request->fromValue ? $request->fromValue : "0";
        $sortBy = $request->sortBy ? $request->sortBy : ["name" => "id", "value" => "DESC"];
        $per_page = $request->per_page;
        $user_id = Auth::id();
        try {
            $costs = cost::Search($user_id, $name, $toDate, $fromDate, $toValue, $fromValue, $sortBy, $per_page);
            return $this->sendResponse($costs, "Costs fetched successfully");
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function report(Request $request)
    {
        $name = $request->name;
        $toDate = $request->toDate ? $request->toDate : "3000-02-04";
        $fromDate = $request->fromDate ? $request->fromDate : "1900-02-04";
        $toValue = $request->toValue ? $request->toValue : "10000000";
        $fromValue = $request->fromValue ? $request->fromValue : "0";
        $sortBy = $request->sortBy ? $request->sortBy : ["name" => "id", "value" => "DESC"];
        $per_page = $request->per_page;
        $user_id = Auth::id();
        try {
            $costs = cost::Report($user_id, $name, $toDate, $fromDate, $toValue, $fromValue, $sortBy, $per_page);
            return $this->sendResponse($costs, "Report fetched successfully");
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
}
