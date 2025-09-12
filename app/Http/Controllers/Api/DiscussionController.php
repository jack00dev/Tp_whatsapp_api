<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Discussion::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'receiver_id' => "required",
                'message' => "required",
            ]);

            $data = $request->all();
            $data["sender_id"] = Auth::id();

            return Discussion::create($data);
        } catch (ValidationException $err) {
            return [
                'message' => "Données non valides",
                'error' => $err->errors(),
            ];
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        try {

            $discussion = Discussion::find($id);

            if (!$discussion) {
                return [
                    "message" => "Enregistrement non trouvé !",
                ];
            }

            return $discussion;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $request->validate([
                'message' => "required",
            ]);

            $discussion = Discussion::find($id);

            if (!$discussion) {
                return [
                    "message" => "Enregistrement non trouvé !",
                ];
            }

            $discussion->update($request->all());

            return [
                "message" => "Mise à jour effectuée !",
            ];
        } catch (ValidationException $err) {
            return [
                'message' => "Données non valides",
                'error' => $err->errors(),
            ];
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $discussion = Discussion::find($id);

            if (!$discussion) {
                return [
                    "message" => "Enregistrement non trouvé !",
                ];
            }

            $discussion->delete();

            return [
                "message" => "Suppression effectuée !",
            ];
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
