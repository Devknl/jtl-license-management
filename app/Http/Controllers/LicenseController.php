<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * @OA\Info(
 *     title="JTL Lizenzmanagement API",
 *     version="1.0.0",
 *     description="API für das JTL Lizenzmanagement System"
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Lokaler Entwicklungsserver"
 * )
 */
class LicenseController extends Controller
{
    /**
     * @OA\Get(
     *     path="/licenses",
     *     summary="Alle Lizenzen abrufen",
     *     tags={"Lizenzen"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste aller Lizenzen",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/License")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $licenses = License::all();
        return view('licenses.index', compact('licenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('licenses.create');
    }

    /**
     * @OA\Post(
     *     path="/licenses",
     *     summary="Neue Lizenz erstellen",
     *     tags={"Lizenzen"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"license_key", "customer_name", "product_name", "valid_until", "license_type"},
     *             @OA\Property(property="license_key", type="string", example="JTL-DEMO-12345"),
     *             @OA\Property(property="customer_name", type="string", example="Mustermann GmbH"),
     *             @OA\Property(property="product_name", type="string", example="JTL-Warenwirtschaft"),
     *             @OA\Property(property="license_type", type="string", enum={"perpetual", "subscription"}),
     *             @OA\Property(property="valid_until", type="string", format="date", example="2024-12-31")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Lizenz erfolgreich erstellt",
     *         @OA\JsonContent(ref="#/components/schemas/License")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validierungsfehler"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'license_key' => 'required|regex:/^JTL-[A-Z]+-\d{5}$/|unique:licenses',
            'customer_name' => 'required|max:100',
            'product_name' => 'required|max:50',
            'valid_until' => 'required|date',
            'license_type' => 'required|in:perpetual,subscription'
        ], [
            'license_key.regex' => 'Das Lizenzschlüssel-Format muss JTL-XXX-12345 sein (z.B. JTL-DEMO-12345)',
            'license_key.unique' => 'Dieser Lizenzschlüssel existiert bereits'
        ]);

        $license = License::create($request->all());

        return redirect()->route('licenses.index')
            ->with('success', 'Lizenz erfolgreich erstellt!');
    }

    /**
     * @OA\Get(
     *     path="/licenses/{id}",
     *     summary="Lizenzdetails abrufen",
     *     tags={"Lizenzen"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Lizenz ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lizenzdetails",
     *         @OA\JsonContent(ref="#/components/schemas/License")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Lizenz nicht gefunden"
     *     )
     * )
     */
    public function show(License $license)
    {
        return view('licenses.show', compact('license'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(License $license)
    {
        return view('licenses.edit', compact('license'));
    }

    /**
     * @OA\Put(
     *     path="/licenses/{id}",
     *     summary="Lizenz aktualisieren",
     *     tags={"Lizenzen"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Lizenz ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"license_key", "customer_name", "product_name", "valid_until", "license_type"},
     *             @OA\Property(property="license_key", type="string", example="JTL-DEMO-12345"),
     *             @OA\Property(property="customer_name", type="string", example="Mustermann GmbH"),
     *             @OA\Property(property="product_name", type="string", example="JTL-Warenwirtschaft"),
     *             @OA\Property(property="license_type", type="string", enum={"perpetual", "subscription"}),
     *             @OA\Property(property="valid_until", type="string", format="date", example="2024-12-31"),
     *             @OA\Property(property="status", type="string", enum={"active", "expired", "suspended"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lizenz erfolgreich aktualisiert",
     *         @OA\JsonContent(ref="#/components/schemas/License")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validierungsfehler"
     *     )
     * )
     */
    public function update(Request $request, License $license)
    {
        $request->validate([
            'license_key' => 'required|regex:/^JTL-[A-Z]+-\d{5}$/|unique:licenses,license_key,' . $license->id,
            'customer_name' => 'required|max:100',
            'product_name' => 'required|max:50',
            'valid_until' => 'required|date',
            'license_type' => 'required|in:perpetual,subscription'
        ], [
            'license_key.regex' => 'Das Lizenzschlüssel-Format muss JTL-XXX-12345 sein (z.B. JTL-DEMO-12345)'
        ]);

        $license->update($request->all());

        return redirect()->route('licenses.index')
            ->with('success', 'Lizenz erfolgreich aktualisiert!');
    }

    /**
     * @OA\Delete(
     *     path="/licenses/{id}",
     *     summary="Lizenz löschen",
     *     tags={"Lizenzen"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Lizenz ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lizenz erfolgreich gelöscht"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Lizenz nicht gefunden"
     *     )
     * )
     */
    public function destroy(License $license)
    {
        $license->delete();

        return redirect()->route('licenses.index')
            ->with('success', 'Lizenz erfolgreich gelöscht!');
    }

    /**
     * Show the form for license validation.
     */
    public function showValidationForm()
    {
        return view('licenses.validate');
    }

    /**
     * @OA\Post(
     *     path="/validate",
     *     summary="Lizenz validieren",
     *     tags={"Validierung"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"license_key"},
     *             @OA\Property(property="license_key", type="string", example="JTL-DEMO-12345")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Validierungsergebnis",
     *         @OA\JsonContent(
     *             @OA\Property(property="valid", type="boolean", example=true),
     *             @OA\Property(property="license", ref="#/components/schemas/License"),
     *             @OA\Property(property="is_expired", type="boolean", example=false),
     *             @OA\Property(property="days_remaining", type="integer", example=45),
     *             @OA\Property(property="validation_date", type="string", format="date"),
     *             @OA\Property(property="message", type="string", example="Lizenz ist gültig")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Lizenz nicht gefunden",
     *         @OA\JsonContent(
     *             @OA\Property(property="valid", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Lizenzschlüssel nicht gefunden")
     *         )
     *     )
     * )
     */
    public function validateLicense(Request $request)
    {
        $request->validate([
            'license_key' => 'required|regex:/^JTL-[A-Z]+-\d{5}$/'
        ], [
            'license_key.regex' => 'Bitte geben Sie einen gültigen Lizenzschlüssel im Format JTL-XXX-12345 ein'
        ]);

        $licenseKey = $request->license_key;
        
        // Lizenz in der Datenbank suchen
        $license = License::where('license_key', $licenseKey)->first();

        if (!$license) {
            return back()->with('error', 'Lizenzschlüssel nicht gefunden! Bitte prüfen Sie das Format: JTL-XXX-12345');
        }

        // Lizenzstatus überprüfen
        $today = Carbon::today();
        $validUntil = Carbon::parse($license->valid_until);
        
        $isExpired = $today->gt($validUntil);
        $isActive = $license->status === 'active';
        $isValid = $isActive && !$isExpired;

        // Status automatisch aktualisieren falls abgelaufen
        if ($isExpired && $license->status !== 'expired') {
            $license->update(['status' => 'expired']);
        }

        $validationResult = [
            'is_valid' => $isValid,
            'license' => $license,
            'is_expired' => $isExpired,
            'days_remaining' => $isExpired ? 0 : $today->diffInDays($validUntil, false),
            'validation_date' => $today->format('d.m.Y')
        ];

        return view('licenses.validation-result', compact('validationResult'))
            ->with('success', $isValid ? 'Lizenz ist gültig!' : 'Lizenz ist ungültig!');
    }

    /**
     * @OA\Post(
     *     path="/api/validate",
     *     summary="Lizenz validieren (API)",
     *     tags={"Validierung"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"license_key"},
     *             @OA\Property(property="license_key", type="string", example="JTL-DEMO-12345")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Validierungsergebnis",
     *         @OA\JsonContent(
     *             @OA\Property(property="valid", type="boolean", example=true),
     *             @OA\Property(property="license", type="object",
     *                 @OA\Property(property="key", type="string"),
     *                 @OA\Property(property="customer", type="string"),
     *                 @OA\Property(property="product", type="string"),
     *                 @OA\Property(property="type", type="string"),
     *                 @OA\Property(property="status", type="string"),
     *                 @OA\Property(property="valid_until", type="string", format="date"),
     *                 @OA\Property(property="days_remaining", type="integer")
     *             ),
     *             @OA\Property(property="message", type="string", example="Lizenz ist gültig")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Lizenz nicht gefunden",
     *         @OA\JsonContent(
     *             @OA\Property(property="valid", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Lizenzschlüssel nicht gefunden")
     *         )
     *     )
     * )
     */
    public function apiValidateLicense(Request $request)
    {
        $request->validate([
            'license_key' => 'required|regex:/^JTL-[A-Z]+-\d{5}$/'
        ]);

        $licenseKey = $request->license_key;
        $license = License::where('license_key', $licenseKey)->first();

        if (!$license) {
            return response()->json([
                'valid' => false,
                'message' => 'Lizenzschlüssel nicht gefunden'
            ], 404);
        }

        $today = Carbon::today();
        $validUntil = Carbon::parse($license->valid_until);
        
        $isExpired = $today->gt($validUntil);
        $isActive = $license->status === 'active';
        $isValid = $isActive && !$isExpired;

        // Status aktualisieren falls nötig
        if ($isExpired && $license->status !== 'expired') {
            $license->update(['status' => 'expired']);
        }

        return response()->json([
            'valid' => $isValid,
            'license' => [
                'key' => $license->license_key,
                'customer' => $license->customer_name,
                'product' => $license->product_name,
                'type' => $license->license_type,
                'status' => $license->status,
                'valid_until' => $license->valid_until->format('Y-m-d'),
                'days_remaining' => $isValid ? $today->diffInDays($validUntil, false) : 0
            ],
            'message' => $isValid ? 'Lizenz ist gültig' : 'Lizenz ist ungültig oder abgelaufen'
        ]);
    }
}