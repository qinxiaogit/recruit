<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFeedBackAPIRequest;
use App\Http\Requests\API\UpdateFeedBackAPIRequest;
use App\Models\AppUser;
use App\Models\FeedBack;
use App\Repositories\AuditLogRepository;
use App\Repositories\FeedBackRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class FeedBackController
 * @package App\Http\Controllers\API
 */
class FeedBackAPIController extends AppBaseController
{
    /** @var  FeedBackRepository */
    private $feedBackRepository;

    public function __construct(FeedBackRepository $feedBackRepo)
    {
        $this->feedBackRepository = $feedBackRepo;
    }

    /**
     * Display a listing of the FeedBack.
     * GET|HEAD /feedBack
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $where = [];
        $status = $request->get("status");
        $feed_type = $request->get("feed_type");

        if ($status >= 0) {
            $where['status'] = $status;
        }
        if ($feed_type) {
            $where['feed_type'] = $feed_type;
        }
        $feeds = $this->feedBackRepository->all(
            $where,
            $request->get('skip'),
            $request->get('limit')
        );
        $items = $feeds->toArray();

        $feedUidArr = array_column($items, 'feed_uid');

        $appUsers = AppUser::whereIn('id', $feedUidArr)->get()->toArray();
        $appUsersMap = array_column($appUsers, null, 'id');

        foreach ($items as $key => $item) {
            $item['app_user'] = [
                'name' => $appUsersMap[$item['feed_uid']]['nickename'] ?? '',
                'logo' => $appUsersMap[$item['feed_uid']]['avatar'] ?? '',
            ];
            $item['img_json_arr'] = json_decode($item['img_json'], true);
            $items[$key] = $item;
        }

        $data = [
            'items' => $items,
            'total' => FeedBack::where($where)->count(),
        ];
        return $this->sendResponse($data, 'Jobs retrieved successfully');
    }

    /**
     * Store a newly created FeedBack in storage.
     * POST /feedBack
     *
     * @param CreateFeedBackAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFeedBackAPIRequest $request)
    {
        $input = $request->all();

        $feedBack = $this->feedBackRepository->create($input);

        return $this->sendResponse($feedBack->toArray(), 'Feed Back saved successfully');
    }

    /**
     * Display the specified FeedBack.
     * GET|HEAD /feedBack/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FeedBack $feedBack */
        $feedBack = $this->feedBackRepository->find($id);

        if (empty($feedBack)) {
            return $this->sendError('Feed Back not found');
        }

        return $this->sendResponse($feedBack->toArray(), 'Feed Back retrieved successfully');
    }

    /**
     * Update the specified FeedBack in storage.
     * PUT/PATCH /feedBack/{id}
     *
     * @param int $id
     * @param UpdateFeedBackAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFeedBackAPIRequest $request)
    {
        $input = $request->all();

        /** @var FeedBack $feedBack */
        $feedBack = $this->feedBackRepository->find($id);

        if (empty($feedBack)) {
            return $this->sendError('Feed Back not found');
        }

        $feedBack = $this->feedBackRepository->update($input, $id);

        return $this->sendResponse($feedBack->toArray(), 'FeedBack updated successfully');
    }

    /**
     * Remove the specified FeedBack from storage.
     * DELETE /feedBack/{id}
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var FeedBack $feedBack */
        $feedBack = $this->feedBackRepository->find($id);

        if (empty($feedBack)) {
            return $this->sendError('Feed Back not found');
        }

        $feedBack->delete();

        return $this->sendSuccess('Feed Back deleted successfully');
    }

    /**
     * @desc 审核
     * @param Request $request
     * @return
     * @throws \Exception
     */
    public function audit(Request $request)
    {
        $feedback = $this->feedBackRepository->find($request->post("id"));

        $reason = $request->post('reason');
        $status = $request->post('status');

        if (empty($feedback)) {
            return $this->sendError('反馈数据异常');
        }
        if ($feedback->status !== 0) {
            return $this->sendError("反馈数据已审核了");
        }
        //审核驳回结果
        $feedback->status = $status ? 2 : 1;
        if ($feedback->save()) {
            $adminLogRepository = new AuditLogRepository(app());
            $adminLogRepository->create([
                'reason' => $reason,
                'result' => $status,
                'uid' => auth()->id(),
                'ref_id' => $request->post('id'),
                'bus_type' => "feed_back"
            ]);
        }
        return $this->sendResponse([], "操作成功");
    }
}
