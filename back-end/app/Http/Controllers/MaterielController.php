<?php

namespace App\Http\Controllers;

use App\Http\Resources\Materiel as ResourcesMateriel;
use App\Http\Resources\resourceMateriel;
use App\Models\CategorieMateriel;
use App\Models\Materiel;
use Illuminate\Http\Request;

class MaterielController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $materiel = Materiel::with('responsable')->orderBy('created_at','DESC')->get();
        if ($materiel->isEmpty()) {
            return response()->json(['message' => 'Aucun matériel n\'a été trouvé'], 404);
        }
        return response()->json(resourceMateriel::collection($materiel), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $materiel = Materiel::where('responsable_id',$request->user()->id)->with('categorieMateriel')->orderBy('created_at','DESC')->get();
        if ($materiel->isEmpty()) {
            return response()->json(['message' => 'Aucun matériel n\'a été trouvé'], 404);
        }
        return response()->json(ResourcesMateriel::collection($materiel), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $materiel = Materiel::create([
            'name' => $request->name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'responsable_id' => $request->user()->id,
        ]);
        $tags = $request->categories;
        // get all ids from tags
        $tagIds = [];
        foreach ($tags as $tag) {
            $tagIds[] = $tag['id'];
        }
        // attach all ids to materiel
        $materiel->categorieMateriel()->attach($tagIds);

        if ($materiel) {
            return response()->json(['message' => 'Matériel créé avec succès'], 201);
        }
        return response()->json(['message' => 'Erreur lors de la création du matériel'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Materiel  $materiel
     * @return \Illuminate\Http\Response
     */
    public function show(Materiel $materiel)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Materiel  $materiel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $materiel = Materiel::find($id);
        if ($materiel) {
            $materiel->name = $request->name;
            $materiel->description = $request->description;
            $materiel->quantity = $request->quantity;
            $materiel->responsable_id = $request->user()->id;

            $tags = $request->categories;
            // get all ids from tags
            $tagIds = [];
            foreach ($tags as $tag) {
                $tagIds[] = CategorieMateriel::where('name',$tag['text'])->get()->first()->id;
            }
            $materiel->categorieMateriel()->detach();
            $materiel->categorieMateriel()->attach($tagIds);

            $materiel->save();
            return response()->json(['message' => 'Matériel modifié avec succès'], 200);
        }
        return response()->json(['message' => 'Erreur lors de la modification du matériel'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Materiel  $materiel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $materiel = Materiel::find($id);
        if ($materiel) {
            $materiel->delete();
            return response()->json(['message' => 'Matériel supprimé avec succès'], 200);
        }
        return response()->json(['message' => 'Erreur lors de la suppression du matériel'], 500);
    }
}
