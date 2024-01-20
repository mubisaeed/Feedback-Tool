<?php

namespace App\Services;

use App\Models\Category\Category;
use App\Models\Comment\Comment;
use App\Models\Feedback\Feedback;
use App\Models\User\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackService
{
    /**
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse
    {
        try{
            $feedbacks = Feedback::latest()->paginate(config('pagination.paginate'));
            return view('feedback.index', get_defined_vars());
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        try{
            $categories = Category::get();
            return view('feedback.create', compact('categories'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($request): RedirectResponse
    {
        try{
            Feedback::create([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id
            ]);
            return redirect()->route('feedback.index')->with('success', 'Feedback created successfully.');
        } catch (Exception $e) {
            return redirect()->route('feedback.create')->with('error', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return View|RedirectResponse
     */
    public function show($id): View|RedirectResponse
    {
        try{
            $feedback = Feedback::find($id);
            if(!$feedback)
                return redirect()->back()->with('error', 'Feedback not found.');

            return view('feedback.show', compact('feedback'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getUserSuggestions(Request $request): JsonResponse
    {
        $query = $request->get('query');

        // Perform a query to fetch users based on the input $query
        $users = User::where('name', 'like', "%$query%")->pluck('name');
        return response()->json($users);
    }

    /**
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeComment($request): RedirectResponse
    {
        try{
            $validator = Validator::make($request->all(), [
                'content' => 'required'
            ], [
                'content.required' => 'Write your comment first.',
            ]);
            if ($validator->fails())
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();

            Comment::create([
                'feedback_id' => $request->feedback_id,
                'content' => $request->content,
                'user_id' => auth()->user()->id
            ]);
            return redirect()->route('feedback.index')->with('success', 'Comment sent successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
