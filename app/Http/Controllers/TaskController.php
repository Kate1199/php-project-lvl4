<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

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
            foreach ($filters as $key => $filter) {
                if (! is_null($filter)) {
                    $tasks = $tasks->where([
                        [$key, '=', $filter]
                    ]);
                }
            }
        }

        $tasks = $tasks->leftJoin('task_statuses', 'task_statuses.id', '=', 'tasks.status_id')
                        ->leftJoin('users as users1', 'users1.id', '=', 'tasks.created_by_id')
                        ->leftJoin('users as users2', 'users2.id', '=', 'tasks.assigned_to_id')
                        ->select('tasks.*', 'task_statuses.name as status', 'users1.name as created_by', 'users2.name as assigned_to')
                        ->paginate();

        $taskStatuses = TaskStatus::all('id', 'name')->pluck('name', 'id');
        $users = User::all('id', 'name')->pluck('name', 'id');
        $id = Auth::id();

        return view('task.index', compact('tasks', 'taskStatuses', 'users', 'filters', 'id'));
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
        $labels = Label::all('id', 'name')->pluck('name', 'id');

        return view('task.create', compact('task', 'taskStatuses', 'assignedToUsers', 'labels'));
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

        $labels = $request->get('labels');
        $task->labels()->sync($labels);

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
        $status = $task->status->name;
        $labels = $task->labels();

        return view('task.show', compact('task', 'status', 'labels'));
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
        $labels = Label::all('id', 'name')->pluck('name', 'id');

        return view('task.edit', compact('task', 'taskStatuses', 'assignedToUsers', 'labels'));
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

        $labels = $request->get('labels');
        $task->labels()->sync($labels);

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
            optional($task->labels())->detach();
            $task->delete();
        }

        flash(__('messages.task_deleted'), 'success');

        return redirect()->route('tasks.index');
    }
}
