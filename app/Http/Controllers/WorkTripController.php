<?php

namespace App\Http\Controllers;

use App\Http\Resources\WorkTripResource;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Service\WorkTripService;
use App\Utils\AreaNameEnum;
use App\Utils\WorkTripStatusEnum;
use Illuminate\Http\JsonResponse;

class WorkTripController extends Controller
{
    private IWorkTripRepository $workTripRepos;

    public function __construct(IWorkTripRepository $workTripRepos)
    {
        $this->workTripRepos = $workTripRepos;

        $this->initAuthUser();
    }

    private function initAuthUser(): void
    {
        // $this->authUsr = $this->usrRepos->authenticatedUser()->toArray();
    }

    public function index(): JsonResponse
    {
        $data = $this->workTripRepos->indexByStatus(
            WorkTripStatusEnum::APPROVED->value
        );
        $message = 'latest update ';
        $message .= date('d/m/y H:i:s');

        return WorkTripService::sendResponse(
            WorkTripResource::collection($data), $message
        );
    }
}

/*public function create()
    {
        //
    }
    public function store(StoreProductRequest $request)
    {
        $details =[
            'name' => $request->name,
            'details' => $request->details
        ];
        DB::beginTransaction();
        try{
            $product = $this->productRepositoryInterface->store($details);

            DB::commit();
            return ResponseClass::sendResponse(new ProductResource($product),'Product Create Successful',201);

        }catch(\Exception $ex){
            return ResponseClass::rollback($ex);
        }
    }

    public function show($id)
    {
        $product = $this->productRepositoryInterface->getById($id);

        return ResponseClass::sendResponse(new ProductResource($product),'',200);
    }

    public function edit(Product $product)
    {
        //
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $updateDetails =[
            'name' => $request->name,
            'details' => $request->details
        ];
        DB::beginTransaction();
        try{
            $product = $this->productRepositoryInterface->update($updateDetails,$id);

            DB::commit();
            return ResponseClass::sendResponse('Product Update Successful','',201);

        }catch(\Exception $ex){
            return ResponseClass::rollback($ex);
        }
    }

    public function destroy($id)
    {
        $this->productRepositoryInterface->delete($id);

        return ResponseClass::sendResponse('Product Delete Successful','',204);
    }*/
