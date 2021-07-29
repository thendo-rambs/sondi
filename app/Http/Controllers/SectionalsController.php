<?php

namespace App\Http\Controllers;

use App\Models\Sectionals;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SectionalsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $sectionals = Sectionals::all();
    return $sectionals->map(
      function (Sectionals $sectional) {
        return [
          'id' => $sectional->id,
          'name' => $sectional->name,
          'address' => $sectional->address,
          'image' => $sectional->image,
        ];
      }
    );
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string',
      'type' => 'required|string',
      'image' => 'required|file',
      'addresses_id' => 'required|integer',
    ]);
    $sectional = new Sectionals;
    $sectional->addresses_id = $request->addresses_id;
    $sectional->name = $request->name;
    $sectional->type = $request->type;
    $sectional->image = 'storage/' . $request->file('image')
      ->store('images', 'public');

    $sectional->save();

    return $sectional;
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Sectionals  $sectionals
   * @return \Illuminate\Http\Response
   */
  public function show(Sectionals $sectional)
  {
    return [
      'id' => $sectional->id,
      'name' => $sectional->name,
      'address' => $sectional->address,
      'image' => $sectional->image
    ];
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Sectionals  $sectionals
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Sectionals $sectional)
  {
    if (!$sectional) {
      return new Response([
        'error' => 'sectional not found',
      ], 404);
    }

    $fields = [
      'name', 'type', 'image'
    ];
    foreach ($fields as $field) {
      if ($field === 'image' && $request->filled('image')) {
        $sectional->image = $request->file('image')
          ->store('images', 'public');
      } else if ($request->filled($field)) {
        $sectional[$field] = $request[$field];
      }
    }

    $sectional->save();

    return new Response([
      'message' => 'updated sectional',
      'sectional' =>  $sectional,
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Sectionals  $sectionals
   * @return \Illuminate\Http\Response
   */
  public function destroy(Sectionals $sectional)
  {
    $deleted = $sectional;
    $sectional->delete();
    return $deleted;
  }
}
