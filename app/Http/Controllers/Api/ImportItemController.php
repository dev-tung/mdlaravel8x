<?php  

namespace App\Http\Controllers\Api;  
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportItemRequest;
use App\Repositories\ImportItemRepository;
use Illuminate\Http\Request; 


class ImportItemController extends Controller
{
    protected ImportItemRepository $importItemRepository;

    public function __construct(ImportItemRepository $importItemRepository)
    {
        $this->importItemRepository = $importItemRepository;
    }

    /**
     * Lấy danh sách các mặt hàng theo import ID
     */
    public function getItemsByImportId($importId)
    {
        $items = $this->importItemRepository->getByImportId($importId);
        return response()->json($items);
    }
}