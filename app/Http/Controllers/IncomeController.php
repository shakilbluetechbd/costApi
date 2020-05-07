<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\incomeResource;
use App\Model\income;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IncomeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user= User::find(Auth()->id());
        $incomes = $user->incomes;
        return $this->sendResponse($incomes, "successful");
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
        $income = new income;
        $income->name = $request->name;
        $income->details = $request->details;
        $income->value = $request->value;
        $income->date = $request->date;
        $income->user_id = Auth::id();
        $income->save();
        return response([
            'data' => new incomeResource($income),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\income  $income
     * @return \Illuminate\Http\Response
     */
    public function show(income $income)
    {
        //
        if (Auth::id() != $income->user_id) {
            return $this->sendError("Not the owner");
        }
        return $this->sendResponse($income, "successful");
        // return response([
        //     'data' => new incomeResource($income)
        // ],Response::HTTP_CREATED);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\income  $income
     * @return \Illuminate\Http\Response
     */
    public function edit(income $income)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\income  $income
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, income $income)
    {
        if (Auth::id() != $income->user_id) {
            return $this->sendError("Not the owner");
        }
        $request->user_id = Auth::id();
        $income->update($request->all());
        return $this->sendResponse($request->all(), "successful");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\income  $income
     * @return \Illuminate\Http\Response
     */
    public function destroy(income $income)
    {
        $income->delete();
        return $this->sendResponse($income, "Deleted");
    }
    public function IncomeUserCheck($Income)
    {
        if (Auth::id() !== $Income->user_id) {
            // throw new IncomeNotBelongsToUser;
            return ['errors' => 'Product Not Belongs to User'];
        }
    }
}
