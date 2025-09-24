<?php  

namespace App\Http\Controllers\Api;  
use App\Http\Controllers\Controller;
use App\Http\Requests\ExportItemRequest;
use App\Repositories\ExportItemRepository;
use Illuminate\Http\Request; 


class ExportItemController extends Controller
{
    protected ExportItemRepository $exportItemRepository;

    public function __construct(ExportItemRepository $exportItemRepository)
    {
        $this->exportItemRepository = $exportItemRepository;
    }

    /**
     * Lấy danh sách các mặt hàng theo export ID
     */
    public function getItemsByExportId($exportId)
    {
        $items = $this->exportItemRepository->getByExportId($exportId);
        return response()->json($items);
    }
}