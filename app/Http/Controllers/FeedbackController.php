<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Services\FeedbackService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    private FeedbackService $feedbackService;

    /**
     * AddOnController constructor.
     */
    public function __construct()
    {
        $this->feedbackService = new FeedbackService();
    }

    /**
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse
    {
        return $this->feedbackService->index();
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        return $this->feedbackService->create();
    }

    /**
     * @param \App\Http\Requests\FeedbackRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FeedbackRequest $request): RedirectResponse
    {
        return $this->feedbackService->store($request);
    }

    /**
     * @param int $id
     * @return View|RedirectResponse
     */
    public function show(int $id): View|RedirectResponse
    {
        return $this->feedbackService->show($id);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserSuggestions(Request $request): JsonResponse
    {
        return $this->feedbackService->getUserSuggestions($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment(Request $request): RedirectResponse
    {
        return $this->feedbackService->storeComment($request);
    }

}
