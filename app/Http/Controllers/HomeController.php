<?php

namespace App\Http\Controllers;

use App\Events\BoardCreated;
use App\Events\UserOnline;
use App\Events\TaskCreated;
use App\Events\TaskDelete;
use App\Events\TaskDrop;
use App\Events\TaskUpdated;
use App\Events\UserSessionChange;
use App\Models\Board;
use App\Models\BoardMember;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::where('id', '<>', Auth::user()->id)->select('id', 'name')->get();
        $userId = Auth::user()->id;

        $createdGroups = Board::select('id', 'name')->createdByUser($userId)->get();


        $joinedGroups = BoardMember::userIsMember($userId)
            ->leftJoin('boards', 'board_members.board_id', '=', 'boards.id')
            ->select('boards.id', 'boards.name')
            ->get();


        return view('home', ['users' => $users, 'createdGroups' => $createdGroups, 'joinedGroups' => $joinedGroups]);
    }

    public function addBoard(Request $request)
    {

        $board = new Board();
        $board->name = $request->name;
        $board->created_by = Auth::user()->id;
        $board->save();

        if ($request->has('members')) {
            foreach ($request->members as $memberId) {
                $boardMember = new BoardMember();
                $boardMember->board_id = $board->id;
                $boardMember->user_id = $memberId;
                $boardMember->role = 'member';
                $boardMember->save();
            }
        }

        broadcast(new BoardCreated(Auth::user()->id, $memberId, $board));
    }

    public function BoardGroup($boardId)
    {
        $board = Board::find($boardId);

        $tasks = Task::select('id', 'name', 'status')
                     ->where('board_id', $boardId)
                     ->get(); 
        
    
        if ($board) {
            $create_by = User::select('id', 'name', 'avatar')->find($board->created_by);
            $member_ids = BoardMember::where('board_id', $boardId)->pluck('user_id')->toArray();
            $members = User::select('id', 'name', 'avatar')->whereIn('id', $member_ids)->get();


            if (($board->created_by == Auth::user()->id) || (in_array(Auth::user()->id,  $member_ids))) {
                $add_member = User::whereNotIn('id', function ($query) use ($boardId) {
                    $query->select('created_by')
                        ->from('boards')
                        ->where('id', $boardId)
                        ->union(
                            BoardMember::select('user_id')
                                ->where('board_id', $boardId)
                                ->groupBy('user_id')
                        );
                })
                    ->select('id', 'name')
                    ->get();
                 
                    
                return view('board.index',
                
                [
                    'tasks'             => $tasks,
                     'add_member'        => $add_member,
                     'board'            => $board, 
                     'create_by'        => $create_by,
                     'members'         => $members
                ]);
            }
        }


        return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập vào bảng này.');
    }


    public function addNewMember(Request $request)
    {

               $boardId = $request->id;
        if ($request->has('members')) {
            foreach ($request->members as $memberId) {

                $boardMember = new BoardMember();
                $boardMember->board_id = $boardId;
                $boardMember->user_id = $memberId;
                $boardMember->role = 'member';
                $boardMember->save();
            }
        }
    }

    public function addTask(Request $request){
   
        $data = [
            'name' => $request->name,  
            'board_id' => $request->boardId
        ];
    
 
        $task = Task::create($data);
    
       
        $createdBy = Auth::user()->name;; 
        broadcast(new TaskCreated($task, $createdBy));
       
        return response()->json(['message' => 'Task created successfully']);
    }

    public function updateTask(Request $request) {
        $idTask = $request->taskId;
        $task = Task::find($idTask);
        $task->update([
            'status' => $request->newStatus
        ]);
        $createdBy = Auth::user()->name;
        broadcast(new TaskDrop($task, $createdBy));
        return response()->json(['message' => 'Task update successfully']);
    }
    
    public function deleteTasks(Request $request)
    {
        $taskIds = $request->input('taskIds');
        
        foreach($taskIds as $idTask){
            $createdBy = Auth::user()->name;
            broadcast(new TaskDelete(Task::find($idTask), $createdBy));
        }
   
        Task::whereIn('id', $taskIds)->delete();
    
        return response()->json(['message' => 'Tasks deleted successfully']);
    }
    
    public function postMessage( Request $request){

        broadcast(new UserOnline($request ->user(), $request->message));
        return response() ->json('Message brocart');
    }
    
    public function UpTask(Request $request){
        $taskId = $request->input('taskId');

        $task = Task::find($taskId);
        $task->update([
            'name' => $request ->taskname
        ]);


        $createdBy = Auth::user()->name;

        broadcast(new TaskUpdated($task, $createdBy));

        return response()->json(['message' => 'Tasks update successfully']);
    }
    
    public function deleteBoard(Request $request){

        $boardId = $request ->id;

        Task::where('board_id','=',$boardId)->delete();

        BoardMember::where('board_id' , '=' ,$boardId)->delete();

        Board::find($boardId)->delete();
        return response()->json(['message' => 'Board deleted successfully']);
    }
}
