<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobCateRequest;
use App\Http\Requests\UpdateJobCateRequest;
use App\Repositories\JobCateRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class JobCateController extends AppBaseController
{
    /** @var  JobCateRepository */
    private $jobCateRepository;

    public function __construct(JobCateRepository $jobCateRepo)
    {
        $this->jobCateRepository = $jobCateRepo;
    }

    /**
     * Display a listing of the JobCate.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $jobCates = $this->jobCateRepository->paginate(10);

        return view('job_cates.index')
            ->with('jobCates', $jobCates);
    }

    /**
     * Show the form for creating a new JobCate.
     *
     * @return Response
     */
    public function create()
    {
        return view('job_cates.create');
    }

    /**
     * Store a newly created JobCate in storage.
     *
     * @param CreateJobCateRequest $request
     *
     * @return Response
     */
    public function store(CreateJobCateRequest $request)
    {
        $input = $request->all();

        $jobCate = $this->jobCateRepository->create($input);

        Flash::success('Job Cate saved successfully.');

        return redirect(route('jobCates.index'));
    }

    /**
     * Display the specified JobCate.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $jobCate = $this->jobCateRepository->find($id);

        if (empty($jobCate)) {
            Flash::error('Job Cate not found');

            return redirect(route('jobCates.index'));
        }

        return view('job_cates.show')->with('jobCate', $jobCate);
    }

    /**
     * Show the form for editing the specified JobCate.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $jobCate = $this->jobCateRepository->find($id);

        if (empty($jobCate)) {
            Flash::error('Job Cate not found');

            return redirect(route('jobCates.index'));
        }

        return view('job_cates.edit')->with('jobCate', $jobCate);
    }

    /**
     * Update the specified JobCate in storage.
     *
     * @param int $id
     * @param UpdateJobCateRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateJobCateRequest $request)
    {
        $jobCate = $this->jobCateRepository->find($id);

        if (empty($jobCate)) {
            Flash::error('Job Cate not found');

            return redirect(route('jobCates.index'));
        }

        $jobCate = $this->jobCateRepository->update($request->all(), $id);

        Flash::success('Job Cate updated successfully.');

        return redirect(route('jobCates.index'));
    }

    /**
     * Remove the specified JobCate from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $jobCate = $this->jobCateRepository->find($id);

        if (empty($jobCate)) {
            Flash::error('Job Cate not found');

            return redirect(route('jobCates.index'));
        }

        $this->jobCateRepository->delete($id);

        Flash::success('Job Cate deleted successfully.');

        return redirect(route('jobCates.index'));
    }
}
