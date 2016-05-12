<?php

use App\Task;
use Illuminate\Http\Request;

/**
 * 全タスク表示
 */
Route::get('/', function () {
    $tasks = Task::orderBy('created_at', 'asc')->get();

    return view('tasks', [
        'tasks' => $tasks
    ]);
});

/**
 * 新タスク追加
 */
Route::post('/task', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    $task = new Task;
    $task->name = $request->name;
    $task->save();

    return redirect('/');
});

/**
 * 既存タスク削除
 */
Route::delete('/task/{id}', function ($id) {
    Task::findOrFail($id)->delete();

    return redirect('/');
});


Route::get('/hello', function () {
    return 'Hello world!';
});


Route::get('/api/tasks', function (Request $request) {

    $limit = 0;
    if ($request->has('limit')) {
        $limit = intval($request->get('limit'));
        if ($limit <= 0) {
            return response()->json(['result' => false, 'error' => '"limit" parameter is invalid.']);
        }
    }

    $query = Task::orderBy('created_at', 'desc');
    if ($limit > 0) {
        $query->take($limit);
    }

    $tasks = $query->get();

    return response()->json(['result' => true, 'data' => $tasks]);
});