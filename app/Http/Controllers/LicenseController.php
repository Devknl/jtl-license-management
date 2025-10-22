<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LicenseController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
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

        License::create($request->all());

        return redirect()->route('licenses.index')
            ->with('success', 'Lizenz erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     */
    public function destroy(License $license)
    {
        $license->delete();

        return redirect()->route('licenses.index')
            ->with('success', 'Lizenz erfolgreich gelöscht!');
    }

    /**
     * Zeige das Lizenzvalidierungs-Formular
     */
    public function showValidationForm()
    {
        return view('licenses.validate');
    }

    /**
     * Validiere eine Lizenz
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
     * API Endpoint für Lizenzvalidierung (für externe Services)
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