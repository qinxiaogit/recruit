<?php

namespace App\Http\Controllers;

use App\DataTables\FeedBackDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateFeedBackRequest;
use App\Http\Requests\UpdateFeedBackRequest;
use App\Repositories\FeedBackRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class FeedBackController extends AppBaseController
{
    /** @var  FeedBackRepository */
    private $feedBackRepository;

    public function __construct(FeedBackRepository $feedBackRepo)
    {
        $this->feedBackRepository = $feedBackRepo;
    }

    /**
     * Display a listing of the FeedBack.
     *
     * @param FeedBackDataTable $feedBackDataTable
     * @return Response
     */
    public function index(FeedBackDataTable $feedBackDataTable)
    {
        return $feedBackDataTable->render('feed_back.index');
    }

    /**
     * Show the form for creating a new FeedBack.
     *
     * @return Response
     */
    public function create()
    {
        return view('feed_back.create');
    }

    /**
     * Store a newly created FeedBack in storage.
     *
     * @param CreateFeedBackRequest $request
     *
     * @return Response
     */
    public function store(CreateFeedBackRequest $request)
    {
        $input = $request->all();

        $feedBack = $this->feedBackRepository->create($input);

        Flash::success('Feed Back saved successfully.');

        return redirect(route('feedBack.index'));
    }

    /**
     * Display the specified FeedBack.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $feedBack = $this->feedBackRepository->find($id);

        if (empty($feedBack)) {
            Flash::error('Feed Back not found');

            return redirect(route('feedBack.index'));
        }

        return view('feed_back.show')->with('feedBack', $feedBack);
    }

    /**
     * Show the form for editing the specified FeedBack.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $feedBack = $this->feedBackRepository->find($id);

        if (empty($feedBack)) {
            Flash::error('Feed Back not found');

            return redirect(route('feedBack.index'));
        }

        return view('feed_back.edit')->with('feedBack', $feedBack);
    }

    /**
     * Update the specified FeedBack in storage.
     *
     * @param  int              $id
     * @param UpdateFeedBackRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFeedBackRequest $request)
    {
        $feedBack = $this->feedBackRepository->find($id);

        if (empty($feedBack)) {
            Flash::error('Feed Back not found');

            return redirect(route('feedBack.index'));
        }

        $feedBack = $this->feedBackRepository->update($request->all(), $id);

        Flash::success('Feed Back updated successfully.');

        return redirect(route('feedBack.index'));
    }

    /**
     * Remove the specified FeedBack from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $feedBack = $this->feedBackRepository->find($id);

        if (empty($feedBack)) {
            Flash::error('Feed Back not found');

            return redirect(route('feedBack.index'));
        }

        $this->feedBackRepository->delete($id);

        Flash::success('Feed Back deleted successfully.');

        return redirect(route('feedBack.index'));
    }
}
