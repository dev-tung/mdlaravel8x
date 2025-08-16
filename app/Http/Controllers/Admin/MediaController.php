<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\MediaRepository;

class MediaController extends Controller
{
    protected $media;

    public function __construct(MediaRepository $media)
    {
        $this->media = $media;
    }

    public function index()
    {
        $media = $this->media->getAll();
        return view('admin.media.index', compact('media'));
    }

    public function create()
    {
        return view('admin.media.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:5120', // tối đa 5MB
            'name' => 'nullable|string|max:255'
        ]);

        $this->media->upload($request->file('file'), $request->only('name'));

        return redirect()->route('admin.media.index')->with('success', 'Upload thành công');
    }

    public function show($id)
    {
        $media = $this->media->find($id);
        return view('admin.media.show', compact('media'));
    }

    public function destroy($id)
    {
        $this->media->delete($id);
        return redirect()->route('admin.media.index')->with('success', 'Xóa media thành công');
    }
}
