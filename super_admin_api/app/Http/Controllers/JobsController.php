<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobsRequest;
use App\Http\Requests\UpdateJobsRequest;
use App\Repositories\JobsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class JobsController extends AppBaseController
{
    /** @var  JobsRepository */
    private $jobsRepository;

    public function __construct(JobsRepository $jobsRepo)
    {
        $this->jobsRepository = $jobsRepo;
    }

    /**
     * Display a listing of the Jobs.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $jobs = $this->jobsRepository->paginate(10);

        return view('jobs.index')
            ->with('jobs', $jobs);
    }

    /**
     * Show the form for creating a new Jobs.
     *
     * @return Response
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created Jobs in storage.
     *
     * @param CreateJobsRequest $request
     *
     * @return Response
     */
    public function store(CreateJobsRequest $request)
    {
        $input = $request->all();

        $jobs = $this->jobsRepository->create($input);

        Flash::success('Jobs saved successfully.');

        return redirect(route('jobs.index'));
    }

    /**
     * Display the specified Jobs.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $jobs = $this->jobsRepository->find($id);

        if (empty($jobs)) {
            Flash::error('Jobs not found');

            return redirect(route('jobs.index'));
        }

        return view('jobs.show')->with('jobs', $jobs);
    }

    /**
     * Show the form for editing the specified Jobs.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $jobs = $this->jobsRepository->find($id);

        if (empty($jobs)) {
            Flash::error('Jobs not found');

            return redirect(route('jobs.index'));
        }

        return view('jobs.edit')->with('jobs', $jobs);
    }

    /**
     * Update the specified Jobs in storage.
     *
     * @param int $id
     * @param UpdateJobsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateJobsRequest $request)
    {
        $jobs = $this->jobsRepository->find($id);

        if (empty($jobs)) {
            Flash::error('Jobs not found');

            return redirect(route('jobs.index'));
        }

        $jobs = $this->jobsRepository->update($request->all(), $id);

        Flash::success('Jobs updated successfully.');

        return redirect(route('jobs.index'));
    }

    /**
     * Remove the specified Jobs from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $jobs = $this->jobsRepository->find($id);

        if (empty($jobs)) {
            Flash::error('Jobs not found');

            return redirect(route('jobs.index'));
        }

        $this->jobsRepository->delete($id);

        Flash::success('Jobs deleted successfully.');

        return redirect(route('jobs.index'));
    }
}
