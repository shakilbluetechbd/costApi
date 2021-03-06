<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\assetResource;
use App\Model\asset;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AssetController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {

            $assets = asset::where('user_id', Auth()->id())->orderBy('id', 'DESC')->paginate($request->per_page);
            return $this->sendResponse($assets, "Assets fetched successfully");
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
        $asset = new asset;
        $asset->name = $request->name;
        $asset->details = $request->details;
        $asset->value = $request->value;
        $asset->date = $request->date;
        $asset->user_id = Auth::id();

        try {
            $asset->save();
            return $this->sendResponse($asset, "Asset created successfully");
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function show(asset $asset)
    {
        try {
            if (Auth::id() !== $asset->user_id) {
                throw new Exception("Permission denied");
            }
            return $this->sendResponse($asset, "successful");
        } catch (\Exception $e) {
            return $this->sendError($e);
        }


        //
        // if (Auth::id() != $asset->user_id) {
        //     return $this->sendError("Not the owner");
        // }
        // return $this->sendResponse($asset, "successful");
        // return response([
        //     'data' => new assetResource($asset)
        // ],Response::HTTP_CREATED);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit(asset $asset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, asset $asset)
    {
        if (Auth::id() != $asset->user_id) {
            return $this->sendError("Not the owner");
        }

        try {
            $request->user_id = Auth::id();
            $asset->update($request->all());
            return $this->sendResponse($request->all(), "Update successful");
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(asset $asset)
    {
        try {
            $asset->delete();
            return $this->sendResponse($asset, "Deleted");
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
    public function AssetUserCheck($Asset)
    {
        if (Auth::id() !== $Asset->user_id) {
            // throw new AssetNotBelongsToUser;
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
            $asset = asset::Search($user_id, $name, $toDate, $fromDate, $toValue, $fromValue, $sortBy, $per_page);
            return $this->sendResponse($asset, "Assets fetched successfully");
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
            $asset = asset::Report($user_id, $name, $toDate, $fromDate, $toValue, $fromValue, $sortBy, $per_page);
            return $this->sendResponse($asset, "Report fetched successfully");
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
}
