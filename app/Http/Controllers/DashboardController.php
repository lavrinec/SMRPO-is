<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Group;
use App\Models\User;
use App\Models\UsersGroup;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        //poisci vse table, na katerih so projekti tega userja
        if ($user->isAdmin()) {
            $users = User::withTrashed()->get();
            $notifications = [];

            return view('content.maincontent')->with(['users' => $users, 'notifications' => $notifications]);

        } else {
            $usersGroup = UsersGroup::join('groups', "groups.id", "=", 'users_groups.group_id')->where('users_groups.user_id', $user->id)->get();
            //return $usersGroup;
            $groups = $user->groups()->get(); //NAPAKA - vrne tudi izbrisane iz skupine!!!
            //return $groups;
            $projects = [];
            foreach ($usersGroup as $gr) {
                $group = Group::where('id', $gr->group_id)->first();
                if ($group == null) {
                    continue;
                }
                $project = $group->project->all();

                $projects = array_merge($projects, $project);
            }
            $projects = array_unique($projects);
            //return $projects;
            $boards = [];
            foreach ($projects as $project) {
                if ($board = $project->board == null) continue;
                $board = $project->board;
                $boards = array_merge($boards, [$board]);

            }

            $boards = array_unique($boards);

            $tasks = [];


            return view('content.maincontent')->with([
                'boards' => $boards,
                'groups' => $usersGroup,
                'projects' => $projects,
                'tasks' => $tasks]);
        }


    }
}
