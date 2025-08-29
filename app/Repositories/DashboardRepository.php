<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Expense;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class DashboardRepository
{

    private $type;
    private $date;

    public function __construct(Request $request)
    {
        
        $this->date = $request->input('date') ?? Carbon::now()->toDateString();
        $this->type = $request->input('filter_type', 'day'); // day, month, year
    }

    function whereTime($query, $field)
    {
        if ($this->type === 'day') {
            $query->whereDate($field, '=', $this->date);
        } elseif ($this->type === 'month') {
            $date = Carbon::parse($this->date);
            $query->whereYear($field, $date->year)
                  ->whereMonth($field, $date->month);
        } elseif ($this->type === 'year') {
            $date = Carbon::parse($this->date);
            $query->whereYear($field, $date->year);
        }
        return $query;
    }
    
    public function revenue()
    {
        $query = DB::table('orders');
        return $this->whereTime($query, 'order_date')
                    ->sum('final_amount');
    }

    public function discount()
    {
        $query = DB::table('orders');
        return $this->whereTime($query, 'order_date')
                    ->sum('discount_amount');
    }

    public function expense()
    {
        $query = DB::table('expenses');
        return $this->whereTime($query,'expense_date')
                    ->sum('amount');
    }

    public function gift()
    {
        $query = DB::table('items')
                ->join('orders', 'items.order_id', '=', 'orders.id')
                ->where('items.is_gift', 1);

        return $this->whereTime($query, 'orders.order_date')
                    ->sum('items.subtotal');
    }

    public function profit()
    {
        $query = DB::table('items')
                ->join('orders', 'items.order_id', '=', 'orders.id')
                ->where('items.is_gift', 0);

        return $this->whereTime($query, 'orders.order_date')
                    ->sum(DB::raw('((items.product_price_output - items.product_price_input) * items.quantity - items.discount)'));
    }

    public function inventory()
    {
        return DB::table('products')
                ->selectRaw('SUM(price_input * quantity) as total')
                ->value('total');
    }

    public function profitMonths()
    {
        $year = $this->type === 'year' ? $this->date : Carbon::now()->year;

        // Khởi tạo mảng 12 tháng, mặc định 0
        $profits = array_fill(1, 12, 0);

        // Lấy lợi nhuận từng tháng
        $data = DB::table('items')
            ->join('orders', 'items.order_id', '=', 'orders.id')
            ->where('items.is_gift', 0)
            ->whereYear('orders.order_date', $year)
            ->select(
                DB::raw('MONTH(orders.order_date) as month'),
                DB::raw('SUM((items.product_price_output - items.product_price_input) * items.quantity - items.discount) as profit')
            )
            ->groupBy(DB::raw('MONTH(orders.order_date)'))
            ->get();

        // Gán lợi nhuận vào mảng 12 tháng
        foreach ($data as $row) {
            $profits[$row->month] = (float)$row->profit;
        }

        return $profits;
    }
}
