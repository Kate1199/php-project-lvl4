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
    use COntrollerUtility;

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

        $tasks = $this->filterTasks($filters, $tasks);

        $tasks = $tasks->leftJoin('task_statuses', 'task_statuses.id', '=', 'tasks.status_id')
                        ->leftJoin('users as users1', 'users1.id', '=', 'tasks.created_by_id')
                        ->leftJoin('users as users2', 'users2.id', '=', 'tasks.assigned_to_id')
                        ->select('tasks.*', 'task_statuses.name as status', 'users1.name as created_by', 'users2.name as assigned_to')
                        ->paginate();

        $taskStatuses = $this->getAll(new TaskStatus());
        $users = $this->getAll(new User());
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

        $taskStatuses = $this->getAll(new TaskStatus());
        $assignedToUsers = $this->getAll(new User());
        $labels = $this->getAll(new Label());

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
        $taskStatuses = $this->getAll(new TaskStatus());
        $assignedToUsers = $this->getAll(new User());
        $labels = $this->getAll(new Label());

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
