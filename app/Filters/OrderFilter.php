<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class OrderFilter
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $query)
    {
        $this->applyStatusFilter($query);
        $this->applyAmountFilter($query);
        $this->applyDateFilter($query);

        return $query;
    }

    protected function applyStatusFilter(Builder $query)
    {
        if ($this->request->has('status')) {
            $query->where('status', $this->request->input('status'));
        }
    }

    protected function applyAmountFilter(Builder $query)
    {
        if ($this->request->has('amount_min')) {
            $query->where('amount', '>=', $this->request->input('amount_min'));
        }

        if ($this->request->has('amount_max')) {
            $query->where('amount', '<=', $this->request->input('amount_max'));
        }
    }

    protected function applyDateFilter(Builder $query)
    {
        if ($this->request->has('created_from')) {
            $query->whereDate('created_at', '>=', $this->request->input('created_from'));
        }

        if ($this->request->has('created_to')) {
            $query->whereDate('created_at', '<=', $this->request->input('created_to'));
        }
    }
}
