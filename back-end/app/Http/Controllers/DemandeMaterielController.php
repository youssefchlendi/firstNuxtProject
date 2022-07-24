<?php

namespace App\Http\Controllers;

use App\Http\Resources\demandeMaterielCollection;
use App\Http\Resources\demandeMaterielRessource;
use App\Models\DemandeMateriel;
use App\Models\DemandeMaterielMateriel;
use App\Models\Materiel;
use Illuminate\Http\Request;

class DemandeMaterielController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->user()->id;
        $demandes = DemandeMateriel::with('materiels')
            ->orderBy('created_at', 'DESC')
            ->with('user')
            ->whereHas('materiels', function ($query) use ($id) {
                $query->where('responsable_id', $id);
            })
            ->paginate($request->pagination ? $request->pagination : 5);
        if ($demandes) {
            return response()->json(new demandeMaterielCollection($demandes), 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Aucune demande trouvée'], 404);
        }
    }

    public function sentDemandes(Request $request)
    {
        $demandes = DemandeMateriel::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'DESC')->with('materiels')
            ->paginate($request->pagination ? $request->pagination : 5);
        if ($demandes->count() > 0) {
            return response()->json(
                new demandeMaterielCollection($demandes),
                200
            );
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Aucune demande envoyée'
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $demande = DemandeMateriel::create([
            'user_id' => $request->user()->id,
            'date_fin_demande' => $request->date_fin_demande,
            'date_demande' => $request->date_demande,
            'message' => $request->message,
        ]);

        $materiels = $request->materielEdit;
        foreach ($materiels as $materiel) {
            $materiel['id'] ? $demande->materiels()->attach($materiel['id'], ['quantity' => 0]) : '';
        }

        if ($demande) {
            return response()->json([
                'success' => true,
                'message' => 'Demande envoyée'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'envoi de la demande'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DemandeMateriel  $demandeMateriel
     * @return \Illuminate\Http\Response
     */
    public function show(DemandeMateriel $demandeMateriel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DemandeMateriel  $demandeMateriel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $demandeMateriel)
    {
        $demande = DemandeMateriel::with('materiels')->find($demandeMateriel);
        if ($demande) {
            $demande->update([
                'date_demande' => $request->date_demande,
                'date_fin_demande' => $request->date_fin_demande,
                'message' => $request->message,
            ]);
            $newMateriels = $request->materielEdit;
            $oldMateriels = $demande->materiels;
            $ids = [];
            foreach ($oldMateriels as $oldMateriel) {
                $ids[] = $oldMateriel->id;
            }
            // foreach old materiel, if it is not in the new materiel, detach it
            foreach ($oldMateriels as $oldMateriel) {
                $found = false;
                foreach ($newMateriels as $newMateriel) {
                    if ($oldMateriel->id == $newMateriel['id']) {
                        $found = true;
                    }
                }
                if (!$found) {
                    $demande->materiels()->detach($oldMateriel->id);
                }
            }
            // foreach new materiel, if it is not in the old materiel, attach it
            foreach ($newMateriels as $newMateriel) {
                $found = false;
                foreach ($oldMateriels as $oldMateriel) {
                    if ($newMateriel['id'] == $oldMateriel->id) {
                        $found = true;
                    }
                }
                if (!$found) {
                    $demande->materiels()->attach($newMateriel['id'], ['quantity' => 0]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Demande mise à jour'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de la demande'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DemandeMateriel  $demandeMateriel
     * @return \Illuminate\Http\Response
     */
    public function destroy($demandeMateriel)
    {
        $demande = DemandeMateriel::find($demandeMateriel);
        if ($demande) {
            $demande->delete();
            return response()->json([
                'success' => true,
                'message' => 'Demande supprimée'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la demande'
            ], 500);
        }
    }

    public function setQuantity(Request $request)
    {
        $demande = DemandeMateriel::find($request->demande_id);
        if ($demande) {
            $materiel = Materiel::find($request->materiel_id);
            $demanesHavingMateriel = DemandeMateriel
                ::whereHas('materiels', function ($query) use ($materiel) {
                    $query->where('materiels.id', $materiel->id);
                    $query->where('status', '=', '1');
                })
                ->where(function ($query) use ($demande) {
                    $query->where('date_demande', '<=', $demande->date_fin_demande)
                        ->orWhere('date_fin_demande', '>=', $demande->date_demande);
                })
                ->where('date_fin_demande', '>=', $demande->date_fin_demande)
                ->where('id', '<>', $demande->id)
                ->get();
            $quantity = $materiel->quantity;
            $qte = 0;

            foreach ($demanesHavingMateriel as $demane) {
                foreach ($demane->materiels as $materiel) {
                    if ($materiel->id == $request->materiel_id) {
                        $qte += $materiel->pivot->quantity;
                    }
                }
            }
            // return $qte;
            if ($quantity - $qte >= $request->quantity) {
                $demande->materiels()->updateExistingPivot($request->materiel_id, ['quantity' => $request->quantity]);
                return response()->json([
                    'success' => true,
                    'message' => 'Quantité mise à jour'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يوجد كمية كافية : الكمية الموجودة ' . ($quantity - $qte)
                ], 500);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de la quantité'
            ], 500);
        }
    }

    public function detachMateriel($id, $idmte)
    {
        $demande = DemandeMateriel::find($id);
        if ($demande) {
            $demande->materiels()->detach($idmte);
            return response()->json([
                'success' => true,
                'message' => 'Materiel retiré'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la retrait du materiel'
            ], 500);
        }
    }

    public function setStatus($id, $status)
    {
        $demandeMaterielMateriel = DemandeMaterielMateriel::find($id);
        if ($demandeMaterielMateriel) {
            $demandeMaterielMateriel->update([
                'status' => $status,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du statut'
            ], 500);
        }
    }
}
