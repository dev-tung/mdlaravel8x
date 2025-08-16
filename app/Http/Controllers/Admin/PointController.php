<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PointRepository;
use App\Repositories\CustomerRepository;

class PointController extends Controller
{
    protected $points;
    protected $customers;

    public function __construct(PointRepository $points, CustomerRepository $customers)
    {
        $this->points = $points;
        $this->customers = $customers;
    }

    public function index()
    {
        $points = $this->points->getAll();
        return view('admin.points.index', compact('points'));
    }

    public function create()
    {
        $customers = $this->customers->getAll();
        return view('admin.points.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'points' => 'required|integer',
            'type' => 'required|in:earn,spend',
            'description' => 'nullable|string',
        ]);

        $this->points->create($request->all());

        return redirect()->route('admin.points.index')->with('success', 'Điểm đã được thêm.');
    }

    public function show($id)
    {
        $point = $this->points->find($id);
        return view('admin.points.show', compact('point'));
    }

    public function edit($id)
    {
        $point = $this->points->find($id);
        $customers = $this->customers->getAll();
        return view('admin.points.edit', compact('point', 'customers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'points' => 'required|integer',
            'type' => 'required|in:earn,spend',
            'description' => 'nullable|string',
        ]);

        $this->points->update($id, $request->all());

        return redirect()->route('admin.points.index')->with('success', 'Cập nhật điểm thành công.');
    }

    public function destroy($id)
    {
        $this->points->delete($id);
        return redirect()->route('admin.points.index')->with('success', 'Xóa điểm thành công.');
    }
}
