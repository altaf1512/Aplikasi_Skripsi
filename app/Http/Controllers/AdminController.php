<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Question;
use App\Models\ExpertRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function updateGoldPrice(Request $request)
    {
        $request->validate(['gold_price' => 'required|numeric|min:100000']);
        Cache::forever('gold_price', $request->gold_price);
        return redirect()->back()->with('success', 'Harga emas berhasil diperbarui.');
    }

    public function users()
    {
        $users = User::paginate(20);
        return view('admin.users', compact('users'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        $user->update($validated);
        return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }

    public function questions()
    {
        $questions = Question::with('expertRules')->get();
        return view('admin.questions', compact('questions'));
    }
    
    public function storeQuestion(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:questions,code',
            'text' => 'required|string',
            'cf_beli' => 'required|numeric|min:0|max:1',
            'cf_tahan' => 'required|numeric|min:0|max:1',
            'cf_jual' => 'required|numeric|min:0|max:1',
        ]);
        
        $question = Question::create([
            'code' => $validated['code'],
            'type' => 'intermediate',
            'text' => $validated['text'],
        ]);

        ExpertRule::create(['question_id' => $question->id, 'hypothesis' => 'Beli', 'cf_pakar' => $validated['cf_beli']]);
        ExpertRule::create(['question_id' => $question->id, 'hypothesis' => 'Tahan', 'cf_pakar' => $validated['cf_tahan']]);
        ExpertRule::create(['question_id' => $question->id, 'hypothesis' => 'Jual', 'cf_pakar' => $validated['cf_jual']]);

        return redirect()->back()->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function updateQuestion(Request $request, Question $question)
    {
        $validated = $request->validate([
            'text' => 'required|string',
            'cf_beli' => 'required|numeric|min:0|max:1',
            'cf_tahan' => 'required|numeric|min:0|max:1',
            'cf_jual' => 'required|numeric|min:0|max:1',
        ]);
        
        $question->update(['text' => $validated['text']]);
        
        $question->expertRules()->where('hypothesis', 'Beli')->update(['cf_pakar' => $validated['cf_beli']]);
        $question->expertRules()->where('hypothesis', 'Tahan')->update(['cf_pakar' => $validated['cf_tahan']]);
        $question->expertRules()->where('hypothesis', 'Jual')->update(['cf_pakar' => $validated['cf_jual']]);
        
        return redirect()->back()->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function destroyQuestion(Question $question)
    {
        $question->expertRules()->delete();
        $question->delete();
        return redirect()->back()->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
