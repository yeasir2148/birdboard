<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Project;

class ProjectsController extends Controller
{
    //
   public function index() {
      $projects = \App\Project::all();
      return view('projects.index', compact('projects'));
   }

   public function store(Request $request) {
      $attributes = $request->validate([
         'title' => 'required',
         'description' => 'required'
      ]);
      \App\Project::create($attributes);
      return redirect('/projects');
   }

   public function show(Project $project) {
      // $project = \App\Project::findOrFail(request('project'));
      return view('projects.show', compact('project'));
   }
}
