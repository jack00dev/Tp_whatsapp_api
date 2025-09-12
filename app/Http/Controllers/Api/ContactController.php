<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Contact::all();
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
                'last_name' => "required",
                'first_name' => "required",
                'phone_number' => "required",
                'user_id' => 'required',
            ]);

            $data = $request->all();
            $data["owner_id"] = Auth::id();

            return Contact::create($data);
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

            $contact = Contact::find($id);

            if (!$contact) {
                return [
                    "message" => "Enregistrement non trouvé !",
                ];
            }

            return $contact;

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
                'last_name' => "required",
                'first_name' => "required",
                'phone_number' => "required",
            ]);

            $contact = Contact::find($id);

            if (!$contact) {
                return [
                    "message" => "Enregistrement non trouvé !",
                ];
            }

            $contact->update($request->all());

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

            $contact = Contact::find($id);

            if (!$contact) {
                return [
                    "message" => "Enregistrement non trouvé !",
                ];
            }

            $contact->delete();

            return [
                "message" => "Suppression effectuée !",
            ];

        } catch (\Throwable $th) {
            return $th;
        }
    }
}
