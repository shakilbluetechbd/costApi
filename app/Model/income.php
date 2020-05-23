<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class income extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User', 'foreign_key', 'other_key');
    }
    //
    public function scopeSearch($query, $user_id, $name, $toDate , $fromDate, $toValue , $fromValue, $sortBy,$per_page)
    {
        $select = DB::table('incomes');
        if (!empty($user_id)) {
            $select->where('user_id', "=", $user_id);
        }
        if (!empty($name)) {
            $select->where('name', 'like', '%' . $name . '%');
        }
        $select->whereBetween('value', [$fromValue, $toValue]);
        $select->whereBetween('date', [$fromDate, $toDate]);
        $select->orderBy($sortBy['name'], $sortBy['value']);
        $data = $select->paginate($per_page);
        return  $data;
    }

    public function scopeReport($query, $user_id, $name, $toDate , $fromDate, $toValue , $fromValue, $sortBy,$per_page)
    {
        $select = DB::table('incomes');
        if (!empty($user_id)) {
            $select->where('user_id', "=", $user_id);
        }
        if (!empty($name)) {
            $select->where('name', 'like', '%' . $name . '%');
        }
        $select->whereBetween('value', [$fromValue, $toValue]);
        $select->whereBetween('date', [$fromDate, $toDate]);
        $select->orderBy($sortBy['name'], $sortBy['value']);
        $report= (object)[];
        $report->total = $select->sum('value');
        $report->average = round($select->avg('value'),2);
        $report->count = $select->count();
        return  $report;
    }
}
