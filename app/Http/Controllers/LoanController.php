<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\loanResource;
use App\Model\loan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoanController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $loans= loan::where('user_id',Auth()->id())->orderBy('id', 'DESC')->paginate($request->per_page);
        return $this->sendResponse($loans, "successful");
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
        $loan = new loan;
        $loan->name = $request->name;
        $loan->details = $request->details;
        $loan->value = $request->value;
        $loan->date = $request->date;
        $loan->user_id = Auth::id();
        $loan->save();
        return response([
            'data' => new loanResource($loan),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(loan $loan)
    {
        //
        if (Auth::id() != $loan->user_id) {
            return $this->sendError("Not the owner");
        }
        return $this->sendResponse($loan, "successful");
        // return response([
        //     'data' => new loanResource($loan)
        // ],Response::HTTP_CREATED);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, loan $loan)
    {
        if (Auth::id() != $loan->user_id) {
            return $this->sendError("Not the owner");
        }
        $request->user_id = Auth::id();
        $loan->update($request->all());
        return $this->sendResponse($request->all(), "successful");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(loan $loan)
    {
        $loan->delete();
        return $this->sendResponse($loan, "Deleted");
    }
    public function LoanUserCheck($Loan)
    {
        if (Auth::id() !== $Loan->user_id) {
            // throw new LoanNotBelongsToUser;
            return ['errors' => 'Product Not Belongs to User'];
        }
    }
}
