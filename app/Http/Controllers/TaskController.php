<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $request->input('filter');
        $tasks = DB::table('tasks');

        if (! is_null($filters)) {
            $tasks = $tasks->where([
                ['status_id', '=', $filters['status_id']],
                ['created_by_id', '=', $filters['created_by_id']],
                ['assigned_to_id', '=', $filters['assigned_to_id']]
            ]);
        }

        $tasks = $tasks->leftJoin('task_statuses', 'task_statuses.id', '=', 'tasks.status_id')
                        ->leftJoin('users as users1', 'users1.id', '=', 'tasks.created_by_id')
                        ->leftJoin('users as users2', 'users2.id', '=', 'tasks.assigned_to_id')
                        ->select('tasks.*', 'task_statuses.name as status', 'users1.name as created_by', 'users2.name as assigned_to')
                        ->get();

        $taskStatuses = TaskStatus::all('id', 'name')->pluck('name', 'id');
        $users = User::all('id', 'name')->pluck('name', 'id');

        return view('task.index', compact('tasks', 'taskStatuses', 'users', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task();

        $taskStatuses = TaskStatus::all('id', 'name')->pluck('name', 'id');
        $assignedToUsers = User::all('id', 'name')->pluck('name', 'id');

        return view('task.create', compact('task', 'taskStatuses', 'assignedToUsers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $data['created_by_id'] = Auth::id();

        $task = new Task();
        $task->fill($data);
        $task->save();

        flash(__('messages.task_created'), 'success');

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $status = TaskStatus::find($task->status_id)->name;

        return view('task.show', compact('task', 'status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $taskStatuses = TaskStatus::all('id', 'name')->pluck('name', 'id');
        $assignedToUsers = User::all('id', 'name')->pluck('name', 'id');

        return view('task.edit', compact('task', 'taskStatuses', 'assignedToUsers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTaskRequest $request, Task $task)
    {
        $data = $request->validated();

        $task->fill($data);
        $task->save();

        flash(__('messages.task_edited'), 'success');

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if ($task) {
            $task->delete();
        }

        flash(__('messages.delete_task'), 'success');

        return redirect()->route('task.index');
    }
}
