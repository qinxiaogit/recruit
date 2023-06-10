<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSuperAdminAPIRequest;
use App\Http\Requests\API\UpdateSuperAdminAPIRequest;
use App\Models\SuperAdmin;
use App\Repositories\SuperAdminRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SuperAdminController
 * @package App\Http\Controllers\API
 */

class SuperAdminAPIController extends AppBaseController
{
    /** @var  SuperAdminRepository */
    private $superAdminRepository;

    public function __construct(SuperAdminRepository $superAdminRepo)
    {
        $this->superAdminRepository = $superAdminRepo;
    }

    /**
     * Display a listing of the SuperAdmin.
     * GET|HEAD /superAdmins
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $superAdmins = $this->superAdminRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($superAdmins->toArray(), 'Super Admins retrieved successfully');
    }

    /**
     * Store a newly created SuperAdmin in storage.
     * POST /superAdmins
     *
     * @param CreateSuperAdminAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSuperAdminAPIRequest $request)
    {
        $input = $request->all();

        $superAdmin = $this->superAdminRepository->create($input);

        return $this->sendResponse($superAdmin->toArray(), 'Super Admin saved successfully');
    }

    /**
     * Display the specified SuperAdmin.
     * GET|HEAD /superAdmins/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SuperAdmin $superAdmin */
        $superAdmin = $this->superAdminRepository->find($id);

        if (empty($superAdmin)) {
            return $this->sendError('Super Admin not found');
        }

        return $this->sendResponse($superAdmin->toArray(), 'Super Admin retrieved successfully');
    }

    /**
     * Update the specified SuperAdmin in storage.
     * PUT/PATCH /superAdmins/{id}
     *
     * @param int $id
     * @param UpdateSuperAdminAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSuperAdminAPIRequest $request)
    {
        $input = $request->all();

        /** @var SuperAdmin $superAdmin */
        $superAdmin = $this->superAdminRepository->find($id);

        if (empty($superAdmin)) {
            return $this->sendError('Super Admin not found');
        }

        $superAdmin = $this->superAdminRepository->update($input, $id);

        return $this->sendResponse($superAdmin->toArray(), 'SuperAdmin updated successfully');
    }

    /**
     * Remove the specified SuperAdmin from storage.
     * DELETE /superAdmins/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SuperAdmin $superAdmin */
        $superAdmin = $this->superAdminRepository->find($id);

        if (empty($superAdmin)) {
            return $this->sendError('Super Admin not found');
        }

        $superAdmin->delete();

        return $this->sendSuccess('Super Admin deleted successfully');
    }

    public function login(CreateSuperAdminAPIRequest $request){

    }
}
